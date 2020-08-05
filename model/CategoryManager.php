<?php

namespace model;

require_once('Manager.php');

class CategoryManager extends Manager
{
    public function AllCategoryModel()
    {
        $bdd = $this->dbConnect();
        $req = $bdd->query('SELECT e.id, e.title, DATE_FORMAT(e.event_date, \'%d/%m/%Y\') AS event_date_formatted, DATE_FORMAT(e.event_hour, \'%H:%i\') AS event_hour_formatted, c.category
            FROM events AS e
            INNER JOIN users AS u
            ON e.author_id = u.id 
            INNER JOIN categories AS c
            ON e.category_id = c.id
            ORDER BY event_date DESC, event_hour DESC');

        return $req;
    }

    public function OneCategoryModel($categoryId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT e.id, e.title, DATE_FORMAT(e.event_date, \'%d/%m/%Y\') AS event_date_formatted, DATE_FORMAT(e.event_hour, \'%H:%i\') AS event_hour_formatted, c.category
            FROM events AS e
            INNER JOIN users AS u 
            ON e.author_id = u.id 
            INNER JOIN categories AS c 
            ON e.category_id = c.id 
            WHERE e.category_id = ?
            ORDER BY event_date DESC, event_hour DESC');
        $req->execute(array($categoryId));

        return $req;
    }
}
