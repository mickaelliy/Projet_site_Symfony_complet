<?php

namespace Mickweb\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="Mickweb\EcommerceBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;

    /**************************************/
    private $file;

    // attribut qui stocke le nom du fichier temporairement
    private $tempFilename;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt.
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt.
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        // verif si on avait deja un fichier pour cette entité
        if (null !== $this->url) {
            // sauvegarde l'extension du fichier pour le supprimer plus tard
            $this->tempFilename = $this->url;

            // reinitialise les valeurs des attributs url et alt
            $this->url = null;
            $this->alt = null;
        }
    }

    /**********************************************/    
    // méthode qui sert à récupérer un fichier
    /**********************************************/ 

    /** 
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // si auncun fichier, on ne fait rien
        if (null === $this->file) {
            return;
        }

        //le nom du fichier est son id, on renomme cet attribut "extension" plutot  que "url"
        $this->url = $this->file->guessExtension();

        //génère l'attribut alt de la balise <img>, à la valeur du nom du fichier
        $this->alt = $this->file->getClientOriginalName();
    }
    
    /** 
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // si auncun fichier, on ne fait rien
        if (null === $this->file) {
            return;
        }

        // si on avait un ancien fichier, on le supprime
        if (null !== $this->tempFilename) {
            $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        /*
        // récupère le nom original du fichier 
        $name = $this->file->getClientOriginalName();
        */

        // déplace le fichier dans le repertoire voulu
        $this->file->move(
            $this->getUploadRootDir(),  // repertoire de destination
            $this->id.'.'.$this->url    // nom du fichier à créer, ici "id.extension"
        );

        /*
        // sauvegarde le nom du fichier dans l'attribut $url
        $this->url = $name;

        // crée le futur attribut alt de la balise image
        $this->alt = $name;
        */
    }

    /** 
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // sauvegarde trmporairerement le nom du fichier
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
    }

    /** 
     * @ORM\PostRemove()
     */
    public function RemoveUpload()
    {
        // on a pas accès à l'id, on utilise notre nom sauvegardé
        if (file_exists($this->tempFilename)) {
            // on supprime le fichier
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir()
    {
        // retourne le chemin relatif vers l'image (relatif au repertoire /web)
        return 'uploads/img';
    }

    public function getUploadRootDir()
    {
        // retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
    return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
}
