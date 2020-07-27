<?php
function dbConnect()
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '');
        return $bdd;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
function AllCategoryModel()
{
    $bdd = dbConnect();
    $req = $bdd->query("SELECT * FROM `events` 
    INNER JOIN `users` ON events.author_id = users.id 
    INNER JOIN `categories` ON events.category_id = categories.id ");

    return $req;
}

function OneCategoryModel($categoryId)
{
    $bdd = dbConnect();
    $req = $bdd->prepare("SELECT * FROM `events` 
    INNER JOIN `users` ON events.author_id = users.id 
    INNER JOIN `categories` ON events.category_id = categories.id 
    WHERE events.category_id = ? ");
    $req->execute(array($categoryId));


    return $req;
}
