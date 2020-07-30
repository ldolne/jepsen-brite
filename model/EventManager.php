<?php

require_once('Manager.php');

class EventManager extends Manager
{
    public function getUpcomingEvents()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT e.id, e.title, DATE_FORMAT(e.event_date, \'%d/%m/%Y\') AS event_date_formatted, DATE_FORMAT(e.event_hour, \'%H:%i\') AS event_hour_formatted, c.category
            FROM events AS e 
            INNER JOIN categories AS c 
            ON e.category_id = c.id
            WHERE event_date > current_date OR (event_date = current_date AND event_hour > current_time) 
            ORDER BY event_date, event_hour LIMIT 0, 21');

        return $req;
    }

    public function getPastEvents()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT e.id, e.title, DATE_FORMAT(e.event_date, \'%d/%m/%Y\') AS event_date_formatted, DATE_FORMAT(e.event_hour, \'%H:%i\') AS event_hour_formatted, c.category
            FROM events AS e
            INNER JOIN categories AS c 
            ON e.category_id = c.id
            WHERE event_date < current_date OR (event_date = current_date AND event_hour < current_time)
            ORDER BY event_date DESC, event_hour DESC LIMIT 0, 21');

        return $req;
    }

    public function getEvent($eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT e.id, e.title, e.author_id, e.event_date, DATE_FORMAT(e.event_date, \'%d/%m/%Y\') AS event_date_formatted, DATE_FORMAT(e.event_hour, \'%H:%i\') AS event_hour_formatted, e.image, e.description, u.username, c.id AS category_id, c.category 
            FROM events AS e 
            INNER JOIN users AS u ON e.author_id = u.id 
            INNER JOIN categories AS c 
            ON e.category_id = c.id 
            WHERE e.id = ?');
        $req->execute(array($eventId));

        return $req;
    }

    public function createEvent($title, $authorId, $eventDate, $eventHour, $image, $description, $categoryId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO events(title, author_id, event_date, event_hour, image, description, category_id) 
            VALUES (:title, :author_id, :event_date, :event_hour, :image, :description, :category_id)');
        $affectedLines = $req->execute(array(
            'title' => $title,
            'author_id' => $authorId,
            'event_date' => $eventDate,
            'event_hour' => $eventHour,
            'image' => $image,
            'description' => $description,
            'category_id' => $categoryId
        ));

        return $affectedLines;
    }

    public function updateEvent($eventId, $title, $authorId, $eventDate, $eventHour, $image, $description, $categoryId)
    {
        $db =$this->dbConnect();
        $req = $db->prepare('UPDATE events 
            SET title = :title, author_id = :author_id, event_date = :event_date, event_hour = :event_hour, image = :image, description = :description, category_id = :category_id 
            WHERE id = :id');
        $req->execute(array(
            'title' => $title,
            'author_id' => $authorId,
            'event_date' => $eventDate,
            'event_hour' => $eventHour,
            'image' => $image,
            'description' => $description,
            'category_id' => $categoryId,
            'id' => $eventId
        ));
    }

    public function deleteEvent($eventId)
    {
        $db =$this->dbConnect();
        $req = $db->prepare('DELETE FROM events WHERE id = ?');
        $affectedLines = $req->execute(array($eventId));

        return $affectedLines;
    }

    public function updateEventAuthorWhenDeletedAccount($userId)
    {
        $db =$this->dbConnect();
        $req = $db->prepare('UPDATE events 
            SET author_id = 51
            WHERE author_id = ?');
        $req->execute(array($userId));

        return $affectedLines;
    }
}