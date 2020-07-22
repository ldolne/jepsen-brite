<?php

require_once('Manager.php');

// TODO Homepage
//  - Système de pages : cf. https://openclassrooms.com/fr/courses/918836-concevez-votre-site-web-avec-php-et-mysql/6964512-tp-un-blog-avec-des-commentaires


/* TODO An event should contain at least :
    An image
    A description. It must be rich: it must interprets markdown and shows emojis.
    The author of an event, and only him, can UPDATE his own event. The update can be made as well on the same page as redirect to an other page (you're free to choose the best process).
    The author of an event, and only him, can DELETE his own event.
    There must be a link to the event creation page.
    Any user can post a comment on the event. It must interprets markdown and shows emojis.
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
}