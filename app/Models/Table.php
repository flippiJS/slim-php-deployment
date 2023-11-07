<?php

namespace Models;

use Database\DataAccessObject;
use Enums\TableStatus;
use Interfaces\IPersistance;
use PDO;

class Table implements IPersistance
{
    public $id;
    public $status;

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

    public static function create($object)
    {
        $code = Table::generateCode(5);
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("INSERT INTO tables (id, status) VALUES (:id, :status)");
        $request->bindValue(':id', $code, PDO::PARAM_STR);
        $request->bindValue(':status', TableStatus::CLOSE, PDO::PARAM_STR);
        $request->execute();
        return $DAO->getLastId();
    }

    public static function getAll()
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("SELECT id, status FROM tables WHERE status != TableStatus::BAJA");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_CLASS, 'Table');
    }

    public static function getOne($id)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("SELECT id, status FROM tables WHERE id = :id");
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchObject('Table');
    }

    public static function update($table)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("UPDATE tables SET status = :status WHERE id = :id");
        $request->bindValue(':id', $table->id, PDO::PARAM_INT);
        $request->bindValue(':status', $table->estado, PDO::PARAM_STR);
        $request->execute();
    }

    public static function delete($id)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("UPDATE tables SET status = :status WHERE id = :id");
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->bindValue(':status', TableStatus::DOWN, PDO::PARAM_STR);
        $request->execute();
    }

    private static function generateCode($length)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $code = "";

        for ($i = 0; $i < $length; $i++) {
            $code .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $code;
    }
}