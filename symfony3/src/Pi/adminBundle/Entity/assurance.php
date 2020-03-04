<?php

namespace Pi\adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * assurance
 *
 * @ORM\Table(name="assurance")
 * @ORM\Entity(repositoryClass="Pi\adminBundle\Repository\assuranceRepository")
 */
class assurance
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
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="age_de_ce_animal", type="string", length=255)
     */
    private $ageDeCeAnimal;

    /**
     * @var float
     *
     * @ORM\Column(name="totalprix", type="float")
     */
    private $totalprix;
    /**
     * @var float
     *
     * @ORM\Column(name="prixparanimaux", type="float")
     */
    private $prixparanimaux;

    /**
     * @return float
     */
    public function getPrixparanimaux()
    {
        return $this->prixparanimaux;
    }

    /**
     * @param float $prixparanimaux
     */
    public function setPrixparanimaux($prixparanimaux)
    {
        $this->prixparanimaux = $prixparanimaux;
    }

    /**
     * @return float
     */
    public function getTotalprix()
    {
        return $this->totalprix;
    }

    /**
     * @param float $totalprix
     */
    public function setTotalprix($totalprix)
    {
        $this->totalprix = $totalprix;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="type_de_ce_animal", type="string", length=255)
     */
    private $typeDeCeAnimal;


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
     * @return assurance
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return assurance
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }


    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return assurance
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return assurance
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ageDeCeAnimal
     *
     * @param string $ageDeCeAnimal
     *
     * @return assurance
     */
    public function setAgeDeCeAnimal($ageDeCeAnimal)
    {
        $this->ageDeCeAnimal = $ageDeCeAnimal;

        return $this;
    }

    /**
     * Get ageDeCeAnimal
     *
     * @return string
     */
    public function getAgeDeCeAnimal()
    {
        return $this->ageDeCeAnimal;
    }

    /**
     * Set typeDeCeAnimal
     *
     * @param string $typeDeCeAnimal
     *
     * @return assurance
     */
    public function setTypeDeCeAnimal($typeDeCeAnimal)
    {
        $this->typeDeCeAnimal = $typeDeCeAnimal;

        return $this;
    }

    /**
     * Get typeDeCeAnimal
     *
     * @return string
     */
    public function getTypeDeCeAnimal()
    {
        return $this->typeDeCeAnimal;
    }


}

