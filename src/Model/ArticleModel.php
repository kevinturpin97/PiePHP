<?php
namespace Model;

class ArticleModel extends \Core\Entity
{
    static private array $relation = ["has many articles" => "has many tags"]; // has many ["Comment" => ["test", "test", "test"]]
    static public $info;

    public function __construct(int $id)
    {
        $handle = new \Core\ORM();
        self::$info = $handle->read("articles", $id, self::$relation);
    }
}