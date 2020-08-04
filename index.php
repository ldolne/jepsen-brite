<?php

// requires
require_once('controller/controller.php');
require_once('require/configs.php');

// Session Start
session_start();
if (isset($_COOKIE['username']) && !empty($_COOKIE['username'])
&& isset($_COOKIE['id']) && !empty($_COOKIE['id'])){
    cookieVerification();
}

// ROUTER

try {
    if (isset($_GET['action'])) {

        $_GET['action'] = htmlspecialchars($_GET['action']); // Deactivation of HTML tags

        // NO RESTRICTED PAGES
        if ($_GET['action'] == 'inscription') {
            if (!empty($_POST['username'])
                && !empty($_POST['password'])
                && !empty($_POST['passwordcheck'])
                && !empty($_POST['email'])) {
                actualInscription();
            } 
            else {
                getInscriptionPage();
            }
        } 
        
        elseif ($_GET['action'] == 'connection') {
            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                login();
            } 
            else {
                getConnectionPage();
            }
        } 
        elseif ($_GET['action'] == 'deconnection') {
            deconnection();
        }

        // CATEGORY ACTIONS
        elseif ($_GET["action"] == "onecategorycontroller") {
            OneCategoryController();
        } elseif ($_GET["action"] == "allcategorycontroller") {
            AllCategoryController();
        }

        // EVENT AND COMMENT ACTIONS
        else if ($_GET['action'] == 'listPastEvents') {
            listPastEvents();
        } else if ($_GET['action'] == 'showEvent') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                showEvent();
            } else {
                throw new Exception('No event ID sent.');
            }
        }

        // RESTRICTED PAGES
        elseif (isset($_SESSION['username']) && !empty($_SESSION['username']) &&
            isset($_SESSION['id']) && !empty($_SESSION['id'])) {

            // USER ACTIONS
            if ($_GET['action'] == 'profile') {
                getProfilePage();
            } elseif ($_GET['action'] == 'modifyprofile') {
                if (!empty($_POST['username'])
                    || (!empty($_POST['password']) && $_POST['password'] == $_POST['passwordcheck'])) {
                    profileModification();
                } else {
                    modifyProfilePage();
                }
            } elseif ($_GET['action'] == 'deleteprofile') {
                deleteAccount();
            } elseif ($_GET['action'] == 'userdashboard') {
                getUserDashboard();
            }

            // EVENT AND COMMENT ACTIONS
            else if ($_GET['action'] == "showEventCreationPage") {
                showEventCreationPage();
            } else if ($_GET['action'] == "showEventModificationPage") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $event = handleEvent();

                    if ($_SESSION['id'] == $event['author_id']) {
                        showEventModificationPage($event);
                    } else {
                        throw new Exception("No permission to modify this event. You're not the author of it.");
                    }
                } else {
                    throw new Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == "createNewEvent") {
                if (isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['event_date']) && !empty($_POST['event_date'])
                    && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                    && isset($_FILES['image']) && !empty($_FILES['image']['name'])
                    && isset($_POST['description']) && !empty($_POST['description'])
                    && isset($_POST['category_id']) && !empty($_POST['category_id'])) {

                    $_POST['title'] = htmlspecialchars($_POST['title']);
                    $_POST['description'] = htmlspecialchars($_POST['description']);

                    $imageMaxSize = 2097152;
                    $validExtensions = array('jpg', 'jpeg', 'gif', 'png');

                    if ($_FILES['image']['size'] <= $imageMaxSize) {
                        $uploadExtension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                        if (in_array($uploadExtension, $validExtensions)) {
                            $randomNumber = 20;
                            $randomString = bin2hex(random_bytes($randomNumber));

                            $imageFileName = $_SESSION['id'] . "_" . $randomString;

                            //$path = "public/img/events_img/" . $imageFileName; // needs to generate randow image name for the event
                            //$resultMove = move_uploaded_file($_FILES['image']['tmp_name'], $path); // Déplace image du dossier temporaire où serveur l'a loadé jusque dans dossier désiré

                            $resultUpload = \Cloudinary\Uploader::upload($_FILES['image']['tmp_name'],
                                array("public_id" => $imageFileName, "folder" => "jepsen-brite/events_img/", "resource_type" => "auto", "overwrite" => TRUE)); // Upload fichier du dossier où est enregistré au cloud

                            if ($resultUpload != null) {
                                createNewEvent($resultUpload["secure_url"]);
                            } else {
                                throw new Exception('There has been a problem during the upload of your image. Please try again.');
                            }
                        } else {
                            $message = 'No valid extension file: your image must be a .jpg, .jpeg, .gif or .png file.';
                            showEventModificationPage($event, showInfoMessage($message, false));
                        }
                    } else {
                        $message = 'The image cannot be larger than 2MB.';
                        showEventModificationPage($event, showInfoMessage($message, false));
                    }
                } else if (isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['event_date']) && !empty($_POST['event_date'])
                    && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                    && (!isset($_FILES['image']) or empty($_FILES['image']['name']))
                    && isset($_POST['description']) && !empty($_POST['description'])
                    && isset($_POST['category_id']) && !empty($_POST['category_id']))
                {
                    // TODO CLOUDINARY
                    $defaultImage = "default.gif";
                    createNewEvent($defaultImage);
                } else {
                    $message = 'You have to fill up all fields.';
                    showEventCreationPage(showInfoMessage($message, false));
                }
            }
            else if ($_GET['action'] == "updateExistingEvent") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $event = handleEvent();

                    if (isset($_POST['title']) && !empty($_POST['title'])
                        && isset($_POST['event_date']) && !empty($_POST['event_date'])
                        && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                        && isset($_FILES['image']) && !empty($_FILES['image']['name'])
                        && isset($_POST['description']) && !empty($_POST['description'])
                        && isset($_POST['category_id']) && !empty($_POST['category_id'])) {
                        

                        $_POST['title'] = htmlspecialchars($_POST['title']);
                        $_POST['description'] = htmlspecialchars($_POST['description']);

                        $imageMaxSize = 2097152;
                        $validExtensions = array('jpg', 'jpeg', 'gif', 'png');

                        if ($_FILES['image']['size'] <= $imageMaxSize) {
                            $uploadExtension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                            // TODO MAJ AVEC CLOUDINARY

                            if (in_array($uploadExtension, $validExtensions)) {
                                if($event['image'] === "default")
                                {
                                    $randomNumber = 20;
                                    $randomString = bin2hex(random_bytes($randomNumber));

                                    $imageFileName = $_SESSION['id'] . "_" . $randomString;
                                }
                                else {
                                    $imageFromDb = explode('.', $event['image']);
                                    $imageFileName = $imageFromDb[0] . "." . $uploadExtension;
                                }

                                //$path = "public/img/events_img/" . $imageFileName; // needs to generate randow image name for the event
                                //$result = move_uploaded_file($_FILES['image']['tmp_name'], $path);

                                $resultUpload = \Cloudinary\Uploader::upload($_FILES['image']['tmp_name'],
                                    array("public_id" => $imageFileName, "folder" => "jepsen-brite/events_img/", "resource_type" => "auto", "overwrite" => TRUE)); // Upload fichier du dossier où est enregistré au cloud

                                if ($resultUpload != null) {
                                    updateExistingEvent($resultUpload["secure_url"]);
                                    // TODO MAJ AVEC CLOUDINARY
                                } else {
                                    throw new Exception('There has been a problem during the upload of your image. Please try again.');
                                }
                            } else {
                                $message = 'No valid extension file: your image must be a .jpg, .jpeg, .gif or .png file.';
                                showEventModificationPage($event, showInfoMessage($message, false));
                            }
                        } else {
                            $message = 'The image cannot be larger than 2MB.';
                            showEventModificationPage($event, showInfoMessage($message, false));
                        }
                    } else if (isset($_POST['title']) && !empty($_POST['title'])
                            && isset($_POST['event_date']) && !empty($_POST['event_date'])
                            && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                            && (!isset($_FILES['image']) or empty($_FILES['image']['name']))
                            && isset($_POST['description']) && !empty($_POST['description'])
                            && isset($_POST['category_id']) && !empty($_POST['category_id']))
                    {
                            updateExistingEvent($event['image']);
                    } else {
                        $message = 'You have to fill up all fields.';
                        showEventModificationPage($event, showInfoMessage($message, false));
                    }
                }
                else
                {
                    throw new Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == 'deleteExistingEvent') {
                $event = handleEvent();
                if (isset($_SESSION['id']) && $_SESSION['id'] == $event['author_id']) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        deleteExistingEvent();
                    } else {
                        throw new Exception('No event ID sent.');
                    }
                } else {
                    throw new Exception("No permission to delete this event. You're not the author of it.");
                }
            } else if ($_GET['action'] == 'addComment') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (!empty($_POST['comment'])) {
                        addComment($_GET['id'], $_SESSION['id'], $_POST['comment']);
                    } else {
                        $message = 'No comment specified. Please fill up all fields.';
                        showEvent(showInfoMessage($message, false));
                    }
                } else {
                    throw new Exception('No event ID sent.');
                }
            } /*else if ($_GET['action'] == 'deleteComment') {
                $comment = handleEvent();
                if (isset($_SESSION['id']) && $_SESSION['id'] == $event['author_id']) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        deleteExistingEvent();
                    } else {
                        throw new Exception('No event ID sent.');
                    }
                } else {
                    throw new Exception("No permission to delete this event. You're not the author of it.");
                }
            }*/
            else if($_GET['action'] == 'registerToEvent')
            {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    registerToEvent($_GET['id'], $_SESSION['id']);
                } else {
                    throw new Exception('No event ID sent.');
                }
            }
            else if($_GET['action'] == 'unregisterFromEvent')
            {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    unregisterFromEvent($_GET['id'], $_SESSION['id']);
                } else {
                    throw new Exception('No event ID sent.');
                }
            }
        }
        else
        {
            throw new Exception('The URL given is wrong or you have to sign in to access this functionality.');
        }
    } else {
        getIndexPage();
    }
}

catch(Exception $e) // If an error is detected anywhere in the code, it come back up here. 
{   $errorMsg = "Error(s): ";
    $errorMsg .= '<p>' . $e->getMessage() . '</p>'; // Get the right thrown exception error message and display it.
    if(isset($_SERVER['HTTP_REFERER']))
    {
        $previousURL = $_SERVER['HTTP_REFERER'];
    }

    require('view/errorView.php');
}