<?php

namespace wbx\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Sluggable\Sluggable;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Author {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(targetEntity="\wbx\CoreBundle\Entity\Post", mappedBy="author")
     */
    protected $posts;


    /**
     *  Constructor
     */
    public function __construct() {
        $this->posts = new ArrayCollection();
    }


    public function __toString() {
        return $this->firstname . " " . $this->lastname;
    }


    public function getId() {
        return $this->id;
    }


    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getFirstname() {
        return $this->firstname;
    }


    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function getLastname() {
        return $this->lastname;
    }


    public function addPost(Post $post) {
        $this->posts[] = $post;
    }

    public function getPosts() {
        return $this->posts;
    }


}