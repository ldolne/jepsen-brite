<?php

require_once('Manager.php');

class CommentManager extends Manager
{
    public function getComments($eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT c.id, c.comment, DATE_FORMAT(c.comment_date, \'%d/%m/%Y %H:%i:%s\') AS comment_date_formatted, u.username FROM comments AS c INNER JOIN users AS u ON c.author_id = u.id WHERE event_id = ? ORDER BY comment_date');
        $req->execute(array($eventId));

        return $req;
    }

    public function postComment($eventId, $authorId, $comment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comments(event_id, author_id, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $req->execute(array($eventId, $authorId, $comment));

        return $affectedLines;
    }
}