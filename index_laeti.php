<?php
// ROUTER
require('controller/controller_laeti.php');

try // en fonction de l'action qui est donnée, on appelle le bon contrôleur
{
    if (isset($_GET['action'])) // si une action est bien envoyée
    {
        $_GET['action'] = htmlspecialchars($_GET['action']); // On rend inoffensives les balises HTML que le visiteur a pu entrer

        if ($_GET['action'] == 'listUpcomingEvents') {
            listUpcomingEvents();
        } else if ($_GET['action'] == 'listPastEvents') {
            listPastEvents();
        } else if ($_GET['action'] == 'showEvent') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                showEvent();
            } else {
                throw new Exception('No event ID sent.');
            }
        } else if ($_GET['action'] == "showEventCreationPage")
        {
            showEventCreationPage();
        } else if ($_GET['action'] == "createNewEvent") {
            if(isset($_POST['title']) && isset($_POST['author_id'])
                && isset($_POST['description']) && isset($_POST['category_id']))

            /*
             *             if(isset($_POST['title']) && isset($_POST['author_id']) && isset($_POST['event_date'])
                && isset($_POST['image']) && isset($_POST['description']) && isset($_POST['category_id']))
             */
            {
                // tests supplémentaires sur données envoyées

                $_POST['title'] = htmlspecialchars($_POST['title']);
                $_POST['description'] = htmlspecialchars($_POST['description']);
                $_POST['description'] = nl2br($_POST['description']);

                createNewEvent();
            }
        }
        /*else if ($_GET['action'] == 'addComment') // si on implémente commentaires sur les events
        {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                } else {
                    throw new Exception('No author or comment specified. Please fill up all fields.');
                }
            } else {
                throw new Exception('No event ID sent.');
            }
        }*/
    } else // action de base si aucune action spécifiée
    {
        listUpcomingEvents();
    }
}
catch(Exception $e) // Si une erreur est détectée à un endroit du code, remonte jusqu'ici...
{
    echo 'Error: ' . $e->getMessage(); // Récupère message d'erreur de Exception qui a causé erreur et l'affiche.
    //require('errorView.php'); // pour afficher une jolie view des erreurs
}