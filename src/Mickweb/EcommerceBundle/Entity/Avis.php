<?php

namespace Mickweb\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Avis
 *
 * @ORM\Table(name="avis")
 * @ORM\Entity(repositoryClass="Mickweb\EcommerceBundle\Repository\AvisRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Avis
{
    /**
     * @ORM\ManyToOne(targetEntity="Mickweb\EcommerceBundle\Entity\Product", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;
    // Ajout de l'entité product avec relation Many to one
    // Car on a plusieurs avis pour un produit

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
     * @ORM\Column(name="commentaire", type="text")
     */
    private $commentaire;

    /**
     * @var int
     *
     * @Assert\Range(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Vous devez mettre au moins {{ limit }} pour valider votre commentaire",
     *      maxMessage = "Vous ne pouvez pas mettre plus de {{ limit }} étoiles"
     * )
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->date = new \Datetime();
    }

    /**
     * @ORM\PrePersist
     *
     */
    public function datePrepersist()
    {
        $this->date = new \Datetime();
    }

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
     * Set commentaire.
     *
     * @param string $commentaire
     *
     * @return Avis
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire.
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set note.
     *
     * @param int $note
     *
     * @return Avis
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Avis
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set product.
     *
     * @param \Mickweb\EcommerceBundle\Entity\Product $product
     *
     * @return Avis
     */
    public function setProduct(\Mickweb\EcommerceBundle\Entity\Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return \Mickweb\EcommerceBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}
