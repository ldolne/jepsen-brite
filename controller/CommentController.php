<?php

// COMMENT CONTROLLERS
namespace controller;

require_once('autoloader.php');

class CommentController
{
    public function handleComment()
    {
        $commentManager = new CommentManager();

        $commentReq = $commentManager->getComment($_GET['comment_id']);
        $comment = $commentReq->fetch();

        if (empty($comment))
        {
            throw new Exception('Comment ID does not exist.');
        }
        else
        {
            return $comment;
        }
    }

    public function addComment($eventId, $authorId, $comment)
    {
        $commentManager = new CommentManager();

        $affectedLines = $commentManager->postComment($eventId, $authorId, $comment);

        if ($affectedLines === false) {
            throw new Exception('Problem while adding a comment. Please try again.');
        } else {
            header('Location: ./index.php?action=showEvent&id=' . $eventId);
        }
    }

    public function deleteExistingComment()
    {
        $commentManager = new CommentManager();

        $affectedLines = $commentManager->deleteOneComment($_GET['comment_id']);

        if ($affectedLines === false) {
            throw new Exception('Problem while deleting the comment. Please try again.');
        } else {
            header('Location: ./index.php?action=showEvent&id=' . $_GET['id']);
        }
    }
}