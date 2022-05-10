<?php
namespace Model;

class TagModel
{
    static private array $relation = ["has many tags" => "has many articles"];
    static private $info;

    public function __construct(int $id)
    {
        self::$info = new \Core\ORM();
        self::$info = self::$info->read("tags", $id, self::$relation);
    }
}

