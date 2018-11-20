<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/16/18
 * Time: 5:15 PM
 */

namespace shop\entities;


class Meta
{
    public $title;
    public $description;
    public $keywords;

    public function __construct($title, $description, $keywords)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }
}