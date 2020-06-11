<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
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
    private $type;


    /**
     *@Assert\NotBlank(message="le Raison sociale est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $societe;

    /**
     *@Assert\NotBlank(message="Nom complet  est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $NOM;

   
    /**
     *@Assert\NotBlank(message="l'Email est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
    * @Assert\Length(max=8,maxMessage="Le telephone doit faire au moins {{ limit }} chiffre.")) 
     *@Assert\NotBlank(message="le numero telephone est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $numeroT;

    /**
     *@Assert\NotBlank(message="l'appareil est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $appareil;

    /**
     *@Assert\NotBlank(message="la marque  est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typ_de_panne;

    /**
     *@Assert\NotBlank(message="l'adresse est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     *@Assert\NotBlank(message="le mode de livraison  est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $livraison;

    
    /**
     *@Assert\NotBlank(message="le nombre est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    
    /**
     * @ORM\Column(type="datetime")
     */
    private $datecomm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(string $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getNOM(): ?string
    {
        return $this->NOM;
    }

    public function setNOM(string $NOM): self
    {
        $this->NOM = $NOM;

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

    public function getNumeroT(): ?string
    {
        return $this->numeroT;
    }

    public function setNumeroT(string $numeroT): self
    {
        $this->numeroT = $numeroT;

        return $this;
    }

    public function getAppareil(): ?string
    {
        return $this->appareil;
    }

    public function setAppareil(string $appareil): self
    {
        $this->appareil = $appareil;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getTypDePanne(): ?string
    {
        return $this->typ_de_panne;
    }

    public function setTypDePanne(string $typ_de_panne): self
    {
        $this->typ_de_panne = $typ_de_panne;

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

    public function getLivraison(): ?string
    {
        return $this->livraison;
    }

    public function setLivraison(string $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

  

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

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
   

     public function getdatecomm(): ?\DateTimeInterface
    {
        return $this->datecomm;
    }

    public function setdatecomm(\DateTimeInterface $datecomm): self
    {
        $this->datecomm = $datecomm;

        return $this;
}
  public function __construct()
    {
       
        $this->datecomm = new \DateTime();
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

}
