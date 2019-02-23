<?php

namespace CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use CMSBundle\Entity\Users;
use CMSBundle\Entity\Document;
use CMSBundle\Entity\Promocje;
use CMSBundle\Entity\Porady;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Util\SecureRandom;
use \DateTime;
use \DateInterval;

class DefaultController extends Controller

{

    public function basicAction($page)
    {
    	return $this->render('CMSBundle:Default:'.$page.'.html.twig');
	
    }

    public function indexAction()
    {
        return $this->render('CMSBundle:Default:index.html.twig');
    }


    public function promocjeAction()
    {   
        $promocje = new Promocje();
        $promocje =  $this->getDoctrine()->getManager()->getRepository('CMSBundle:Promocje')->findAll();
    	return $this->render('CMSBundle:Default:'.'promocje.'.'html.twig', array('promocje' => $promocje));
    }

    public function promocjeIdAction($id)
    {   
        $promocja = new Promocje();
        $promocja =  $this->getDoctrine()->getManager()->getRepository('CMSBundle:Promocje')->findOneBy(array('id' => $id));
        return $this->render('CMSBundle:Default:'.'promocja_template.'.'html.twig', array('promocja' => $promocja));
    }

    public function poradyAction()
    {
        $porady = new Porady();
        //$porady =  $this->getDoctrine()->getManager()->getRepository('CMSBundle:Porady')->findAll();
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        $qb
        ->select('p.id,p.tytul', 'p.tresc', 'd.name', 'd.path')
        ->from('CMSBundle\Entity\Porady', 'p')
        ->leftJoin('CMSBundle\Entity\Document', 'd', 'WITH', 'd.id = p.picturePath');
        $porady = $qb->getQuery()->getResult();
        //return new Response($qb->getQuery()->getResult());
        return $this->render('CMSBundle:Default:'.'porady.'.'html.twig', array('porady' => $porady));

    }

    public function poradyIdAction($id)
    {
        $porada = new Porady();
        $porada =  $this->getDoctrine()->getManager()->getRepository('CMSBundle:Porady')->findOneBy(array('id' => $id));
        return $this->render('CMSBundle:Default:'.'porada_template.'.'html.twig', array('porada' => $porada));

    }

    public function adminLogAction(){
        if($this->checkTokenAction($this->get('session')->get('token'))){
            return new RedirectResponse("/admin/index"); 
        }
        return $this->render('CMSBundle:Default:'.'admin_log.'.'html.twig');

    }

    public function adminIndexAction(){
        if($this->checkTokenAction($this->get('session')->get('token'))){
            return $this->render('CMSBundle:Default:'.'admin.'.'html.twig');
        }
        return new RedirectResponse("/admin"); 
    }

    public function adminPromocjeAction(){
        if($this->checkTokenAction($this->get('session')->get('token'))){
            return $this->render('CMSBundle:Default:'.'admin_promocja.'.'html.twig');
        }
        return new RedirectResponse("/admin"); 
    }

    public function adminPoradyAction(Request $request){
        if($this->checkTokenAction($this->get('session')->get('token'))){
           
            return $this->render('CMSBundle:Default:'.'admin_porada.'.'html.twig');
        }
        return new RedirectResponse("/admin"); 
    }


    public function loginAction(Request $request)
    {
        
        $isUser = $this->findUserByLogPassw($request->get("login"),sha1($request->get("haslo")));
        if($isUser){
            $token = $this->tokenGen(15);
            $this->get('session')->set('token', $token);

            $this->addToken($token,$isUser->getId());
            header("HTTP/1.1 200 OK");
            return new RedirectResponse("/admin/index"); 
        }
        else{
            echo "Błędna nazwa użytkownika lub hasło.";
            exit;
        }
        
    }

    public function adminUstawieniaAction()
    {
        if($this->checkTokenAction($this->get('session')->get('token'))){
            return $this->render('CMSBundle:Default:'.'admin_ustawienia.'.'html.twig', array('info' => ""));
        }
        return new RedirectResponse("/admin"); 
    }


    public function adminAddPromocjaAction(Request $request){
        if($this->checkTokenAction($this->get('session')->get('token'))){
            $promocja = new Promocje();
            $promocja->setTytul($request->get('tytul'));
            $promocja->setTresc($request->get('tresc'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->merge($promocja);
            $entityManager->flush();
            return new RedirectResponse("/admin/promocja"); 
        }
        return new RedirectResponse("/admin"); 
    }

    public function adminAddPoradaAction(Request $request){
        if($this->checkTokenAction($this->get('session')->get('token'))){
            $document = new Document();
            $porady = new Porady();
            $entityManager = $this->getDoctrine()->getManager();
            
            if($request->files->get('file_upload')){
                $name = $this->tokenGen(15);
                $file = $request->files->get('file_upload');
                $orig_name = $file->getClientOriginalName();
                $full_name = $name.".".pathinfo($orig_name, PATHINFO_EXTENSION);
                $file = $file->move(__DIR__.'/../../../web/bundles/framework/uploads', $full_name);
                $document->setName($orig_name);
                $document->file = $file;
                $document->setPath($full_name);
                $entityManager->persist($document);
                $entityManager->flush();
                $porady->setPicturePath($document->getId());
            }
            else{
                $porady->setPicturePath(1);
            }

            $porady->setTytul($request->get('tytul'));
            $porady->setTresc($request->get('tresc'));
            $entityManager->persist($porady);
            $entityManager->flush();
            return new RedirectResponse("/admin/index");
        }
        return new RedirectResponse("/admin"); 
    }


    public function updateUser(Request $request){
        $user = new Users();
        $user =  $this->getDoctrine()->getManager()->getRepository('CMSBundle:Users')->findOneBy(array('token' => $this->get('session')->get('token')));
        if($request->get('login')){
            $user->setLogin($request->get('login'));
        }
        if($request->get('haslo')){
            $user->setHaslo($request->get('haslo'));
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->merge($user);
        $entityManager->flush();
        return new RedirectResponse("/admin/ustawienia"); 
    }

    public function logoutAction(){
        $user = new Users();
        $user =  $this->getDoctrine()->getManager()->getRepository('CMSBundle:Users')->findOneBy(array('token' => $this->get('session')->get('token')));
        $user->setToken('');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->merge($user);
        $entityManager->flush();
        return new RedirectResponse("/admin"); 
    }

    public function uploadAction(Request $request)
    {
        $document = new Document();
        $form = $this->createFormBuilder($document)
            ->add('name')
            ->add('file')
            ->getForm();

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                echo "jestem";
                $em = $this->getDoctrine()->getEntityManager();
                $document->upload();
                $em->persist($document);
                $em->flush();

                $this->redirect($this->generateUrl('/admin/index'));
            }
        }

        return array('form' => $form->createView());
        //return new Response($request->request->get("name"));
    }

    private function findUserByLogPassw($login, $passw){
        return $this->getDoctrine()
                ->getRepository('CMSBundle:Users')
                ->findOneBy(array('login' => $login, 'haslo' => $passw));
    }

    private function tokenGen($length)
    {
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[rand(0, $max)];
        }
        return $str;
    }

    private function addToken($token, $id){
        $date = new DateTime();
        $date->add(new DateInterval("P1D"));
        $user = new Users();
        $user = $this->getDoctrine()
        ->getRepository('CMSBundle:Users')
        ->findOneBy(array('id' => $id));
        $user->setToken($token);    
        $user->setTokenExpire($date);   
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->merge($user);
        $entityManager->flush();
    }

    public function checkTokenAction($token){
        if($this->checkUser($token)){
            return true;
        }
        return false;
    }

    public function checkUser($token){
        $user = new Users();
        $user =  $this->getDoctrine()->getManager()->getRepository('CMSBundle:Users')->findOneBy(array('token' => $token));
        
        if($user && $user->getTokenExpire() && $user->getTokenExpire()->format('Y-m-d H:i:s') > date('Y-m-d H:i:s', time())){
            return true;
        }
        return false;
    }

    public function findUser($token){

    }
}
