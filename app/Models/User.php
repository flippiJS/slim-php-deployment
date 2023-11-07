<?php

namespace Models;

use Database\DataAccessObject;
use DateTime;
use Enums\UserType;
use Interfaces\IPersistance;
use PDO;

class User implements IPersistance
{
    public $id;
    public $user;
    public $password;
    public $userType;
    public $active;
    public $modifiedDate;

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            return null;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            echo "No existe " . $property;
        }
    }

    public static function create($user)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("INSERT INTO users (user, password, userType, active, modifiedDate) VALUES (:user, :password, :userType, true,:modifiedDate)");
        $passHash = password_hash($user->password, PASSWORD_DEFAULT);
        $request->bindValue(':user', $user->user, PDO::PARAM_STR);
        $request->bindValue(':password', $passHash);
        $request->bindValue(':userType', $user->userType, PDO::PARAM_STR);
        $date = new DateTime(date("d-m-Y"));
        $request->bindValue(':modifiedDate', date_format($date, 'Y-m-d H:i:s'));
        $request->execute();

        return $DAO->getLastId();
    }

    public static function createList($list)
    {
        foreach ($list as $u) {
            User::create($u);
        }
    }

    public static function getAll()
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("SELECT id, user, password, userType FROM users");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    public static function getOne($id)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("SELECT id, user, password, userType FROM users WHERE id = :id AND active = true");
        $request->bindValue(':id', $id, PDO::PARAM_STR);
        $request->execute();

        return $request->fetchObject('User');
    }

    public static function update($user)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("UPDATE users SET user = :user, password = :password, userType = :userType, modifiedDate = :modifiedDate WHERE id = :id AND active = true");

        $request->bindValue(':user', $user->user, PDO::PARAM_STR);
        $request->bindValue(':password', $user->password, PDO::PARAM_STR);
        $request->bindValue(':userType', $user->userType, PDO::PARAM_STR);
        $request->bindValue(':id', $user->id, PDO::PARAM_INT);
        $date = new DateTime(date("d-m-Y"));
        $request->bindValue(':modifiedDate', date_format($date, 'Y-m-d H:i:s'));
        $request->execute();
    }

    public static function delete($id)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("UPDATE users SET modifiedDate = :modifiedDate WHERE id = :id AND active = false");
        $date = new DateTime(date("d-m-Y"));
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->bindValue(':modifiedDate', date_format($date, 'Y-m-d H:i:s'));
        $request->execute();
    }

    public static function UserTypeValidation($userType)
    {
        if (   $userType != UserType::PARTNER
            && $userType != UserType::BARTENDER
            && $userType != UserType::BREWER
            && $userType != UserType::COOKER
            && $userType != UserType::WAITER
            && $userType != UserType::CANDYBAR) {
            return false;
        }
        return true;
    }

    public static function UserNameValidation($username)
    {
        $users = Usuario::getAll();

        foreach ($users as $user) {
            if ($user->user == $username) {
                return $user;
            }
        }
        return null;
    }
}