<?php

namespace Models;

use Database\DataAccessObject;
use Enums\OrderStatus;
use Interfaces\IPersistance;
use PDO;

class Order implements IPersistance
{
    public $id;
    public $tableImage;
    public $tableID;
    public $productID;
    public $clientName;
    public $status;
    public $orderTime;
    public $preparationTime;
    public $servedTime;
    public $modifiedDate;
    public $active;

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

    public static function create($order)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("INSERT INTO orders (id, tableImage, tableID, productID, clientName, status) 
                                             VALUES (:id, :tableImage, :tableID, :productID, :clientName, :status)");
        $request->bindValue(':id', $order->id, PDO::PARAM_STR);
        $request->bindValue(':tableImage', $order->tableImage, PDO::PARAM_STR);
        $request->bindValue(':tableID', $order->tableID, PDO::PARAM_INT);
        $request->bindValue(':productID', $order->productID, PDO::PARAM_INT);
        $request->bindValue(':clientName', $order->clientName, PDO::PARAM_STR);
        $request->bindValue(':status', OrderStatus::PENDING, PDO::PARAM_STR);
        $request->execute();

        return $DAO->getLastId();    }

    public static function getAll()
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("SELECT id,
                                                    tableImage,
                                                    tableID,
                                                    productID,
                                                    clientName,
                                                    status,
                                                    orderTime,
                                                    preparationTime,
                                                    servedTime,
                                                    modifiedDate FROM orders
                                                                 WHERE active = true");
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, 'Order');
    }

    public static function getOne($id)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("SELECT id, tableImage, tableID, productID, clientName, status, orderTime, preparationTime, servedTime, modifiedDate FROM orders WHERE id = :id");
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();
        return $request->fetchObject('Order');
    }

    public static function update($order)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("UPDATE orders 
                                             SET id = :id,
                                                 tableImage = :tableImage,
                                                 tableID = :tableID,
                                                 productID = :productID,
                                                 clientName = :clientName,
                                                 status = :status,
                                                 orderTime = :orderTime,
                                                 preparationTime = :preparationTime,
                                                 servedTime = :servedTime,
                                                 modifiedDate = :fechaBaja
                                             WHERE id = :id");
        $request->bindValue(':id', $order->id, PDO::PARAM_STR);
        $request->bindValue(':tableImage', $order->tableImage, PDO::PARAM_STR);
        $request->bindValue(':tableID', $order->tableID, PDO::PARAM_STR);
        $request->bindValue(':productID', $order->productID, PDO::PARAM_STR);
        $request->bindValue(':clientName', $order->clientName, PDO::PARAM_STR);
        $request->bindValue(':status', $order->status, PDO::PARAM_STR);
        $request->bindValue(':orderTime', $order->orderTime, PDO::PARAM_STR);
        $request->bindValue(':preparationTime', $order->preparationTime, PDO::PARAM_STR);
        $request->bindValue(':servedTime', $order->servedTime, PDO::PARAM_STR);
        $request->bindValue(':modifiedDate', $order->modifiedDate, PDO::PARAM_STR);
        $request->execute();
    }

    public static function delete($id)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("UPDATE orders 
                                             SET modifiedDate = :modifiedDate, 
                                                 active = false 
                                             WHERE id = :id");
        $date = new DateTime(date("d-m-Y"));
        $request->bindValue(':id', $id, PDO::PARAM_STR);
        $request->bindValue(':modifiedDate', date_format($date, 'Y-m-d H:i:s'));
        $request->execute();    }
}