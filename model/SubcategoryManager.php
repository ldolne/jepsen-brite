<?php

namespace model;

require_once('Manager.php');

class SubcategoryManager extends Manager
{
    public function AllSubCategoriesModel()
    {
        $bdd = $this->dbConnect();
        $req = $bdd->query(
            'SELECT e.id, e.title,c.category,s.subcategory ,e.event_date
            AS event_date_formatted,e.event_hour
			AS event_hour_formatted
            FROM events AS e
            INNER JOIN categories AS c
            ON e.category_id = c.id
            INNER JOIN assoc_subcategories_events AS ase
            ON e.id = ase.event_id 
            inner join subcategories as s 
            on s.id = ase.subcategory_id '
        );

        return $req;
    }

    // If there are subcategories
    public function SubCategoryModel($SubCategoryId)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT e.id, e.title,c.category,s.subcategory ,e.event_date
        AS event_date_formatted,e.event_hour
        AS event_hour_formatted
        FROM events AS e
        INNER JOIN categories AS c
        ON e.category_id = c.id
        INNER JOIN assoc_subcategories_events AS ase
        ON e.id = ase.event_id 
        inner join subcategories as s 
        on s.id = ase.subcategory_id
        where s.id = ?  ');
        $req->execute(array($SubCategoryId));

        return $req;
    }

// inner join of category ans subcategory
    public function JoinCategoryAndSubCategoryModel($JoinCategoryAndSubCategory)
    {
        $bdd = $this->dbConnect();
        $req = $bdd->prepare('SELECT c.category, s.subcategory 
        FROM categories as c 
        inner join subcategories as s 
        on c.id = s.category_id');
        $req->execute(array($JoinCategoryAndSubCategory));

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
