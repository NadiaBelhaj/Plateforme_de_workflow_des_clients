<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ProspectRepository")

 */
class Prospect
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    
    /**
   
     * @ORM\Column(type="string", length=255)
     */
    private $contact_name;

    /**
    
     * @ORM\Column(type="string", length=255)
     */
    private $company;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contact_position;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @Assert\Length(max=8,maxMessage="Le telephone doit faire au moins {{ limit }} chiffre.")) 
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

   
    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pourcentage_avan;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;


     public function __construct()
    {
        $this->etat = true;
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    

    public function getContactName(): ?string
    {
        return $this->contact_name;
    }

    public function setContactName(string $contact_name): self
    {
        $this->contact_name = $contact_name;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getContactPosition(): ?string
    {
        return $this->contact_position;
    }

    public function setContactPosition(string $contact_position): self
    {
        $this->contact_position = $contact_position;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

   
    

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

   
    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

   

    public function getPourcentageAvan(): ?string
    {
        return $this->pourcentage_avan;
    }

    public function setPourcentageAvan(string $pourcentage_avan): self
    {
        $this->pourcentage_avan = $pourcentage_avan;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
     public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

   
}
