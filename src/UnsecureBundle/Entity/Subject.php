<?php

namespace UnsecureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subject
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="UnsecureBundle\Entity\SubjectRepository")
 */
class Subject
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var User
     * 
     * @ORM\ManyToOne(targetEntity="UnsecureBundle\Entity\User", inversedBy="subjects")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $user;

     /** 
     * @var Comments[]
     * 
     * @ORM\OneToMany(targetEntity="UnsecureBundle\Entity\Comment", mappedBy="subject")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @ORM\OrderBy({"creationDate" = "DESC"})
     */
    private $comments;
    
    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=1023)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="private", type="boolean")
     */
    private $private;
    
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->creationDate = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Subject
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Subject
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return Subject
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set private
     *
     * @param boolean $private
     * @return Subject
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    
        return $this;
    }
    
    /**
     * Get private
     *
     * @return boolean
     */
    public function getPrivate()
    {
        return $this->private;
    }
    
    /**
     * Constructor
     */
    


    /**
     * Add comments
     *
     * @param \UnsecureBundle\Entity\Comment $comments
     * @return Subject
     */
    public function addComment(\UnsecureBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \UnsecureBundle\Entity\Comment $comments
     */
    public function removeComment(\UnsecureBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return Comments[] 
     */
    public function getComments()
    {
        return $this->comments;
    }
}
