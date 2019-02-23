<?php

namespace Mickweb\EcommerceBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact 
{   
    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Length(min=2, max=100) 
    */
    private $firstname;

    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Length(min=2, max=100) 
    */
    private $lastname;

    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Regex(
    *  pattern="/[0-9]{10}/"
    *  ) 
    */
    private $phone;

    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Email() 
    */
    private $email;

    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Length(min=10) 
    */
    private $message;

    // /**
    // * @var Product|null
    // * 
    // */
    // private $product;
    
    /**
     * Set firstname.
     *
     * @param string|null $firstname
     *
     * @return Contact
     */
    public function setFirstname(?string $firstname): Contact
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string|null $lastname
     *
     * @return Contact
     */
    public function setLastname(?string $lastname): Contact
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return Contact
     */
    public function setPhone(?string $phone): Contact
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set message.
     *
     * @param string|null $message
     *
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    // /**
    //  * Set product.
    //  *
    //  * @param Product|null $product
    //  *
    //  * @return Contact
    //  */
    // public function setProduct(?Product $product): Contact
    // {
    //     $this->product = $product;

    //     return $this;
    // }

    // /**
    //  * Get product.
    //  *
    //  * @return Product|null
    //  */
    // public function getProduct(): ?Product
    // {
    //     return $this->product;
    // }


}