<?php

namespace model;

require_once('Manager.php');

class CategoryManager extends Manager
{
    public function getAllCategories()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT e.id, e.title, DATE_FORMAT(e.event_date, \'%d/%m/%Y\') AS event_date_formatted, DATE_FORMAT(e.event_hour, \'%H:%i\') AS event_hour_formatted, c.category, s.subcategory
            FROM events AS e
            INNER JOIN users AS u
            ON e.author_id = u.id 
            INNER JOIN categories AS c
            ON e.category_id = c.id
            LEFT JOIN assoc_subcategories_events AS ase
            ON e.id = ase.event_id 
            LEFT JOIN subcategories as s 
            on s.id = ase.subcategory_id
            GROUP BY e.title
            ORDER BY event_date DESC, event_hour DESC');

        return $req;
    }

    public function getOneCategory($categoryId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT e.id, e.title, DATE_FORMAT(e.event_date, \'%d/%m/%Y\') AS event_date_formatted, DATE_FORMAT(e.event_hour, \'%H:%i\') AS event_hour_formatted, c.category
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
