<?php

namespace model;

require_once('Manager.php');

class SubcategoryManager extends Manager
{
    // TODO REPRENDRE ICI
    public function getOneSubcategory($subcategoryId)
    {
        $db= $this->dbConnect();
        $req = $db->prepare('SELECT e.id, e.title, DATE_FORMAT(e.event_date, \'%d/%m/%Y\') AS event_date_formatted, DATE_FORMAT(e.event_hour, \'%H:%i\') AS event_hour_formatted, c.category
        FROM events AS e
        INNER JOIN categories AS c
        ON e.category_id = c.id
        INNER JOIN assoc_subcategories_events AS ase
        ON e.id = ase.event_id 
        INNER JOIN subcategories AS s 
        ON s.id = ase.subcategory_id
        WHERE s.id = ?  
        ORDER BY event_date DESC, event_hour DESC');
        $req->execute(array($subcategoryId));

        return $req;
    }

    public function getSubcategoriesByEvent($eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT s.id, s.subcategory
        FROM subcategories as s 
        INNER JOIN assoc_subcategories_events as ase 
        ON s.id = ase.subcategory_id
        WHERE ase.event_id = ?');
        $req->execute(array($eventId));

        return $req;
    }

    public function createSubcategoryForEvent($subcategoryId, $eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO assoc_subcategories_events(subcategory_id, event_id) 
            VALUES (:subcategory_id, :event_id)');
        $affectedLines = $req->execute(array(
            'subcategory_id' => $subcategoryId,
            'event_id' => $eventId
        ));

        return $affectedLines;
    }

    public function deleteSubcategoryForEvent($subcategoryId, $eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM assoc_subcategories_events WHERE subcategory_id = :subcategory_id AND event_id = :event_id');
        $affectedLines = $req->execute(array(
            'subcategory_id' => $subcategoryId,
            'event_id' => $eventId
        ));

        return $affectedLines;
    }

    public function deleteAllSubcategoriesForEvent($eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM assoc_subcategories_events WHERE event_id = ? ');
        $affectedLines = $req->execute(array($eventId));

        return $affectedLines;
    }
}
