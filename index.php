<?php
// ROUTER

// requires
require_once('autoloader.php');
require_once("./controller/UserController.php");
require_once("./controller/CategoryController.php");
require_once("./controller/EventController.php");
require_once("./controller/CommentController.php");
require_once("./controller/SubcategoryController.php");

// session start
session_start();
if (
    isset($_COOKIE['username']) && !empty($_COOKIE['username'])
    && isset($_COOKIE['id']) && !empty($_COOKIE['id'])
) {
    cookieVerification();
}

// Controllers declaration
$userController = new \controller\UserController();
$categoryController = new \controller\CategoryController();
$eventController = new \controller\EventController();
$commentController = new \controller\CommentController();
$subcategoryController = new \controller\SubcategoryController();

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
                && !empty($_POST['email'])
            ) {
                $userController->actualInscription();
            } else {
                $userController->getInscriptionPage();
            }
        } elseif ($_GET['action'] == 'connection') {
            if (!empty($_POST['username']) && !empty($_POST['password'])) {
                $userController->login();
            } else {
                $userController->getConnectionPage();
            }
        } elseif ($_GET['action'] == 'deconnection') {
            $userController->deconnection();
        }

        // CATEGORY ACTIONS
        elseif ($_GET["action"] == "showAllCategories") {
            $categoryController->showAllCategories();
        } elseif ($_GET["action"] == "showOneCategory") {
            $categoryController->showOneCategory();
        }

        // SUBCATEGORY ACTIONS
        elseif ($_GET["action"] == "showOneSubcategory") {
            $subcategoryController->showOneSubcategory();
        }

        // EVENT AND COMMENT ACTIONS
        else if ($_GET['action'] == 'listPastEvents') {
            $eventController->listPastEvents();
        } else if ($_GET['action'] == 'showEvent') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $eventController->showEvent();
            } else {
                throw new \Exception('No event ID sent.');
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
                if (
                    !empty($_POST['username'])
                    || (!empty($_POST['password']) && $_POST['password'] == $_POST['passwordcheck'])
                ) {
                    $userController->profileModification();
                } else {
                    $userController->modifyProfilePage();
                }
            } elseif ($_GET['action'] == 'deleteprofile') {
                $userController->deleteAccount();
            } elseif ($_GET['action'] == 'userdashboard') {
                $userController->getUserDashboard();
            } elseif ($_GET['action'] == 'admindashboard') {
                $userController->getAdminDashboard();
            } else if ($_GET['action'] == 'makeadmin') {
                $userController->makeAdmin();
            } else if ($_GET['action'] == 'undoadmin') {
                $userController->undoAdmin();
            } else if ($_GET['action'] == 'admindelete') {
                $userController->adminDeleteUser();
            }

            // EVENT AND COMMENT ACTIONS
            else if ($_GET['action'] == "showEventCreationPage") {
                $eventController->showEventCreationPage();
            } else if ($_GET['action'] == "showEventModificationPage") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $handleEventReturnArr = $eventController->handleEvent();
                    $event = $handleEventReturnArr[0];
                    $subcategories = $handleEventReturnArr[1];

                    if ($_SESSION['id'] == $event['author_id']) {
                        $eventController->showEventModificationPage($event, $subcategories);
                    } else {
                        throw new \Exception("No permission to modify this event. You're not the author of it.");
                    }
                } else {
                    throw new \Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == "createNewEvent") {
                if (
                    isset($_POST['title']) && !empty($_POST['title'])
                    && isset($_POST['event_date']) && !empty($_POST['event_date'])
                    && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                    && isset($_POST['description']) && !empty($_POST['description'])
                    && isset($_POST['category_id']) && !empty($_POST['category_id'])
                    && isset($_POST['address']) && !empty($_POST['address'])
                    && isset($_POST['cp']) && !empty($_POST['cp'])
                    && isset($_POST['town']) && !empty($_POST['town'])
                ) {
                    $eventController->createNewEvent();
                } else {
                    $message = 'You have to fill up all fields.';
                    $eventController->showEventCreationPage(showInfoMessage($message, false));
                }
            } else if ($_GET['action'] == "updateExistingEvent") {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $handleEventReturnArr = $eventController->handleEvent();
                    $event = $handleEventReturnArr[0];
                    $subcategories = $handleEventReturnArr[1];

                    if (
                        isset($_POST['title']) && !empty($_POST['title'])
                        && isset($_POST['event_date']) && !empty($_POST['event_date'])
                        && isset($_POST['event_hour']) && !empty($_POST['event_hour'])
                        && isset($_POST['description']) && !empty($_POST['description'])
                        && isset($_POST['category_id']) && !empty($_POST['category_id'])
                        && isset($_POST['address']) && !empty($_POST['address'])
                        && isset($_POST['cp']) && !empty($_POST['cp'])
                        && isset($_POST['town']) && !empty($_POST['town'])
                    ) {
                        $eventController->updateExistingEvent($event, $subcategories);
                    } else {
                        $message = 'You have to fill up all fields.';
                        $eventController->showEventModificationPage($event, $subcategories, showInfoMessage($message, false));
                    }
                } else {
                    throw new \Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == 'deleteExistingEvent') {
                $handleEventReturnArr = $eventController->handleEvent();
                $event = $handleEventReturnArr[0];

                if (isset($_SESSION['id']) && $_SESSION['id'] == $event['author_id'] || $_SESSION['isadmin'] != "0") {
                    if (isset($_GET['id']) && $_GET['id'] > 0) {
                        $eventController->deleteExistingEvent();
                    } else {
                        throw new \Exception('No event ID sent.');
                    }
                } else {
                    throw new \Exception("No permission to delete this event. You're not the author of it.");
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
                    throw new \Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == 'deleteExistingComment') {
                $comment = $commentController->handleComment();
                if (isset($_SESSION['id']) && $_SESSION['id'] == $comment['author_id']) {
                    if (isset($_GET['comment_id']) && $_GET['comment_id'] > 0) {
                        $commentController->deleteExistingComment();
                    } else {
                        throw new \Exception('No comment ID sent.');
                    }
                } else {
                    throw new \Exception("No permission to delete this comment. You're not the author of it.");
                }
            } else if ($_GET['action'] == 'registerToEvent') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $eventController->registerToEvent($_GET['id'], $_SESSION['id']);
                } else {
                    throw new \Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == 'unregisterFromEvent') {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $eventController->unregisterFromEvent($_GET['id'], $_SESSION['id']);
                } else {
                    throw new \Exception('No event ID sent.');
                }
            } else if ($_GET['action'] == 'testSubcat') {
                require('view/testSubcat.html');
            }
        } else {
            throw new \Exception('The URL given is wrong or you have to sign in to access this functionality.');
        }
    } else {
        $eventController->getIndexPage();
    }
} catch (\Exception $e) // If an error is detected anywhere in the code, it come back up here.
{
    $errorMsg = "Error(s): ";
    $errorMsg .= '<p>' . $e->getMessage() . '</p>'; // Get the right thrown Exception error message and display it.
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previousURL = $_SERVER['HTTP_REFERER'];
    }

    require('view/errorView.php');
}
