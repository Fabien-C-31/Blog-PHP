<?php
require_once("model/Manager.php");

class CommentManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();
		
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC');
        $comments->execute(array($postId));

        return $comments;
    }

    public function postComment($postId, $author, $comment)
    {
        $db = $this->dbConnect();
		
        $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        return $affectedLines;
    }

	public function view($commentId) 
{
    	$db = $this->dbConnect();
		
    	$comment = $db->prepare('SELECT id, comment FROM comments WHERE id = ?');
    	$comment->execute(array($commentId));
    	$viewcomment = $comment->fetch();
 
    return $viewcomment;
}
	
	public function edit($postId, $commentId, $newcomment)
{
    $db = $this->dbConnect();
		
    $changecomment= $db->prepare('UPDATE comments SET comment = ? WHERE id=?');
    $affectedComment = $changecomment->execute(array($newcomment,$postId));
 
    return $affectedComment;
}
		
   }