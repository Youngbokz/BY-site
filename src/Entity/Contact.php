<?php 

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Contact{

    /**
     * @var string|null
     * @Assert\NotBlank()
     * Assert\Length(min=2, max=50)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * Assert\Length(min=2, max=50)
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * Assert\Regex(pattern="/[0-9]{10})
     */
    private $phone;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * Assert\Email(
     *      message = "L'email '{{ value }}' n'est pas valide. Entrez une adresse valide",
     *      checkMX = true
     * )
     */
    private $email;
    /**
     * @var string|null
     * @Assert\NotBlank()
     * Assert\Length(min=10)
     */
    private $message;

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
	


}