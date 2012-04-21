<?php

namespace wbx\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class PostFile {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="File", cascade={"all"})
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="files")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;


    public function __toString() {
        return $this->getFile() ? $this->getFile()->getName() : "no file";
    }



    public function getId() {
        return $this->id;
    }


    public function setFile(File $file) {
        $this->file = $file;
    }

    public function getFile() {
        return $this->file;
    }


    public function setPost(Post $post) {
        $this->post = $post;
    }

    public function getPost() {
        return $this->post;
    }

}