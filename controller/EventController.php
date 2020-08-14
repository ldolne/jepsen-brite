<?php

// EVENT CONTROLLERS

namespace controller;

use SendGrid\Content;
use SendGrid\Email;
use SendGrid\Mail;

require_once('./vendor/autoload.php');
require_once('./autoloader.php');
require_once('./model/UserManager.php');
require_once('./model/EventManager.php');
require_once('./model/CommentManager.php');
require_once('./model/SubcategoryManager.php');

class EventController
{
    private $userManager;
    private $eventManager;
    private $commentManager;
    private $subcategoryManager;

    public function __construct()
    {
        $this->userManager = new \model\UserManager();
        $this->eventManager = new \model\EventManager();
        $this->commentManager = new \model\CommentManager();
        $this->subcategoryManager = new \model\SubcategoryManager();
    }

    public function getIndexPage()
    {
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
        $subcategories = $this->subcategoryManager->getSubcategoriesByEvent($_GET['id']);
        $subcategoriesArr = $subcategories->fetchAll();
        $comments = $this->commentManager->getComments($_GET['id']);

        if (isset($_SESSION['id'])) {
            $userAvatarReq = $this->commentManager->getCurrentCommentAuthorAvatar($_SESSION['id']);
            $userAvatar = $userAvatarReq->fetch();

            // Get if the user of the session in an admin
            $userReq = $this->userManager->getUser();
            $userReq->execute(array($_SESSION['id']));
            $getAdmin = $userReq->fetch();
            $isAdmin = $getAdmin['isadmin'];
        }

        $event = $eventReq->fetch();

        // Get if the author of the event is an admin
        /* $authorManager = new UserManager();
         $authorReq = $authorManager->getUser();
         $authorReq->execute(array($event['author_id']));
         $getAuthor = $authorReq->fetch();
         $authorAdmin = $getAuthor['isadmin'];*/

        //Get if the participant is an admin
        /*foreach($participantsArr as $parti)
        {
            $particManager = new UserManager();
            $particReq = $particManager->getUser();
            $particReq->execute(array($parti['user_id']));
            $getParticipant = $particReq->fetch();
            $particAdmin = $getParticipant['isadmin'];

        }*/

        if (!empty($event)) {
            require('./view/oneEvent.php');
        } else {
            throw new \Exception('Event ID does not exist.');
        }
    }

    public function handleEvent()
    {
        $eventReq = $this->eventManager->getEvent($_GET['id']);
        $subcategoriesReq = $this->subcategoryManager->getSubcategoriesByEvent($_GET['id']);
        $event = $eventReq->fetch();
        $subcategories = $subcategoriesReq->fetchAll();

        if (empty($event)) {
            throw new \Exception('Event ID does not exist.');
        } else {
            return array($event, $subcategories);
        }
    }

    public function showEventCreationPage($message = null)
    {
        require('./view/addEvent.php');
    }

    public function createNewEvent()
    {
        $_POST['title'] = htmlspecialchars($_POST['title']);
        $_POST['description'] = htmlspecialchars($_POST['description']);

        if(isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $imageMaxSize = 2097152;
            $validExtensions = array('jpg', 'jpeg', 'gif', 'png');

            if ($_FILES['image']['size'] <= $imageMaxSize) {
                $uploadExtension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                if (in_array($uploadExtension, $validExtensions)) {
                    $randomNumber = 20;
                    $randomString = bin2hex(random_bytes($randomNumber));

                    $imageFileName = $_SESSION['id'] . "_" . $randomString;

                    $resultUpload = \Cloudinary\Uploader::upload(
                        $_FILES['image']['tmp_name'],
                        array("public_id" => $imageFileName, "folder" => "jepsen-brite/events_img/", "resource_type" => "auto", "overwrite" => TRUE,
                            "width" => 400, "crop" => "limit")
                    ); // Upload fichier du dossier où est enregistré au cloud

                    if ($resultUpload != null) {
                        $imageName = $resultUpload["secure_url"];
                    } else {
                        throw new \Exception('There has been a problem during the upload of your image. Please try again.');
                    }
                } else {
                    $message = 'No valid extension file: your image must be a .jpg, .jpeg, .gif or .png file.';
                    $this->showEventModificationPage(showInfoMessage($message, false));
                }
            } else {
                $message = 'The image cannot be larger than 2MB.';
                $this->showEventModificationPage(showInfoMessage($message, false));
            }
        } elseif(isset($_POST['url']) && !empty($_POST['url'])) {
            $url = $_POST['url'];

            $imageName = '';

            if (strpos($url, 'facebook.com/') !== false) {
                // Facebook Video
                $imageName ='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';

            } else if(strpos($url, 'vimeo.com/') !== false) {
                // Vimeo video
                $videoId = isset(explode("vimeo.com/",$url)[1]) ? explode("vimeo.com/",$url)[1] : null;
                if (strpos($videoId, '&') !== false){
                    $videoId = explode("&",$videoId)[0];
                }
                $imageName ='https://player.vimeo.com/video/'.$videoId;

            } else if (strpos($url, 'youtube.com/') !== false) {
                // Youtube video
                $videoId = isset(explode("v=",$url)[1]) ? explode("v=",$url)[1] : null;
                if (strpos($videoId, '&') !== false){
                    $videoId = explode("&",$videoId)[0];
                }
                $imageName ='https://www.youtube.com/embed/'.$videoId;

            } else if(strpos($url, 'youtu.be/') !== false) {
                // Youtube  video
                $videoId = isset(explode("youtu.be/",$url)[1]) ? explode("youtu.be/",$url)[1] : null;
                if (strpos($videoId, '&') !== false) {
                    $videoId = explode("&",$videoId)[0];
                }
                $imageName ='https://www.youtube.com/embed/'.$videoId;

            } else if (strpos($url, 'dailymotion.com/') !== false) {
                // Dailymotion Video
                $videoId = isset(explode("dailymotion.com/",$url)[1]) ? explode("dailymotion.com/",$url)[1] : null;
                if (strpos($videoId, '&') !== false) {
                    $videoId = explode("&",$videoId)[0];
                }
                $imageName ='https://www.dailymotion.com/embed/'.$videoId;

            } else {
                $imageName = $url;
            }

        } else {
            $imageName = "https://res.cloudinary.com/dudwqzfzp/image/upload/c_limit,w_400/v1597389431/jepsen-brite/events_img/default_znnszq.jpg";
        }

        $eventReturnArr = $this->eventManager->createEvent(
            $_POST['title'],
            $_SESSION['id'],
            $_POST['event_date'],
            $_POST['event_hour'],
            $imageName,
            $_POST['description'],
            $_POST['category_id'],
            $_POST['address'],
            $_POST['town'],
            $_POST['cp']
        );

        if (isset($_POST['subcategory_id']) && !empty($_POST['subcategory_id']))
        {
            foreach ($_POST['subcategory_id'] as $selected)
            {
                $subcategoryAffectedLines = $this->subcategoryManager->createSubcategoryForEvent($selected, $eventReturnArr[1]);

                if ($subcategoryAffectedLines === false) {
                    throw new \Exception('Problem while creating an event. Please try again.');
                }

            }
        }

        if ($eventReturnArr[0] === false) {
            throw new \Exception('Problem while creating an event. Please try again.');
        }
        else
        {
            header('Location: ./index.php');
        }
    }

    public function showEventModificationPage($event, $subcategories, $message = null)
    {
        require('./view/modifyEvent.php');
    }

    public function updateExistingEvent($event, $subcategories)
    {
        $_POST['title'] = htmlspecialchars($_POST['title']);
        $_POST['description'] = htmlspecialchars($_POST['description']);

        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $imageMaxSize = 2097152;
            $validExtensions = array('jpg', 'jpeg', 'gif', 'png');

            if ($_FILES['image']['size'] <= $imageMaxSize) {
                $uploadExtension = strtolower(substr(strrchr($_FILES['image']['name'], '.'), 1));

                if (in_array($uploadExtension, $validExtensions)) {
                    $defaultImage = "default_znnszq";
                    $imageFromDbArr = explode('.', substr((strrchr($event['image'], '/')), 1));
                    $imageFromDb = $imageFromDbArr[0];

                    $isImageSessionNumberSet = explode('_', $imageFromDb);

                    if ($imageFromDb === $defaultImage OR $isImageSessionNumberSet[0] != $_SESSION['id']) {
                        $randomNumber = 20;
                        $randomString = bin2hex(random_bytes($randomNumber));

                        $imageFileName = $_SESSION['id'] . "_" . $randomString;
                    } else
                    {
                        $imageFileName = $imageFromDb;
                    }

                    $resultUpload = \Cloudinary\Uploader::upload(
                        $_FILES['image']['tmp_name'],
                        array("public_id" => $imageFileName, "folder" => "jepsen-brite/events_img/", "resource_type" => "auto", "overwrite" => TRUE,
                            "width" => 400, "crop" => "limit")
                    ); // Upload fichier du dossier où est enregistré au cloud

                    if ($resultUpload != null) {
                        $imageName = $resultUpload["secure_url"];
                    } else {
                        throw new \Exception('There has been a problem during the upload of your image. Please try again.');
                    }
                } else {
                    $message = 'No valid extension file: your image must be a .jpg, .jpeg, .gif or .png file.';
                    $this->showEventModificationPage($event, showInfoMessage($message, false));
                }
            } else {
                $message = 'The image cannot be larger than 2MB.';
                $this->showEventModificationPage($event, showInfoMessage($message, false));
            }
        } elseif(isset($_POST['url']) && !empty($_POST['url'])) {

            // If an image was previously set, remove from Cloudinary
            $imageFromDbArr = explode('.', substr((strrchr($event['image'], '/')), 1));
            $publicId = $imageFromDbArr[0];

            $isImageSessionNumberSet = explode('_', $publicId);

            if ($isImageSessionNumberSet[0] == $_SESSION['id']) {
                $resultDestroy = \Cloudinary\Uploader::destroy('jepsen-brite/events_img/' . $publicId);

                if ($resultDestroy == null) {
                    throw new \Exception('There has been a problem during the deletion of the uploaded image of this event.');
                }
            }

            // Video
            $url = $_POST['url'];

                $imageName = '';
            
                if (strpos($url, 'facebook.com/') !== false) {
                    // Facebook Video
                    $imageName ='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
            
                } else if(strpos($url, 'vimeo.com/') !== false) {
                    // Vimeo video
                    $videoId = isset(explode("vimeo.com/",$url)[1]) ? explode("vimeo.com/",$url)[1] : null;
                    if (strpos($videoId, '&') !== false){
                        $videoId = explode("&",$videoId)[0];
                    }
                    $imageName ='https://player.vimeo.com/video/'.$videoId;
            
                } else if (strpos($url, 'youtube.com/') !== false) {
                    // Youtube video
                    $videoId = isset(explode("v=",$url)[1]) ? explode("v=",$url)[1] : null;
                    if (strpos($videoId, '&') !== false){
                        $videoId = explode("&",$videoId)[0];
                    }
                    $imageName ='https://www.youtube.com/embed/'.$videoId;
            
                } else if(strpos($url, 'youtu.be/') !== false) {
                    // Youtube  video
                    $videoId = isset(explode("youtu.be/",$url)[1]) ? explode("youtu.be/",$url)[1] : null;
                    if (strpos($videoId, '&') !== false) {
                        $videoId = explode("&",$videoId)[0];
                    }
                    $imageName ='https://www.youtube.com/embed/'.$videoId;
            
                } else if (strpos($url, 'dailymotion.com/') !== false) {
                    // Dailymotion Video
                    $videoId = isset(explode("dailymotion.com/",$url)[1]) ? explode("dailymotion.com/",$url)[1] : null;
                    if (strpos($videoId, '&') !== false) {
                        $videoId = explode("&",$videoId)[0];
                    }
                    $imageName ='https://www.dailymotion.com/embed/'.$videoId;
            
                } else {
                    $imageName = $url;
                } 

        } else {
            $imageName = $event['image'];
        }

        $eventAffectedLines = $this->eventManager->updateEvent(
            $_GET['id'],
            $_POST['title'],
            $_SESSION['id'],
            $_POST['event_date'],
            $_POST['event_hour'],
            $imageName,
            $_POST['description'],
            $_POST['category_id'],
            $_POST['address'],
            $_POST['town'],
            $_POST['cp']
        );

        if (isset($subcategories) && !empty($subcategories))
        {
            foreach ($subcategories as $selected) {
                $subcategoryDeletedAffectedLines = $this->subcategoryManager->deleteSubcategoryForEvent($selected['id'], $event['id']);

                if ($subcategoryDeletedAffectedLines === false) {
                    throw new \Exception('Problem while modifying the event. Please try again.');
                }
            }
        }

        if (isset($_POST['subcategory_id']) && !empty($_POST['subcategory_id']))
        {
            foreach ($_POST['subcategory_id'] as $selected) {
                $subcategoryUpdatedAffectedLines = $this->subcategoryManager->createSubcategoryForEvent($selected, $event['id']);

                if ($subcategoryUpdatedAffectedLines === false) {
                    throw new \Exception('Problem while modifying the event. Please try again.');
                }
            }
        }

        if ($eventAffectedLines === false) {
            throw new \Exception('Problem while modifying the event. Please try again.');
        } else {
            // Sending to all participants of this event an email informing them of the update
            // uncomment for Heroku
            //$this->sendMailToParticipants($_GET['id'], 'updated');

            header('Location: ./index.php?action=showEvent&id=' . $_GET['id']);
        }
    }

    public function deleteExistingEvent($event)
    {
        // Deletion of Cloudinary image or video of the deleted event
        $defaultImage = "default_znnszq";
        $imageFromDbArr = explode('.', substr((strrchr($event['image'], '/')), 1));
        $publicId = $imageFromDbArr[0];

        if ($publicId != $defaultImage) {

            $resultDestroy = \Cloudinary\Uploader::destroy('jepsen-brite/events_img/' . $publicId);

            if ($resultDestroy == null) {
                throw new \Exception('There has been a problem during the deletion of the uploaded image of this event.');
            }
        }

        $eventsAffectedLines = $this->eventManager->deleteEvent($_GET['id']);
        $commentsAffectedLines = $this->commentManager->deleteAllComments($_GET['id']);
        $subcategoriesAffectedLines = $this->subcategoryManager->deleteAllSubcategoriesForEvent($_GET['id']);
        $participantsAffectedLines = $this->eventManager->deleteAllParticipantsByEvent($_GET['id']);

        if ($eventsAffectedLines === false) {
            throw new \Exception('Problem while deleting the event. Please try again.');
        } else if ($commentsAffectedLines === false) {
            throw new \Exception('Problem while deleting the comments of the event. Please try again.');
        } else if ($subcategoriesAffectedLines === false) {
            throw new \Exception('Problem while deleting the subcategories of the event. Please try again.');
        } else if ($participantsAffectedLines === false) {
            throw new \Exception('Problem while deleting the participants of the event. Please try again.');
        }
        else {
            header('Location: ./index.php');
        }
    }

    public function registerToEvent($eventId, $userId)
    {
        // Check if user's already taking part in the event
        $existingParticipantReq = $this->eventManager->getOneParticipantByEvent($eventId, $userId);
        $existingParticipant = $existingParticipantReq->fetch();

        if ($existingParticipant != false) {
            throw new \Exception("You're already participating, so you can't register again.");
        } else {
            // User's not yet participating
            $affectedLines = $this->eventManager->createParticipantByEvent($eventId, $userId);

            if ($affectedLines === false) {
                throw new \Exception('Problem while registering for this event. Please try again.');
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

        if ($existingParticipant === false) {
            throw new \Exception("You're not participating, so you can't unregister.");
        } else {
            $affectedLines = $this->eventManager->deleteParticipantByEvent($eventId, $userId);

            if ($affectedLines === false) {
                throw new \Exception('Problem while unregistrering from this event. Please try again.');
            } else {
                header('Location: ./index.php?action=showEvent&id=' . $eventId);
            }
        }
    }

    public function sendMailForTomorrowEvents()
    {
        $tomorrowUpcomingEvents = $this->eventManager->getTomorrowEvents();

        while($event = $tomorrowUpcomingEvents->fetch())
        {
            $this->sendMailToParticipants($event['id'], 'upcoming');
        }
    }

    public function checkIfVideoOrImage() {

        if (isset($_POST['image_or_video'])) {
            switch ($_POST['image_or_video']) {
                case 1:
                    ?>
                    <option value="1" selected>Image</option>
                    <option value="2">Video</option>
                    <?php
                    break;
                case 2:
                    ?>
                    <option value="1">Image</option>
                    <option value="2" selected>Video</option>
                    <?php
                    break;
            }
        } else {
            ?>
            <option value="1" selected>Image</option>
            <option value="2">Video</option>
            <?php
        }
    }

    public function sendMailToParticipants($eventId, $mailType)
    {
        $participantsMailReq = $this->userManager->getEmailAddressesOfParticipantsByEvent($eventId);

        $from = new Email(null, "becodechristest@gmail.com");

        $apiKey = getenv('SENDGRID_API_KEY');
        $sg = new \SendGrid($apiKey);

        switch($mailType)
        {
            case "updated":
                $subject = 'Updated event ';
                while($participant = $participantsMailReq->fetch())
                {
                    $contentValue = '<p>Hello!<br><br> We inform you that an event in which you take part has been updated on the website.<br><br> For more info, cf. <a href="https://team5-jepsen-brite.herokuapp.com/index.php?action=showEvent&id=' . $eventId . '">the event</a></p>';
                    $content = new Content("text/html", $contentValue);
                    $to = new Email(null, $participant['email']);
                    $mail = new Mail($from, $subject, $to, $content);

                    $response = $sg->client->mail()->send()->post($mail);
                }
                break;
            case "upcoming":
                $subject = 'Upcoming event ';
                while($participant = $participantsMailReq->fetch())
                {
                    $contentValue = '<p>Hello!<br><br> We inform you that an event in which you take part is programmed for tomorrow. Have fun!<br><br> For more info, cf. <a href="https://team5-jepsen-brite.herokuapp.com/index.php?action=showEvent&id=' . $eventId . '">the event</a></p>';
                    $content = new Content("text/html", $contentValue);
                    $to = new Email(null, $participant['email']);
                    $mail = new Mail($from, $subject, $to, $content);

                    $response = $sg->client->mail()->send()->post($mail);
                }
                break;
        }
    }

    // Display function
    public function displayAlreadyCheckedCategoryWhenCreatingOneEvent()
    {
        if (isset($_POST['category_id'])) {
            switch ($_POST['category_id']) {
                case 1:
?>
                    <option value="1" selected>Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 2:
                ?>
                    <option value="1">Concert</option>
                    <option value="2" selected>Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 3:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3" selected>Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 4:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4" selected>Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 5:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5" selected>Game Jam</option>
            <?php
                    break;
            }
        } else {
            ?>
            <option value="1" selected>Concert</option>
            <option value="2">Exhibition</option>
            <option value="3">Conference</option>
            <option value="4">Hackathon</option>
            <option value="5">Game Jam</option>
            <?php
        }
    }

    public function displayAlreadyCheckedCategoryWhenModifyingOneEvent($eventVariable)
    {
        if (isset($_POST['category_id'])) {
            switch ($_POST['category_id']) {
                case 1:
            ?>
                    <option value="1" selected>Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 2:
                ?>
                    <option value="1">Concert</option>
                    <option value="2" selected>Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 3:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3" selected>Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 4:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4" selected>Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 5:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5" selected>Game Jam</option>
                <?php
                    break;
            }
        } else {
            switch ($eventVariable['category_id']) {
                case 1:
                ?>
                    <option value="1" selected>Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 2:
                ?>
                    <option value="1">Concert</option>
                    <option value="2" selected>Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 3:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3" selected>Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 4:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4" selected>Hackathon</option>
                    <option value="5">Game Jam</option>
                <?php
                    break;
                case 5:
                ?>
                    <option value="1">Concert</option>
                    <option value="2">Exhibition</option>
                    <option value="3">Conference</option>
                    <option value="4">Hackathon</option>
                    <option value="5" selected>Game Jam</option>
<?php
                    break;
            }
        }
    }

    public function displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent($rawNumberValue, $textId)
    {
        $isInPost = false;

        if (isset($_POST['subcategory_id'])) {
            foreach ($_POST['subcategory_id'] as $selected) {
                if ($selected == $rawNumberValue) {
                    $isInPost = true;
                }
            }

            if ($isInPost) {
                echo '<input type="checkbox" id="' . $textId . '" name="subcategory_id[]" value="' . $rawNumberValue . '" checked>';
            } else {
                echo '<input type="checkbox" id="' . $textId . '" name="subcategory_id[]" value="' . $rawNumberValue . '">';
            }
        } else {
            echo '<input type="checkbox" id="' . $textId . '" name="subcategory_id[]" value="' . $rawNumberValue . '">';
        }
    }

    public function displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategoriesVariable, $rawNumberValue, $textId)
    {
        $isInPost = false;
        $isInDb = false;

        if (isset($_POST['subcategory_id'])) {
            foreach ($_POST['subcategory_id'] as $selected) {
                if ($selected == $rawNumberValue) {
                    $isInPost = true;
                }
            }

            if ($isInPost) {
                echo '<input type="checkbox" id="' . $textId . '" name="subcategory_id[]" value="' . $rawNumberValue . '" checked>';
            } else {
                echo '<input type="checkbox" id="' . $textId . '" name="subcategory_id[]" value="' . $rawNumberValue . '">';
            }
        } else if (isset($subcategoriesVariable)) {
            foreach ($subcategoriesVariable as $selected) {
                if ($selected['id'] == $rawNumberValue) {
                    $isInDb = true;
                }
            }

            if ($isInDb) {
                echo '<input type="checkbox" id="' . $textId . '" name="subcategory_id[]" value="' . $rawNumberValue . '" checked>';
            } else {
                echo '<input type="checkbox" id="' . $textId . '" name="subcategory_id[]" value="' . $rawNumberValue . '">';
            }
        } else {
            echo '<input type="checkbox" id="' . $textId . '" name="subcategory_id[]" value="' . $rawNumberValue . '">';
        }
    }
}
