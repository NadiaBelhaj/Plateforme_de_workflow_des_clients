<?php
 
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OffreRepository")
 */
class Offre
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
     * @Assert\NotBlank(message="l'Email est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @Assert\Length(max=8,maxMessage="Le telephone doit faire au moins {{ limit }} chiffre.")) 
     * @Assert\NotBlank(message="le  numero telephone   est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $numerot;

    /**
     * @Assert\NotBlank(message="la date debut  est obligatoire")
     * @ORM\Column(type="datetime")
     */
    private $dateD;

    /**
     * @Assert\NotBlank(message="la date debut est obligatoire")
     * @ORM\Column(type="datetime")
     */
    private $datef;
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
       * @Assert\NotBlank(message="le nom et prenom  est obligatoire")
     * @ORM\Column(type="string", length=255)
     */
    private $NOM;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSociete(): ?string
    {
        return $this->societe;
    }

    public function setSociete(string $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getNumerot(): ?string
    {
        return $this->numerot;
    }

    public function setNumerot(string $numerot): self
    {
        $this->numerot = $numerot;

        return $this;
    }

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->dateD;
    }

    public function setDateD(\DateTimeInterface $dateD): self
    {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDatef(): ?\DateTimeInterface
    {
        return $this->datef;
    }

    public function setDatef(\DateTimeInterface $datef): self
    {
        $this->datef = $datef;

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

    public function getNOM(): ?string
    {
        return $this->NOM;
    }

    public function setNOM(string $NOM): self
    {
        $this->NOM = $NOM;

        return $this;
    }
}
