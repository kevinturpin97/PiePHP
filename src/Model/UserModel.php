<?php
namespace Model;

class UserModel extends \Core\Entity
{
    static private string $email;
    static private string $password;
    static public int $id;
    static protected $db;

    public function __construct(array $params)
    {
        self::$db = new \PDO("mysql:host=localhost;dbname=piephp", "breath", "root");
        self::$email = $params["email"];
        self::$password = $params["password"];
    }

    public function create(string $target, array $fields)
    {
        $list = [];
        foreach (self::$db->query('DESCRIBE ' . $target) as $key => $value) {
            if ($value['Field'] !== "id") {
                $list[] = $value['Field'];
            }
        }

        for ($i=0; $i < count($list); $i++) {
            if (!key_exists($list[$i], $fields)) {
                return False;
            }
        }

        $values_str = implode(",", $fields);
        $fields_str = implode(",", array_keys($fields));
        $query = "INSERT INTO " . $target . "(" . $fields_str . ") VALUES (" . $values_str . ");";

        return self::$db->exec($query);
    }

    public function read(string $target, array $fields)
    {
        $query = "SELECT " . implode(",", $fields) . " FROM " . $target . " WHERE users.id=" . self::$id;
        $list = [];

        foreach (self::$db->query($query) as $key => $value) {
            $list[] = $value;
        }

        return $list;
    }

    public function update(string $target, array $fields)
    {
        $assoc = "";
        foreach ($fields as $key => $value) {
            if (array_key_last($fields) === $key) {
                $assoc .= $key . "='" . $value . "'";
            } else {
                $assoc .= $key . "='" . $value . "', ";
            }
        }
        $query = "UPDATE " . $target . " SET " . $assoc . " WHERE users.id=" . self::$id;
        return self::$db->exec($query);
    }

    public function delete(string $target)
    {
        $query = "DELETE FROM " . $target . " WHERE users.id=" . self::$id;

        return self::$db->exec($query);
    }

    public function read_all(string $target)
    {
        $list = [];
        $query = "SELECT * FROM " . $target;

        foreach (self::$db->query($query) as $key => $value) {
            $list[] = $value;
        }

        return $list;
    }

    public function save()
    {
        $query = "INSERT INTO `users`(`email`, `password`) VALUES ('" . self::$email . "', '" . self::$password . "');";
        self::$db->exec($query);
    }

    public function login()
    {
        $query = "SELECT `id`, `email`, `password` FROM users WHERE `email` ='" . self::$email . "' AND `password`='" . self::$password . "';";
        $user = [];
        foreach (self::$db->query($query) as $key => $value) {
            $user[] = $value;
        }
        if (count($user) === 1) {
            self::$id = $user[0]["id"];
            $_SESSION['user'] = $user[0];
            return True;
        }
        return False;
    }
}