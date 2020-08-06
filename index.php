<?php
// ROUTER

// requires
require_once('autoloader.php');
require_once ("./controller/UserController.php");
require_once ("./controller/CategoryController.php");
require_once ("./controller/EventController.php");
require_once ("./controller/CommentController.php");

// session start
session_start();
if (isset($_COOKIE['username']) && !empty($_COOKIE['username'])
&& isset($_COOKIE['id']) && !empty($_COOKIE['id'])) {
    cookieVerification();
}

// Controllers declaration
$userController = new \controller\UserController();
$categoryController = new \controller\CategoryController();
$eventController = new \controller\EventController();
$commentController = new \controller\CommentController();

// routing
try {
    if (isset($_GET['action'])) {

        $_GET['action'] = htmlspecialchars($_GET['action']); // Deactivation of HTML tags

        // NO RESTRICTED PAGES
        if ($_GET['action'] == 'inscription') {
            if (
                !empty($_POST['username'])
                && !empty($_POST['password'])
                && !empty($_POST['passwordcheck'])
                && !empty($_POST['email'])) {
                $userController->actualInscription();
            } 
            else {
                $userController->getInscriptionPage();
            }
        } elseif ($_GET['action'] == 'connection') {
            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                $userController->login();
            } 
            else {
                $userController->getConnectionPage();
            }
        } 
        elseif ($_GET['action'] == 'deconnection') {
            $userController->deconnection();
        }

        // CATEGORY ACTIONS
        elseif ($_GET["action"] == "onecategorycontroller") {
            $categoryController->OneCategoryController();
        } elseif ($_GET["action"] == "allcategorycontroller") {
            $categoryController->AllCategoryController();
        }


        // SUBCATEGORY ACTIONS
        elseif ($_GET["action"] == "subcategorycontroller") {
            OneSubCategoryController();
        } elseif ($_GET["action"] == "allsubcategoriesController") {
            AllSubCategoriesController();
        }



        // EVENT AND COMMENT ACTIONS
        else if ($_GET['action'] == 'listPastEvents') {
            $eventController->listPastEvents();
        } else if ($_GET['action'] == 'showEvent') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $eventController->showEvent();
            } else {
                throw new Exception('No event ID sent.');
            }
        }

        // RESTRICTED PAGES
        elseif (
            isset($_SESSION['username']) && !empty($_SESSION['username']) &&
            isset($_SESSION['id']) && !empty($_SESSION['id'])
        ) {

            // USER ACTIONS
            if ($_GET['action'] == 'profile') {
                $userController->getProfilePage();
            } elseif ($_GET['action'] == 'modifyprofile') {
                if (!empty($_POST['username'])
                    || (!empty($_POST['password']) && $_POST['password'] == $_POST['passwordcheck'])) {
                    $userController->profileModification();
                } else {
                    $userController->modifyProfilePage();
                }
            } elseif ($_GET['action'] == 'deleteprofile') {
                $userController->deleteAccount();
            } elseif ($_GET['action'] == 'userdashboard') {
                getUserDashboard();
            } elseif ($_GET['action'] == 'admindashboard') {
                getAdminDashboard();
            } else if ($_GET['action'] == 'makeadmin') {
                makeAdmin();
            } else if ($_GET['action'] == 'undoadmin') {
                undoAdmin();
            } else if ($_GET['action'] == 'admindelete') {
                adminDeleteUser();
            }

            // EVENT AND COMMENT ACTIONS
            else if ($_GET['action'] == "showEventCreationPage") {
                $eventController->showEventCreationPage();
            } else if ($_GET['action'] == "showEventModificationPage") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $event = $eventController->handleEvent();

                    if ($_SESSION['id'] == $event['author_id']) {
                        $eventController->showEventModificationPage($event);
                    } else {
                        throw new Exception("No permission to modify this event. You're not the author of it.");
                    }
                } else {
                    throw new Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == "createNewEvent") {
                if (
                    isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['event_date']) && !empty($_POST['event_date'])
                    && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                    && isset($_FILES['image']) && !empty($_FILES['image']['name'])
                    && isset($_POST['description']) && !empty($_POST['description'])
                    && isset($_POST['category_id']) && !empty($_POST['category_id'])
                    && isset($_POST['subcategory_id']) && !empty($_POST['subcategory_id'])
                ) {

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

                            $resultUpload = \Cloudinary\Uploader::upload($_FILES['image']['tmp_name'],
                                array("public_id" => $imageFileName, "folder" => "jepsen-brite/events_img/", "resource_type" => "auto", "overwrite" => TRUE)); // Upload fichier du dossier où est enregistré au cloud

                            if ($resultUpload != null) {
                                $eventController->createNewEvent($resultUpload["secure_url"]);
                            } else {
                                throw new Exception('There has been a problem during the upload of your image. Please try again.');
                            }
                        } else {
                            $message = 'No valid extension file: your image must be a .jpg, .jpeg, .gif or .png file.';
                            $eventController->showEventModificationPage($event, showInfoMessage($message, false));
                        }
                    } else {
                        $message = 'The image cannot be larger than 2MB.';
                        $eventController->showEventModificationPage($event, showInfoMessage($message, false));
                    }
                } else if (
                    isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['event_date']) && !empty($_POST['event_date'])
                    && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                    && (!isset($_FILES['image']) or empty($_FILES['image']['name']))
                    && isset($_POST['description']) && !empty($_POST['description'])
                    && isset($_POST['category_id']) && !empty($_POST['category_id']))
                {
                    $defaultImage = "https://res.cloudinary.com/dudwqzfzp/image/upload/v1596617340/jepsen-brite/events_img/default_znnszq.gif";
                    $eventController->createNewEvent($defaultImage);
                } else {
                    $message = 'You have to fill up all fields.';
                    $eventController->showEventCreationPage(showInfoMessage($message, false));
                }
            } else if ($_GET['action'] == "updateExistingEvent") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $event = $eventController->handleEvent();

                    if (
                        isset($_POST['title']) && !empty($_POST['title'])
                        && isset($_POST['event_date']) && !empty($_POST['event_date'])
                        && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                        && isset($_FILES['image']) && !empty($_FILES['image']['name'])
                        && isset($_POST['description']) && !empty($_POST['description'])
                        && isset($_POST['category_id']) && !empty($_POST['category_id'])
                        && isset($_POST['subcategory_id']) && !empty($_POST['subcategory_id'])

                    ) {


                        $_POST['title'] = htmlspecialchars($_POST['title']);
                        $_POST['description'] = htmlspecialchars($_POST['description']);

                        $imageMaxSize = 2097152;
                        $validExtensions = array('jpg', 'jpeg', 'gif', 'png');

                        if ($_FILES['image']['size'] <= $imageMaxSize) {
                            $uploadExtension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                            if (in_array($uploadExtension, $validExtensions)) {
                                $defaultImage = "default_znnszq";
                                $imageFromDbArr = explode('.', substr((strrchr($event['image'], '/')), 1));
                                $imageFromDb = $imageFromDbArr[0];

                                if($imageFromDb === $defaultImage)
                                {
                                    $randomNumber = 20;
                                    $randomString = bin2hex(random_bytes($randomNumber));

                                    $imageFileName = $_SESSION['id'] . "_" . $randomString;
                                }
                                else {
                                    $imageFileName = $imageFromDb;
                                }

                                $resultUpload = \Cloudinary\Uploader::upload($_FILES['image']['tmp_name'],
                                    array("public_id" => $imageFileName, "folder" => "jepsen-brite/events_img/", "resource_type" => "auto", "overwrite" => TRUE)); // Upload fichier du dossier où est enregistré au cloud

                                if ($resultUpload != null) {
                                    $eventController->updateExistingEvent($resultUpload["secure_url"]);
                                } else {
                                    throw new Exception('There has been a problem during the upload of your image. Please try again.');
                                }
                            } else {
                                $message = 'No valid extension file: your image must be a .jpg, .jpeg, .gif or .png file.';
                                $eventController->showEventModificationPage($event, showInfoMessage($message, false));
                            }
                        } else {
                            $message = 'The image cannot be larger than 2MB.';
                            $eventController->showEventModificationPage($event, showInfoMessage($message, false));
                        }
                    } else if (isset($_POST['title']) && !empty($_POST['title'])
                            && isset($_POST['event_date']) && !empty($_POST['event_date'])
                            && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                            && (!isset($_FILES['image']) or empty($_FILES['image']['name']))
                            && isset($_POST['description']) && !empty($_POST['description'])
                            && isset($_POST['category_id']) && !empty($_POST['category_id']))
                    {
                        $eventController->updateExistingEvent($event['image']);
                    } else {
                        $message = 'You have to fill up all fields.';
                        $eventController->showEventModificationPage($event, showInfoMessage($message, false));
                    }
                } else {
                    throw new Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == 'deleteExistingEvent') {
                $event = $eventController->handleEvent();
                if (isset($_SESSION['id']) && $_SESSION['id'] == $event['author_id']) {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $eventController->deleteExistingEvent();
                    } else {
                        throw new Exception('No event ID sent.');
                    }
                } else {
                    throw new Exception("No permission to delete this event. You're not the author of it.");
                }
            } else if ($_GET['action'] == 'addComment') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (!empty($_POST['comment'])) {
                        $commentController->addComment($_GET['id'], $_SESSION['id'], $_POST['comment']);
                    } else {
                        $message = 'No comment specified. Please fill up all fields.';
                        $eventController->showEvent(showInfoMessage($message, false));
                    }
                } else {
                    throw new Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == 'deleteExistingComment') {
                $comment = $commentController->handleComment();
                if (isset($_SESSION['id']) && $_SESSION['id'] == $comment['author_id']) {
                    if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                        $commentController->deleteExistingComment();
                    } else {
                        throw new Exception('No comment ID sent.');
                    }
                } else {
                    throw new Exception("No permission to delete this comment. You're not the author of it.");
                }
            }
            else if($_GET['action'] == 'registerToEvent')
            {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $eventController->registerToEvent($_GET['id'], $_SESSION['id']);
                } else {
                    throw new Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == 'unregisterFromEvent') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $eventController->unregisterFromEvent($_GET['id'], $_SESSION['id']);
                } else {
                    throw new Exception('No event ID sent.');
                }
            }
        } else {
            throw new Exception('The URL given is wrong or you have to sign in to access this functionality.');
        }
    } else {
        $eventController->getIndexPage();
    }
} catch (Exception $e) // If an error is detected anywhere in the code, it come back up here. 
{
    $errorMsg = "Error(s): ";
    $errorMsg .= '<p>' . $e->getMessage() . '</p>'; // Get the right thrown exception error message and display it.
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousURL = $_SERVER['HTTP_REFERER'];
    }

    require('view/errorView.php');
}
