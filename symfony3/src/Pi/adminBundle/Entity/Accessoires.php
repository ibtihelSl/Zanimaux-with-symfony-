<?php

namespace Pi\adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Pi\adminBundle\Entity\Magasin;
/**
 * Accessoires
 *
 * @ORM\Table(name="accessoires")
 * @ORM\Entity(repositoryClass="Pi\adminBundle\Repository\AccessoiresRepository")
 * @Vich\Uploadable
 */
class Accessoires
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     *
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;


    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Pi\adminBundle\Entity\Magasin")
     * @ORM\JoinColumn(name="id_magasin")
     *
     */
    public $id_magasin;
    /**
     * @var int
     *
     * @ORM\Column(name="nblike", type="integer", nullable=true)
     */
    private $nblike;

    /**
     * @ORM\ManyToMany(targetEntity="Pi\FrontBundle\Entity\User")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */
    private $usersLike;

    /**
     * @return int
     */
    public function getNblike()
    {
        return $this->nblike;
    }

    /**
     * @param int $nblike
     */
    public function setNblike($nblike)
    {
        $this->nblike = $nblike;
    }

    /**
     * @return mixed
     */
    public function getUsersLike()
    {
        return $this->usersLike;
    }

    /**
     * @param mixed $usersLike
     */
    public function setUsersLike($usersLike)
    {
        $this->usersLike = $usersLike;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="espece", type="string", length=255)
     */
    private $espece;

    /**
     * @return string
     */
    public function getEspece()
    {
        return $this->espece;
    }

    /**
     * @param string $espece
     */
    public function setEspece($espece)
    {
        $this->espece = $espece;
    }



    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Accessoires
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Accessoires
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @return mixed
     */
    public function getIdMagasin()
    {
        return $this->id_magasin;
    }

    /**
     * @param mixed $id_magasin
     */
    public function setIdMagasin($id_magasin)
    {
        $this->id_magasin = $id_magasin;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usersLike = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Accessoires
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add usersLike
     *
     * @param \Pi\FrontBundle\Entity\User $usersLike
     *
     * @return Accessoires
     */
    public function addUsersLike(\Pi\FrontBundle\Entity\User $usersLike)
    {
        $this->usersLike[] = $usersLike;

        return $this;
    }

    /**
     * Remove usersLike
     *
     * @param \Pi\FrontBundle\Entity\User $usersLike
     */
    public function removeUsersLike(\Pi\FrontBundle\Entity\User $usersLike)
    {
        $this->usersLike->removeElement($usersLike);
    }
}
