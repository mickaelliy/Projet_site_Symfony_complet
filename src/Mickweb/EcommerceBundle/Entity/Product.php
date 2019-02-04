<?php

namespace Mickweb\EcommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Mickweb\EcommerceBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\ManyToOne(targetEntity="Mickweb\EcommerceBundle\Entity\Category", inversedBy="product", cascade={"persist"}) 
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

    // @ORM\JoinTable(name="mickweb_product_category")
    


    /**
     * @ORM\ManyToOne(targetEntity="Mickweb\EcommerceBundle\Entity\tva", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    //private $tva; // TVA à remettre...resoudre probleme
    
    /**
     * @ORM\OneToOne(targetEntity="Mickweb\EcommerceBundle\Entity\Image", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;
    // mettre le JoinColumn en annotation "oblige" à mettre une image avec le produit si nullable=false
    // @ORM\JoinColumn(nullable=false)

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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;
    // mettre a true pour cocher published par default

    /**
     * @ORM\Column(name="disponible", type="boolean")
     */
    private $disponible = true;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;




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
     * Set titre.
     *
     * @param string $titre
     *
     * @return Product
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set auteur.
     *
     * @param string $auteur
     *
     * @return Product
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur.
     *
     * @return string
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set published.
     *
     * @param bool $published
     *
     * @return Product
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published.
     *
     * @return bool
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set image.
     *
     * @param \Mickweb\EcommerceBundle\Entity\Image $image
     *
     * @return Product
     */
    public function setImage(\Mickweb\EcommerceBundle\Entity\Image $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image.
     *
     * @return \Mickweb\EcommerceBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tva = new \Doctrine\Common\Collections\ArrayCollection(); // peut etre à supprimer
        $this->date = new \Datetime();
    }

    /**
     * Add category.
     *
     * @param \Mickweb\EcommerceBundle\Entity\Category $category
     *
     * @return Product
     */
    public function addCategory(\Mickweb\EcommerceBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category.
     *
     * @param \Mickweb\EcommerceBundle\Entity\Category $category
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCategory(\Mickweb\EcommerceBundle\Entity\Category $category)
    {
        return $this->categories->removeElement($category);
    }

    /**
     * Get categories.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set prix.
     *
     * @param float $prix
     *
     * @return Product
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix.
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set disponible.
     *
     * @param bool $disponible
     *
     * @return Product
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible.
     *
     * @return bool
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set tva.
     *
     * @param \Mickweb\EcommerceBundle\Entity\tva $tva
     *
     * @return Product
     */
    public function setTva(\Mickweb\EcommerceBundle\Entity\tva $tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva.
     *
     * @return \Mickweb\EcommerceBundle\Entity\tva
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set categories.
     *
     * @param \Mickweb\EcommerceBundle\Entity\Category $categories
     *
     * @return Product
     */
    public function setCategories(\Mickweb\EcommerceBundle\Entity\Category $categories)
    {
        $this->categories = $categories;

        return $this;
    }
}
