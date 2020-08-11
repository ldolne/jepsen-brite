<?php

namespace model;

require_once('./vendor/autoload.php');

class Manager
{
    private $dbDsn;
    private $dbUser;
    private $dbPassword;

    private function dbInfo()
    {
        // Disable for Heroku
        $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        //

        $dbUrl = $_ENV['CLEARDB_DATABASE_URL'];
        $dbParsedUrl = parse_url($dbUrl);
        $dbHost = $dbParsedUrl['host'];
        $dbName = substr($dbParsedUrl['path'], 1);

        $this->dbDsn = 'mysql:host=' .  $dbHost . ';dbname=' . $dbName . ';charset=utf8mb4';
        $this->dbUser = $dbParsedUrl['user'];
        $this->dbPassword = $dbParsedUrl['pass'];
    }

    protected function dbConnect()
    {
        if(!isset($this->dbDsn) OR !isset($this->dbUser) OR !isset($this->dbPassword))
        {
            $this->dbInfo();
        }

        $db = new \PDO($this->dbDsn, $this->dbUser, $this->dbPassword, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        return $db;
    }
}