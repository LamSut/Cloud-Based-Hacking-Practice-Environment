<?php
require_once "../../login/config.php";
session_start();

class Challenge {
  public $idctf;
  public $title;
  public $type;
  public $des;
  public $hint;
  public $file;
  public $keyfile;
  public $author;

  public function __construct($title, $type, $des, $hint, $file, $keyfile, $author, $idctf) {
      $this->idctf = $idctf;

      // Check for and handle duplicate titles with a loop
      $titleValid = $title;
      $duplicateCount = 1;
      while ($duplicateCount == 1) {
          $sql = "SELECT COUNT(*) FROM ctf WHERE title = ? AND idctf <> ?";
          $stmt = $GLOBALS['db']->prepare($sql);
          $stmt->bind_param("si", $titleValid , $idctf);
          $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();
          if ($row['COUNT(*)'] === 0) {
            $duplicateCount=0;
            break;
          }
          $titleValid = $titleValid . "+";
          $stmt->close();
      }
      
      $this->title = $titleValid;
      $this->type = $type;
      $this->des = $des;
      $this->hint = $hint;
      $this->file = $file;
      $this->keyfile = $keyfile;
      $this->author = $author;
  }

  public function insertChallenge() {
    $sql = "INSERT INTO ctf (title, type, des, hint, file, keyfile, time, author)
             VALUES (?, ?, ?, ?, ?, ?, sysdate(), ?)";
    $stmt = $GLOBALS['db']->prepare($sql);
    $stmt->bind_param("sssssss", $this->title, $this->type, $this->des, $this->hint, $this->file, $this->keyfile, $this->author);
    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
    $stmt->close();
  }

  public function updateChallenge($idctf) {
    if($this->file!=null){
      $sql = "UPDATE ctf SET title = ?, type = ?, des = ?, hint = ?, file = ?, keyfile = ? WHERE idctf = ?";
      $stmt = $GLOBALS['db']->prepare($sql);
      $stmt->bind_param("sssssss", $this->title, $this->type, $this->des, $this->hint, $this->file, $this->keyfile, $idctf);
      if ($stmt->execute()) {
        return true;
      } else {
        return false;
      }
      $stmt->close();
    }
    else {
      $sql = "UPDATE ctf SET title = ?, type = ?, des = ?, hint = ?, keyfile = ? WHERE idctf = ?";
      $stmt = $GLOBALS['db']->prepare($sql);
      $stmt->bind_param("ssssss", $this->title, $this->type, $this->des, $this->hint, $this->keyfile, $idctf);
      if ($stmt->execute()) {
        return true;
      } else {
        return false;
      }
      $stmt->close();
    }
  }
}
?>