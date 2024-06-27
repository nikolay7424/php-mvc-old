<?php

namespace App\Models;

use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
    public $errors = [];
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public function save()
    {
        $this->validate();
        if (empty($this->errors)) {
            $this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password_hash)
                VALUES (:name, :email, :password_hash)";
            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(":name", $this->name, PDO::PARAM_STR);
            $stmt->bindValue(":email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue(":password_hash", $this->password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }
        return false;
    }

    public function validate()
    {
        if ($this->name === '') {
            $this->errors[] = "Name is required";
        }
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = "Invalid email";
        }
        if (static::emailExists($this->email)) {
            $this->errors[] = "Email already taken";
        }
        if (strlen($this->password) < 6) {
            $this->errors[] = "Please enter at least 6 characters for the password";
        }
        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = "Password needs at least one letter";
        }
        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = "Password needs at least one number";
        }

    }

    public static function emailExists($email)
    {
       return static::findByEmail($email) !== false;
    }

    public static function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function authenticate($email, $password)
    {
        $user = User::findByEmail($email);
        if ($user) {
            if (password_verify($password, $user->password_hash)) {
                return $user;
            }
        }
        return false;
    }

    public static function findById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
}
