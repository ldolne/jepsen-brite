<?php

require_once('Manager.php');

class SubCategoriesManager extends Manager
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
            on s.id = ase.subcategory_id ');

        return $req;
    }

}
