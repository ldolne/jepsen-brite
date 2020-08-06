<?php

// EVENT CONTROLLERS

namespace controller;

require_once('./autoloader.php');
require_once('./model/EventManager.php');
require_once('./model/CommentManager.php');

class EventController
{
    private $eventManager;
    private $commentManager;

    public function __construct()
    {
        $this->eventManager = new \model\EventManager();
        $this->commentManager = new \model\CommentManager();
    }

    public function getIndexPage(){
        $events = $this->eventManager->getUpcomingEvents(); // call a function of this object

        require('./view/mainPage.php');
    }

    public function listPastEvents()
    {
        $events = $this->eventManager->getPastEvents();

        require('./view/archiveView.php');
    }

    public function showEvent($message = NULL)
    {
        $eventReq = $this->eventManager->getEvent($_GET['id']);
        $participants = $this->eventManager->getParticipantsByEvent($_GET['id']);
        $participantsArr = $participants->fetchAll();
        $comments = $this->commentManager->getComments($_GET['id']);

        if(isset($_SESSION['id']))
        {
            $userAvatarReq = $this->commentManager->getCurrentCommentAuthorAvatar($_SESSION['id']);
            $userAvatar = $userAvatarReq->fetch();
        }
        $event = $eventReq->fetch();

        if (!empty($event))
        {
            require('./view/oneEvent.php');
        }
        else
        {
            throw new Exception('Event ID does not exist.');
        }
    }

    public function handleEvent()
    {
        $eventReq = $this->eventManager->getEvent($_GET['id']);
        $event = $eventReq->fetch();

        if (empty($event))
        {
            throw new Exception('Event ID does not exist.');
        }
        else
        {
            return $event;
        }
    }

    public function showEventCreationPage($message = null)
    {
        require('./view/addEvent.php');
    }

    public function createNewEvent($imageName)
    {
        $affectedLines = $this->eventManager->createEvent(
            $_POST['title'],
            $_SESSION['id'],
            $_POST['event_date'],
            $_POST['event_hour'],
            $imageName,
            $_POST['description'],
            $_POST['category_id']);

        if ($affectedLines === false) {
            throw new Exception('Problem while creating an event. Please try again.');
        }
        else
        {
            header('Location: ./index.php');
        }
    }

    public function showEventModificationPage($event, $message = null)
    {
        require('./view/modifyEvent.php');
    }

    public function updateExistingEvent($imageName)
    {
        $affectedLines = $this->eventManager->updateEvent(
            $_GET['id'],
            $_POST['title'],
            $_SESSION['id'],
            $_POST['event_date'],
            $_POST['event_hour'],
            $imageName,
            $_POST['description'],
            $_POST['category_id']);

        if ($affectedLines === false) {
            throw new Exception('Problem while modifying the event. Please try again.');
        } else {
            header('Location: ./index.php?action=showEvent&id=' . $_GET['id']);
        }
    }

    public function deleteExistingEvent()
    {
        // Deletion of Cloudinary image or video of the deleted event
        $event = $this->handleEvent();
        $defaultImage = "default_znnszq";
        $imageFromDbArr = explode('.', substr((strrchr($event['image'], '/')), 1));
        $publicId = $imageFromDbArr[0];

        if($publicId != $defaultImage)
        {
            $resultDestroy = \Cloudinary\Uploader::destroy('jepsen-brite/events_img/' . $publicId);

            if ($resultDestroy == null) {
                throw new Exception('There has been a problem during the deletion of the uploaded image of this event.');
            }
        }

        $EventsAffectedLines = $this->eventManager->deleteEvent($_GET['id']);
        $CommentsAffectedLines = $this->commentManager->deleteAllComments($_GET['id']);

        if ($EventsAffectedLines === false) {
            throw new Exception('Problem while deleting the event. Please try again.');
        } else if ($CommentsAffectedLines === false)
        {
            throw new Exception('Problem while deleting the comments of the event. Please try again.');
        } else {
            header('Location: ./index.php');
        }
    }

    public function registerToEvent($eventId, $userId)
    {
        // Check if user's already taking part in the event
        $existingParticipantReq = $this->eventManager->getOneParticipantByEvent($eventId, $userId);
        $existingParticipant = $existingParticipantReq->fetch();

        if($existingParticipant != false)
        {
            throw new Exception("You're already participating, so you can't register again.");
        }
        else
        {
            // User's not yet participating
            $affectedLines = $this->eventManager->createParticipantByEvent($eventId, $userId);

            if ($affectedLines === false) {
                throw new Exception('Problem while registering for this event. Please try again.');
            } else {
                header('Location: ./index.php?action=showEvent&id=' . $eventId . '&isParticipating=true');
            }
        }
    }

    public function unregisterFromEvent($eventId, $userId)
    {
        // Check if user's indeed taking part in the event
        $existingParticipantReq = $this->eventManager->getOneParticipantByEvent($eventId, $userId);
        $existingParticipant = $existingParticipantReq->fetch();

        if($existingParticipant === false)
        {
            throw new Exception("You're not participating, so you can't unregister.");
        }
        else
        {
            $affectedLines = $this->eventManager->deleteParticipantByEvent($eventId, $userId);

            if ($affectedLines === false) {
                throw new Exception('Problem while unregistrering from this event. Please try again.');
            } else {
                header('Location: ./index.php?action=showEvent&id=' . $eventId);
            }
        }
    }
}