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

    /**
     * @ORM\OneToMany(targetEntity="PostFile", mappedBy="post", cascade={"all"}, orphanRemoval=true)
     */
    protected $files;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", cascade={"all"}, orphanRemoval=true)
     */
    protected $comments;


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


    public function addFile(PostFile $file) {
        $file->setPost($this);
        $this->files[] = $file;
    }

    public function removeFile(PostFile $file) {
        // TODO
    }

    public function getFiles() {
        return $this->files;
    }

    public function setFiles($files) {
        foreach ($files as $file) {
            $file->setPost($this);
        }
        $this->files = $files;
    }


    public function addComment(Comment $comment) {
        $comment->setPost($this);
        $this->comments[] = $comment;
    }

    public function removeComment(Comment $comment) {
        // TODO
    }

    public function getComments() {
        return $this->comments;
    }

    public function setComments($comments) {
        foreach ($comments as $comment) {
            $comment->setPost($this);
        }
        $this->comments = $comments;
    }

}