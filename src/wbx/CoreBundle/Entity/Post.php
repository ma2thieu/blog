<?php

namespace wbx\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Sluggable\Sluggable;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Post {

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @ORM\Column(name="text", type="text")
     * @Gedmo\Translatable
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="Author")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;


    public function __toString() {
        return $this->title;
    }


    public function getId() {
        return $this->id;
    }


    public function getSlug() {
        return $this->slug;
    }


    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }


    public function getText() {
        return $this->text;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function getSummary($limit = 100) {
        $str = strip_tags($this->getText());

        if (strlen($str) > $limit) {
            return substr($str, 0, strrpos(substr($str, 0, $limit), ' ')) . ' ...';
        }

        return $str;
    }


    public function setAuthor(Author $author) {
        $this->author = $author;
    }

    public function getAuthor() {
        return $this->author;
    }

}