<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevDebugProjectContainerUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        // cms_homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'cms_homepage');
            }

            return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::indexAction',  '_route' => 'cms_homepage',);
        }

        if (0 === strpos($pathinfo, '/ad')) {
            if (0 === strpos($pathinfo, '/admin')) {
                // cms_admin_log
                if ($pathinfo === '/admin') {
                    return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::adminLogAction',  '_route' => 'cms_admin_log',);
                }

                // cms_admin_index
                if ($pathinfo === '/admin/index') {
                    return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::adminIndexAction',  '_route' => 'cms_admin_index',);
                }

                // cms_admin_ustawienia
                if ($pathinfo === '/admin/ustawienia') {
                    return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::adminUstawieniaAction',  '_route' => 'cms_admin_ustawienia',);
                }

                if (0 === strpos($pathinfo, '/admin/p')) {
                    // cms_admin_promocje
                    if ($pathinfo === '/admin/promocja') {
                        return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::adminPromocjeAction',  '_route' => 'cms_admin_promocje',);
                    }

                    // cms_admin_porady
                    if ($pathinfo === '/admin/porada') {
                        return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::adminPoradyAction',  '_route' => 'cms_admin_porady',);
                    }

                }

            }

            if (0 === strpos($pathinfo, '/addP')) {
                // cms_admin_add_promotion
                if ($pathinfo === '/addPromocja') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_cms_admin_add_promotion;
                    }

                    return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::adminAddPromocjaAction',  '_route' => 'cms_admin_add_promotion',);
                }
                not_cms_admin_add_promotion:

                // cms_admin_add_tip
                if ($pathinfo === '/addPorada') {
                    if ($this->context->getMethod() != 'POST') {
                        $allow[] = 'POST';
                        goto not_cms_admin_add_tip;
                    }

                    return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::adminAddPoradaAction',  '_route' => 'cms_admin_add_tip',);
                }
                not_cms_admin_add_tip:

            }

        }

        if (0 === strpos($pathinfo, '/log')) {
            // cms_login
            if ($pathinfo === '/login') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_cms_login;
                }

                return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::loginAction',  '_route' => 'cms_login',);
            }
            not_cms_login:

            // cms_logout
            if ($pathinfo === '/logout') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_cms_logout;
                }

                return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::logoutAction',  '_route' => 'cms_logout',);
            }
            not_cms_logout:

        }

        // cms_upload
        if ($pathinfo === '/upload') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_cms_upload;
            }

            return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::uploadAction',  '_route' => 'cms_upload',);
        }
        not_cms_upload:

        if (0 === strpos($pathinfo, '/raty_promocje/promocje')) {
            // cms_promocje
            if (rtrim($pathinfo, '/') === '/raty_promocje/promocje') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'cms_promocje');
                }

                return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::promocjeAction',  '_route' => 'cms_promocje',);
            }

            // cms_promocje_id
            if (preg_match('#^/raty_promocje/promocje/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cms_promocje_id')), array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::promocjeIdAction',));
            }

        }

        if (0 === strpos($pathinfo, '/porady')) {
            // cms_porady
            if ($pathinfo === '/porady') {
                return array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::poradyAction',  '_route' => 'cms_porady',);
            }

            // cms_porady_id
            if (preg_match('#^/porady/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'cms_porady_id')), array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::poradyIdAction',));
            }

        }

        // cms_basic
        if (preg_match('#^/(?P<page>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'cms_basic')), array (  '_controller' => 'CMSBundle\\Controller\\DefaultController::basicAction',));
        }

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
