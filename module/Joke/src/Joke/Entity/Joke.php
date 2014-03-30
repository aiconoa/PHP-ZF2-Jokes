<?php

namespace Joke\Entity;


use User\Entity\User;

class Joke {

    private $id = null;
    private $title = "";
    private $text = "";
    private $postedOn = null;
    private $authorId;

    //we will soon add $category and $author

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $postedOn
     */
    public function setPostedOn($postedOn)
    {
        $this->postedOn = $postedOn;
    }

    /**
     * @return string
     */
    public function getPostedOn()
    {
        return $this->postedOn;
    }


    /**
     * @param int $authorId
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }

    /**
     * @return int author id
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function __toString()
    {
        return "Joke { \n"
        . "id: " . $this->id . "\n"
        . "title: " . $this->title . "\n"
        . "text: " . $this->text . "\n"
        . "author_id: " . $this->authorId . "\n"
        . "}\n";
    }

    /**
     * @return array
     */
    public function getArrayCopy() {
        return  array(
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'posted_on' => $this->postedOn,
            'author_id' => $this->authorId,
        );
    }


} 