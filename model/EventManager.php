<?php

require_once('Manager.php');

// TODO Homepage
//  - Système de pages : cf. https://openclassrooms.com/fr/courses/918836-concevez-votre-site-web-avec-php-et-mysql/6964512-tp-un-blog-avec-des-commentaires


/* TODO An event should contain at least :
    - Rich (MD et emojis) pour description et comments
    - An image : image for event (image en PHP ? Blob ?)
    - The author of an event, and only him, can UPDATE his own event.
    - The author of an event, and only him, can DELETE his own event.
    - Any user can post a comment on the event.
*/


class EventManager extends Manager
{
    public function getEvents()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, DATE_FORMAT(event_date, \'%d/%m/%Y %H:%i:%s\') AS event_date_formatted FROM events ORDER BY event_date LIMIT 0, 21');

        return $req;
    }

    public function getEvent($eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT e.id, e.title, DATE_FORMAT(e.event_date, \'%d/%m/%Y %H:%i:%s\') AS event_date_formatted, e.image, e.description, u.username, c.category FROM events AS e INNER JOIN users AS u ON e.author_id = u.id INNER JOIN categories AS c ON e.category_id = c.id WHERE e.id = ?');
        $req->execute(array($eventId));

        return $req;
    }

    /*public function updateEvent($eventId)
    {
        $db =$this->dbConnect();
        //$req = $db->prepare('INSERT INTO ');
    }

    public function deleteEvent($eventId)
    {
        $db =$this->dbConnect();
        $req = $db->prepare('DELETE FROM events WHERE id = ?');
        $req->execute(array($eventId));
    }*/
}