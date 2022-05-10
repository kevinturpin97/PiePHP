<?php
namespace Model;

class CommentModel extends \Core\Entity
{
    static private array $relation = ["has many comment" => "has one articles"]; // has one ["Article" => "Test"]
    static public $info;

    public function __construct(int $id)
    {
        self::$info = new \Core\ORM();
        self::$info = self::$info->read("comment", $id, self::$relation);
    }
}