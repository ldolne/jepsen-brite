<?php

namespace model;

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=eu-cdbr-west-03.cleardb.net;dbname=heroku_e2d2d52caa0a60e;charset=utf8mb4', 'b0064daaa84290', 'fffd63cb', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        return $db;
    }
}