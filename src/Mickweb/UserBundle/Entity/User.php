<?php

namespace Mickweb\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Mickweb\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    // /**
    //  * @var string
    //  *
    //  * @ORM\Column(name="nom", type="string", length=255)
    //  */
    // private $lastname;

    /**
     * @ORM\OneToMany(targetEntity="Mickweb\EcommerceBundle\Entity\Commandes", mappedBy="user", cascade={"remove"}) 
     * @ORM\JoinColumn(nullable=true)
     */
    private $commandes;
    // One to Many : un utilisateur peut avoir plusieurs commandes
    // @ORM\JoinTable(name="mickweb_product_category")

    /**
     * @ORM\OneToMany(targetEntity="Mickweb\EcommerceBundle\Entity\UtilisateursAdresse", mappedBy="user", cascade={"remove"}) 
     * @ORM\JoinColumn(nullable=true)
     */
    private $adresses;

    public function __construct()
    {
        parent::__construct();
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->adresses = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Add commande.
     *
     * @param \Mickweb\EcommerceBundle\Entity\Commande $commande
     *
     * @return User
     */
    public function addCommande(\Mickweb\EcommerceBundle\Entity\Commandes $commandes)
    {
        $this->commandes[] = $commandes;

        return $this;
    }

    /**
     * Remove commandes.
     *
     * @param \Mickweb\EcommerceBundle\Entity\Commandes $commandes
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCommande(\Mickweb\EcommerceBundle\Entity\Commandes $commandes)
    {
        return $this->commandes->removeElement($commandes);
    }

    /**
     * Get commandes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    // /**
    //  * Set lastname.
    //  *
    //  * @param string $lastname
    //  *
    //  * @return User
    //  */
    // public function setLastname($lastname)
    // {
    //     $this->lastname = $lastname;

    //     return $this;
    // }

    // /**
    //  * Get lastname.
    //  *
    //  * @return string
    //  */
    // public function getLastname()
    // {
    //     return $this->lastname;
    // }

    /**
     * Add adresses.
     *
     * @param \Mickweb\EcommerceBundle\Entity\UtilisateursAdresse $adresses
     *
     * @return User
     */
    public function addAdress(\Mickweb\EcommerceBundle\Entity\UtilisateursAdresse $adresses)
    {
        $this->adresses[] = $adresses;

        return $this;
    }

    /**
     * Remove adresses.
     *
     * @param \Mickweb\EcommerceBundle\Entity\UtilisateursAdresse $adresses
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAdress(\Mickweb\EcommerceBundle\Entity\UtilisateursAdresse $adresses)
    {
        return $this->adresses->removeElement($adresses);
    }

    /**
     * Get adresses.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }
}
