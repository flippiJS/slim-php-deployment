<?php

namespace Interfaces;

interface IPersistance
{
    public static function create($object);
    public static function getAll();
    public static function getOne($value);
    public static function update($object);
    public static function delete($object);

}