<?php
namespace Core;

class Entity
{
    public string $titre;
    public string $content;
    public string $author;

    public function __construct(array $fields)
    {
        autoload('ORM');
        if (key_exists("id", $fields)) {
            $value = new ORM();
            $fields = $value->read($fields["table"], $fields["id"]);
        }

        $this->titre = $fields["titre"];
        $this->content = $fields["content"];
        $this->author = $fields["author"];

    }
}

