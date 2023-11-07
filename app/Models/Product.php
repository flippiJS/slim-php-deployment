<?php

namespace Models;

use Database\DataAccessObject;
use Enums\ProductType;
use Interfaces\IPersistance;
use PDO;

class Product implements IPersistance
{
    public $id;
    public $description;
    public $productType;
    public $price;
    public $stock;
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

    public static function create($product)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("INSERT INTO products (description, productType, price, stock, active, modifiedDate) VALUES (:description, :productType, :price, :stock, true, :modifiedDate)");
        $request->bindValue(':description', $product->description, PDO::PARAM_STR);
        $request->bindValue(':productType', $product->productType, PDO::PARAM_STR);
        $request->bindValue(':price', $product->price, PDO::PARAM_STR);
        $request->bindValue(':stock', $product->stock, PDO::PARAM_INT);
        $date = new DateTime(date("d-m-Y"));
        $request->bindValue(':modifiedDate', date_format($date, 'Y-m-d H:i:s'));
        $request->execute();

        return $DAO->getLastId();
    }

    public static function createList($list)
    {
        foreach ($list as $u) {
            Product::create($u);
        }
    }

    public static function getAll()
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("SELECT id, description, productType, price, stock FROM products WHERE active = true ");
        $request->execute();

        return $request->fetchAll(PDO::FETCH_CLASS, 'Product');    }

    public static function getOne($id)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("SELECT id, description, productType, price, stock FROM products WHERE id = :id AND active = true");
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $request->execute();

        return $request->fetchObject('Product');
    }

    public static function update($product)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("UPDATE products SET description = :description, productType = :productType, price = :price, stock = :stock, modifiedDate = :modifiedDate : WHERE id = :id AND active = true");
        $request->bindValue(':description', $product->description, PDO::PARAM_STR);
        $request->bindValue(':productType', $product->productType, PDO::PARAM_STR);
        $request->bindValue(':price', $product->precio, PDO::PARAM_STR);
        $request->bindValue(':stock', $product->stock, PDO::PARAM_INT);
        $request->bindValue(':id', $product->id, PDO::PARAM_INT);
        $date = new DateTime(date("d-m-Y"));
        $request->bindValue(':modifiedDate', date_format($date, 'Y-m-d H:i:s'));
        $request->execute();

    }

    public static function delete($id)
    {
        $DAO = DataAccessObject::getInstance();
        $request = $DAO->prepareRequest("UPDATE productos SET active = false; modifiedDate = :modifiedDate WHERE id = :id AND active = true");
        $request->bindValue(':id', $id, PDO::PARAM_INT);
        $date = new DateTime(date("d-m-Y"));
        $request->bindValue(':modifiedDate', date_format($date, 'Y-m-d H:i:s'));
        $request->execute();
    }

    public static function DescriptionValidation($description)
    {
        $productList = Product::getAll();
        foreach ($productList as $p) {
            if ($p->description == $description) {
                return $p;
            }
        }
        return null;
    }

    public static function ProductTypeValidation($type)
    {
        if ($type != ProductType::FOOD && $type != ProductType::BEER && $type != ProductType::DRINK && $type != ProductType::DESSERT) {
            return false;
        }
        return true;
    }
}