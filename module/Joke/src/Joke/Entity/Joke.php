<?php

namespace Joke\Entity;


class Joke {

    private $id;
    private $title = "";
    private $text = "";
    private $postedOn = "";

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

    function __toString()
    {
        return "Joke { \n"
        . "id: " . $this->id . "\n"
        . "title: " . $this->title . "\n"
        . "text: " . $this->text . "\n"
        . "}\n";
    }


} 