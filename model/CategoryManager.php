<?php

require_once('Manager.php');

class CategoryManager extends Manager
{
    public function AllCategoryModel()
    {
        $bdd = dbConnect();
        $req = $bdd->query("SELECT * FROM `events` 
            INNER JOIN `users` ON events.author_id = users.id 
            INNER JOIN `categories` ON events.category_id = categories.id
            ORDER BY event_date DESC, event_hour DESC");

        return $req;
    }

    public function OneCategoryModel($categoryId)
    {
        $bdd = dbConnect();
        $req = $bdd->prepare("SELECT * FROM `events` 
            INNER JOIN `users` ON events.author_id = users.id 
            INNER JOIN `categories` ON events.category_id = categories.id 
            WHERE events.category_id = ?
            ORDER BY event_date DESC, event_hour DESC");
        $req->execute(array($categoryId));

        return $req;
    }
}
