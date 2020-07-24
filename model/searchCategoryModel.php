<?php
function searchAllCategory()
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=jepsen-brite;charset=utf8mb4', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    $requestSearchAll = $bdd->prepare("SELECT * FROM `events` 
    INNER JOIN `users` ON events.author_id = users.id 
    INNER JOIN `categories` ON events.category_id = categories.id ");



    return $requestSearchAll;
}
