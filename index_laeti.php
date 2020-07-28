<?php
// ROUTER
//session_start();

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
                throw new Exception('No event ID sent.', 1);
            }
        } else if ($_GET['action'] == "showEventCreationPage") {
            //if(isset($_SESSION['id']))
            //{
            showEventCreationPage();
            //}
        } else if ($_GET['action'] == "showEventModificationPage") {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $event = handleEvent();

                if (isset($_SESSION['id']) && $_SESSION['id'] == $event['author_id']) {
                    showEventModificationPage();
                } else {
                    throw new Exception("No permission to modify this event. You're not the author of it.", 0);
                }
            }
            else {
                throw new Exception('No event ID sent.', 1);
            }
        }else if ($_GET['action'] == "createNewEvent") {
                if (isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['author_id']) && !empty($_POST['author_id'])
                    && isset($_POST['event_date']) && !empty($_POST['event_date'])
                    && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                    && isset($_FILES['image']) && !empty($_FILES['image']['name'])
                    && isset($_POST['description']) && !empty($_POST['description'])
                    && isset($_POST['category_id']) && !empty($_POST['category_id'])) {
                    $_POST['title'] = htmlspecialchars($_POST['title']);
                    $_POST['description'] = htmlspecialchars($_POST['description']);
                    $_POST['description'] = nl2br($_POST['description']);

                    $imageMaxSize = 2097152;
                    $validExtensions = array('jpg', 'jpeg', 'gif', 'png');

                    if ($_FILES['image']['size'] <= $imageMaxSize) {
                        $uploadExtension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                        if (in_array($uploadExtension, $validExtensions)) {
                            $randomNumber = 20;
                            $randomString = bin2hex(random_bytes($randomNumber));

                            $imageFileName = $randomString . "." . $uploadExtension;

                            $path = "public/img/events_img/" . $imageFileName; // needs to generate randow image name for the event
                            //$path = "public/img/events_img/" . $_SESSION['id'] . "_" . $randomString . "." . $uploadExtension; // needs to generate randow image name for the event
                            $result = move_uploaded_file($_FILES['image']['tmp_name'], $path);

                            if ($result) {
                                createNewEvent($imageFileName);
                            } else {
                                throw new Exception('There has been a problem during the upload of your image. Please try again.', 3);
                            }
                        } else {
                            throw new Exception('No valid extension file: your image must be a .jpg, .jpeg, .gif or .png file.', 3);
                        }
                    } else {
                        throw new Exception('The image cannot be larger than 2MB.', 3);
                    }
                } else {
                    throw new Exception("You have to fill up all fields.", 3);
                }
            } // TODO REPRENDRE UPDATE
            else if ($_GET['action'] == "updateExistingEvent") {
                if (isset($_POST['title'])
                    && isset($_POST['author_id'])
                    && isset($_FILES['image']) && !empty($_FILES['image']['name'])
                    && isset($_POST['description']) && isset($_POST['category_id'])) /*
             * if(isset($_POST['title']) && isset($_POST['author_id']) && isset($_POST['event_date'])
                && isset($_POST['image']) && isset($_POST['description']) && isset($_POST['category_id']))
             */ {
                    // tests supplémentaires sur données envoyées

                    $_POST['title'] = htmlspecialchars($_POST['title']);
                    $_POST['description'] = htmlspecialchars($_POST['description']);
                    $_POST['description'] = nl2br($_POST['description']);

                    $imageMaxSize = 2097152;
                    $validExtensions = array('jpg', 'jpeg', 'gif', 'png');

                    if ($_FILES['image']['size'] <= $imageMaxSize) {
                        $uploadExtension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                        if (in_array($uploadExtension, $validExtensions)) {
                            $randomNumber = 20;
                            $randomString = bin2hex(random_bytes($randomNumber));

                            $imageFileName = $randomString . "." . $uploadExtension;

                            $path = "public/img/events_img/" . $imageFileName; // needs to generate randow image name for the event
                            //$path = "public/img/events_img/" . $_SESSION['id'] . "_" . $randomString . "." . $uploadExtension; // needs to generate randow image name for the event
                            $result = move_uploaded_file($_FILES['image']['tmp_name'], $path);
                            // ATTENTION : move_uploaded_file pas autorisé avec lampp/temp

                            if ($result) {
                                updateExistingEvent($imageFileName);
                            } else {
                                throw new Exception('There has been a problem during the upload of your image. Please try again.', 3);
                            }
                        } else {
                            throw new Exception('No valid extension file: your image must be a .jpg, .jpeg, .gif or .png file.', 3);
                        }
                    } else {
                        throw new Exception('The image cannot be larger than 2MB.', 3);
                    }
                } else {
                    throw new Exception("You have to fill up all fields.", 3);
                }
                /*else
                {
                    throw new Exception("Sign in or up to be able to access this functionality.");
                }*/
            } else if ($_GET['action'] == 'deleteExistingEvent') {
                $event = handleEvent();
                //if(isset($_SESSION['id']) && $_SESSION['id'] == $event['author_id'])
                //{
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    deleteExistingEvent($_GET['id']);
                } else {
                    throw new Exception('No event ID sent.', 1);
                }
                //}
            } else if ($_GET['action'] == 'addComment') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                        addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                    } else {
                        throw new Exception('No author or comment specified. Please fill up all fields.', 2);
                    }
                } else {
                    throw new Exception('No event ID sent.', 1);
                }
            }
        } else // action de base si aucune action spécifiée
        {
            listUpcomingEvents();
        }
    }
catch(Exception $e) // Si une erreur est détectée à un endroit du code, remonte jusqu'ici...
{
    $errorMsg = '<p>' . $e->getMessage() . '</p>'; // Récupère message d'erreur de Exception qui a causé erreur et l'affiche.
    $errorCode = $e->getCode();

    switch($errorCode)
    {
        case 0:
            require('view/errorView.php');
            break;
        case 1:
            require('view/homepageView.php');
            break;
        case 2:
            require('view/eventView.php');
            break;
        case 3:
            require('view/eventCreationView.php');
            break;
        case 4:
            require('view/archiveView.php');
            break;
    }
}