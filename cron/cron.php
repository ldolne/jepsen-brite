<?php

use controller\EventController;

require_once('./controller/EventController.php');

//$eventController = new EventController();

function hello()
{
    $eventController = new EventController();
    $eventController->sendMailForTomorrowEvents();
}

