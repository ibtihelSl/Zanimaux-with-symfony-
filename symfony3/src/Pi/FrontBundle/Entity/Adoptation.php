<?php

namespace Pi\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adoptation
 *
 * @ORM\Table(name="adoptation")
 * @ORM\Entity(repositoryClass="Pi\FrontBundle\Repository\AdoptationRepository")
 */
class Adoptation
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
     * @ORM\Column(name="nomprop", type="string", length=255)
     */
    private $nomprop;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="espece", type="string", length=255)
     */
    private $espece;



    /**
     * Many Users have One Departement.
     * @ORM\ManyToOne(targetEntity="Pi\FrontBundle\Entity\User",inversedBy="Adoptation")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomprop
     *
     * @param string $nomprop
     *
     * @return Adoptation
     */
    public function setNomprop($nomprop)
    {
        $this->nomprop = $nomprop;

        return $this;
    }

    /**
     * Get nomprop
     *
     * @return string
     */
    public function getNomprop()
    {
        return $this->nomprop;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Adoptation
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Animaux")
     * @ORM\JoinColumn(name="fk_post", referencedColumnName="id")
     */

    private $animaux;


    /**
     * @return mixed
     */
    public function getAnimaux()
    {
        return $this->animaux;
    }

    /**
     * @param mixed $animaux
     */
    public function setAnimaux($animaux)
    {
        $this->animaux = $animaux;
    }



}

