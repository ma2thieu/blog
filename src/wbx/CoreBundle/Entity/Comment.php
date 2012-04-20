<?php

namespace wbx\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Comment {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;


    public function __toString() {
        return $this->id;
    }


    public function getId() {
        return $this->id;
    }


    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }


    public function setPost(Post $post) {
        $this->post = $post;
    }

    public function getPost() {
        return $this->post;
    }

}