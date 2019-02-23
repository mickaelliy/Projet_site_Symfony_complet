<?php

namespace Mickweb\EcommerceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch 
{   
    /**
    * @var int|null
    * @Assert\Range( 
    *                max=200, 
    *                maxMessage = "le tarif le plus élevé est de {{ limit }} €")
    */
    private $maxPrice;

    /**
    * @var int|null
    * @Assert\Range(min=5, 
    *                minMessage = "le tarif le plus bas est de {{ limit }} €")
    */
    private $minPrice;

    /**
     * Set maxPrice.
     *
     * @param int|null $maxPrice
     *
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get maxPrice.
     *
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * Set minPrice.
     *
     * @param int|null $minPrice
     *
     * @return PropertySearch
     */
    public function setMinPrice(int $minPrice): PropertySearch
    {
        $this->minPrice = $minPrice;

        return $this;
    }

    /**
     * Get minPrice.
     *
     * @return int|null
     */
    public function getMinPrice(): ?int
    {
        return $this->minPrice;
    }

}