<?php

require_once('Manager.php');

class CommentManager extends Manager
{
    public function getComments($eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT c.id, c.author_id, c.comment, DATE_FORMAT(c.comment_date, \'%d/%m/%Y %H:%i:%s\') AS comment_date_formatted, u.username, u.avatar
            FROM comments AS c 
            INNER JOIN users AS u 
            ON c.author_id = u.id 
            WHERE event_id = ? 
            ORDER BY comment_date');
        $req->execute(array($eventId));

        return $req;
    }

    public function getComment($commentId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT c.id, c.author_id
            FROM comments AS c 
            WHERE c.id = ?');
        $req->execute(array($commentId));

        return $req;
    }

    public function getCurrentCommentAuthorAvatar($userId)
    {
        $db = $this->dbConnect();
        $req = $db-> prepare('SELECT avatar FROM users WHERE id = ?');
        $req->execute(array($userId));

        return $req;
    }

    public function postComment($eventId, $authorId, $comment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comments(event_id, author_id, comment, comment_date) 
            VALUES(?, ?, ?, (NOW() + INTERVAL 2 HOUR))');
        $affectedLines = $req->execute(array($eventId, $authorId, $comment));

        return $affectedLines;
    }

    public function deleteOneComment($commentId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id = ?');
        $affectedLines = $req->execute(array($commentId));

        return $affectedLines;
    }

    public function deleteAllComments($eventId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE 
            FROM comments 
            WHERE comments.event_id = ?');
        $affectedLines = $req->execute(array($eventId));

        return $affectedLines;
    }

    public function updateCommentAuthorWhenDeletedAccount($userId)
    {
        $db =$this->dbConnect();
        $req = $db->prepare('UPDATE comments 
            SET author_id = 51
            WHERE author_id = ?');
        $req->execute(array($userId));

        return $affectedLines;
    }
}