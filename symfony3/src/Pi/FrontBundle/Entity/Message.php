<?php

namespace Pi\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="Pi\FrontBundle\Repository\MessageRepository")
 */
class Message
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
     * @ORM\Column(name="namee", type="string", length=255)
     */
    private $namee;

    /**
     * @var string
     *
     * @ORM\Column(name="emaill", type="string", length=255)
     */
    private $emaill;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;


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
     * Set namee
     *
     * @param string $namee
     *
     * @return Message
     */
    public function setNamee($namee)
    {
        $this->namee = $namee;

        return $this;
    }

    /**
     * Get namee
     *
     * @return string
     */
    public function getNamee()
    {
        return $this->namee;
    }

    /**
     * Set emaill
     *
     * @param string $emaill
     *
     * @return Message
     */
    public function setEmaill($emaill)
    {
        $this->emaill = $emaill;

        return $this;
    }

    /**
     * Get emaill
     *
     * @return string
     */
    public function getEmaill()
    {
        return $this->emaill;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Message
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Message
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }
}

