<?php
namespace Core;

class ORM
{
    static protected $db;
    static private array $table;

    public function __construct()
    {
        self::$db = new \PDO("mysql:host=localhost;dbname=piephp", "breath", "root");
    }

    public function create(string $table, array $fields)
    {
        $head = implode(", ", array_keys($fields));
        $values = "";
        foreach ($fields as $key => $value) {
            if (gettype($value) === "string") {
                if ($key === array_key_last($fields)) {
                    $values .= "'" . $value . "'";
                } else {
                    $values .= "'" . $value . "', ";
                }
            } else if (gettype($value) === ("integer" || "float" || "boolean" || "double")) {
                if ($key === array_key_last($fields)) {
                    $values .= $value;
                } else {
                    $values .= $value . ", ";
                }
            }
        }
        $query = "INSERT INTO " . $table . " (" . $head . ") VALUES (" . $values . ")";
        // echo $query; // DEBUG MODE
        self::$db->exec($query);
        return self::$db->lastInsertId();
    }

    public function read(string $table, int $id, array $relation = [])
    {
        if (count($relation) !== 0) {
            $query = "SELECT * FROM " . $table . " ";
            foreach ($relation as $key => $value) {
                if (preg_match("/has many/", $value)) {
                    if (preg_match("/has many/", $key)) {
                        $value = explode(" ", $value);
                        $value = $value[array_key_last($value)];
                        $pivot = $value . "_" . $table;
                        $query .= "INNER JOIN " . $pivot . " ON " . $pivot . ".id_" . substr($table, 0, -1) . " = " . $table . ".id ";
                        $query .= "INNER JOIN " . $value . " ON " . $value . ".id = " . $pivot . ".id_" . substr($value, 0, -1) . " ";
                    } else {
                        goto a;
                    }
                } else if (preg_match("/has one/", $value)) {
                    a:
                    $value = explode(" ", $value);
                    $value = $value[array_key_last($value)];
                    $query .= "INNER JOIN " . $value . " ON " . $value . ".id = " . $table . ".id ";
                }
            }

            $query .= "WHERE " . $table . ".id = " . $id;
        } else {
            $query = "SELECT * FROM " . $table . " WHERE `id`=" . $id;
        }

        var_dump($query);
        foreach (self::$db->query($query) as $key => $value) {
            return $value;
        }
    }

    public function update(string $table, int $id, array $fields)
    {
        $values = "";
        foreach ($fields as $key => $value) {
            if (gettype($value) === "string") {
                if ($key === array_key_last($fields)) {
                    $values .= "`" . $key . "`='" . $value . "'";
                } else {
                    $values .= "`" . $key . "`='" . $value . "', ";
                }
            } else if (gettype($value) === ("integer" || "float" || "boolean" || "double")) {
                if ($key === array_key_last($fields)) {
                    $values .= "`" . $key . "`=" . $value;
                } else {
                    $values .= "`" . $key . "`=" . $value . ", ";
                }
            }
        }
        $query = "UPDATE `" . $table . "` SET " . $values . " WHERE `id`=" . $id;
        return self::$db->exec($query);
    }

    public function delete(string $table, int $id)
    {
        $query = "DELETE FROM " . $table . " WHERE `id`=" . $id;
        return self::$db->exec($query);
    }

    public function find(
        string $table, 
        array $params = array(
            'WHERE' => '1',
            'ORDER BY' => 'id ASC',
            'LIMIT' => ''
        ),
        array $relation = []
    )
    {
        
        $params_str = "";
        foreach ($params as $key => $value) {
            $params_str .= " ". $key . " " . $value;
        }

        if (count($relation) !== 0) {
            $query = "SELECT * FROM " . $table . " ";
            foreach ($relation as $key => $value) {
                if (preg_match("/has many/", $value)) {
                    if (preg_match("/has many/", $key)) {
                        $value = explode(" ", $value);
                        $value = $value[array_key_last($value)];
                        $pivot = $value . "_" . $table;
                        $query .= "INNER JOIN " . $pivot . " ON " . $pivot . ".id_" . substr($table, 0, -1) . " = " . $table . ".id ";
                        $query .= "INNER JOIN " . $value . " ON " . $value . ".id = " . $pivot . ".id_" . substr($value, 0, -1) . " ";
                    } else {
                        goto a;
                    }
                } else if (preg_match("/has one/", $value)) {
                    a:
                    $value = explode(" ", $value);
                    $value = $value[array_key_last($value)];
                    $query .= "INNER JOIN " . $value . " ON " . $value . ".id = " . $table . ".id ";
                }
            }
        } else {
            $query = "SELECT * FROM " . $table;
        }

        $query .= $params_str;
        
        $list = [];
        foreach (self::$db->query($query) as $key => $value) {
            foreach ($value as $key => $val) {
                if (is_string($key)) {
                    $list[] = $val;
                }
            }
        }
        return $list;
        // var_dump($list);
    }
}