<?php
class comment{
    private $id, $commentFor, $commentMadeBy, $comment , $commentDate;

    public function __construct($commentFor, $commentMadeBy, $comment, $commentDate) {
        $this->commentFor = $commentFor;
        $this->commentMadeBy = $commentMadeBy;
        $this->comment = $comment;
        $this->commentDate = $commentDate;
    }

    public function getID() {
        return $this->id;
    }
    public function setID($value) {
        $this->id = $value;
    }

    public function getCommentFor() {
        return $this->commentFor;
    }
    public function setCommentFor($value) {
        $this->commentFor = $value;
    }

    public function getCommentMadeBy() {
        return $this->commentMadeBy;
    }
    public function setCommentMadeBy($value) {
        $this->commentMadeBy = $value;
    }

    public function getComment() {
        return $this->comment;
    }
    public function setComment($value) {
        $this->comment = $value;
    }

    public function getCommentDate() {
        return $this->commentDate;
    }
    public function setCommentDate($value) {
        $this->commentDate = $value;
    }
}
?>