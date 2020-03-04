<?php

namespace Pi\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Pi\FrontBundle\Repository\commentRepository")
 */
class comment
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
     * @ORM\Column(name="message", type="string", length=500)
     */
    private $message;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_time", type="date")
     */
    private $lastTime;

    /**
     * @ORM\ManyToOne(targetEntity="Pi\adminBundle\Entity\Article")
     * @ORM\JoinColumn(name="article_id",referencedColumnName="id")
     *
     */
    public $article_id;

    /**
     * @ORM\ManyToOne(targetEntity="Pi\FrontBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id",referencedColumnName="id")
     *
     */
    public $user_id;

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
     * Set message
     *
     * @param string $message
     *
     * @return comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getLastTime()
    {
        return $this->lastTime;
    }

    /**
     * @param mixed $lastTime
     */
    public function setLastTime($lastTime)
    {
        $this->lastTime = $lastTime;
    }



    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->article_id;
    }

    /**
     * @param mixed $article_id
     */
    public function setArticleId($article_id)
    {
        $this->article_id = $article_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }



}

