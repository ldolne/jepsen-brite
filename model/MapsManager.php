<?php

namespace model;

require_once('Manager.php');

class MapsManager extends Manager
{
    public function FoundMapsModel()
    {
        $bdd = $this->dbConnect();
        $req = $bdd->query(
            'SELECT id, adress a, town t, cp from events e where id=?');
        return $req;
    }


}
