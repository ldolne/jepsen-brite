<?php

require_once('Manager.php');

class UserManager extends Manager
{
    public function DoesCookieUserExist() {
        $bdd = $this-> dbConnect();
        $request = $bdd-> prepare("SELECT * FROM `users` WHERE `id`= ? && `username` = ?");
        return $request;
    }

    public function dbUserVerif() {
        $bdd = $this->dbConnect();
        $request = $bdd-> prepare("SELECT * FROM `users` WHERE `username` = ?");
        return $request;
    }

    public function inscriptionPreparation(){
        $bdd = $this->dbConnect();
        $request = $bdd-> prepare("INSERT INTO `users`(`email`, `username`, `password`, `avatar`) 
    VALUES(?, ?, ?, ?)");
        return $request;
    }

    public function isNameTaken() {
        $bdd = $this->dbConnect();
        $request = $bdd-> prepare("SELECT `username` FROM `users` WHERE `username` = ?");
        return $request;
    }

    public function isEmailTaken() {
        $bdd = $this->dbConnect();
        $request = $bdd-> prepare("SELECT `email` FROM `users` WHERE `email` = ?");
        return $request;
    }

    public function updatePreparation() {
        $bdd = $this->dbConnect();
        $request = $bdd -> prepare("UPDATE users SET `username` = ?, `password`=? WHERE `id` = ?");
        return $request;
    }

    public function deletePreparation(){
        $bdd = $this->dbConnect();
        $request = $bdd -> prepare("DELETE FROM users WHERE `id` = ?");
        return $request;
    }

    public function getUser() {
        $bdd = $this-> dbConnect();
        $request = $bdd-> prepare("SELECT * FROM `users` WHERE `id`= ?");
        return $request;
    }
}
