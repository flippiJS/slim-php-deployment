<?php

namespace Models;

use Database\DataAccessObject;
use Interfaces\IPersistance;
use PDO;

class Table implements IPersistance
{
    public $id;
    public $tableNumber;
    public $status;

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

    public static function create($object)
    {
        // TODO: Implement create() method.
    }

    public static function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public static function getOne($value)
    {
        // TODO: Implement getOne() method.
    }

    public static function update($object)
    {
        // TODO: Implement update() method.
    }

    public static function delete($object)
    {
        // TODO: Implement delete() method.
    }
}