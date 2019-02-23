<?php

namespace CMSBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 */
class Document
{
    /**
     * @var int
     */
    
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Document
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/files';
    }

    public function preUpload()
    {
        if (null !== $this->file) {
            // zrób cokolwiek chcesz aby wygenerować unikalną nazwę
            $this->setPath(uniqid().'.'.$this->file->guessExtension());
        }
    }

    public function upload()
    {
        // zmienna file może być pusta jeśli pole nie jest wymagane
        if (null === $this->file) {
            return;
        }

        // używamy oryginalnej nazwy pliku ale nie powinieneś tego robić
        // aby zabezpieczyć się przed ewentualnymi problemami w bezpieczeństwie

        // metoda move jako atrybuty przyjmuje ścieżkę docelową gdzie trafi przenoszony plik
        // oraz ścieżkę z której ma przenieś plik
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // ustaw zmienną patch ścieżką do zapisanego pliku
        $this->setPath($this->file->getClientOriginalName());

        // wyczyść zmienną file ponieważ już jej nie potrzebujemy
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    
}

