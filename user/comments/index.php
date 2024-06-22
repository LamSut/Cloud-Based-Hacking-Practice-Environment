<?php
require_once "../../login/config.php";
session_start();

if (!isset($_SESSION['idacc'])){
  if(isset($_COOKIE["idacc"])){
    $username = $_COOKIE["idacc"];
    $_SESSION['idacc'] = $username;
    $stmt = $db->prepare("select * from acc where idacc = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $_SESSION['name']= $row['name'];
    $_SESSION['admin']= $row['admin'];
    $_SESSION['darkmode']= $row['darkmode'];
  }
  else{
    header("location: ../../login/index.php");
    exit;
  }  
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1){
  header("location: ../../admin/index.php");
  exit;
}

$style = "style.css"; // Default css for light mode
$logo = "Logo.png";
$settingBTN = "settings-icon.png";

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
  $style = "style-dark.css";
  $logo = "Dark-Logo.png";  
  $settingBTN = "Dark-settings-icon.png";
}

if (isset($_POST['cmt-content'])) {

  $content = $_POST['cmt-content'];
  $idacc = $_SESSION["idacc"];

  $stmt = $db->prepare("INSERT INTO cmt(content, time, idacc) VALUES (?, sysdate(), ?)");
  $stmt->bind_param("ss", $content, $idacc);

  if ($stmt->execute()) {
      header("location: thankyou.php");
  } else {
      echo "Error: " . $stmt->error;
  }

  $stmt->close();
  mysqli_close($db);
}

?> 



<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../<?php echo $style; ?>?v=<?php echo time(); ?>">
<style>
  #cmt-content{
    display: block;
    font-size: 1.0rem;
    font-family: "Open Sans", sans-serif;
    margin-top: 10px;
    padding: 8px;
  }
</style>
<title>Comment</title>
</head>

<body>

  <div id="header">
    <div id="top">
    <a href="../index.php"><img src="../../img/<?php echo $logo; ?>" alt="W0rm" style="height: 80px;"></a>
      <div id="usermenu">
        <div style="float:right">
          <span><?php echo $_SESSION["name"];?></span>
          <button onclick="usermenu()" class="drop-btn"><img src="../../img/<?php echo $settingBTN; ?>" style="height: 25px;"></button>
        </div>
        <div class="dropdown">
          <div id="dropdownContent" class="dropdown-content">
            <a href="../profile/view.php">Profile</a>
            <a href="">Comments</a>
            <a href="../settings/index.php">Settings</a>
            <a href="../logout.php" role="button">Log Out</a>
          </div>
        </div>  
      </div>
    </div>
    <div id="navbar">
      <a href="../index.php">Home</a>
      <a href="../lectures/view.php">Lectures</a>
      <a href="../challenges/view.php">CTF Challenges</a>
      <a href="../labs/view.php">Labs</a>
    </div>
  </div>
  
  <div id="content">
    <h4>Please give your comments to help us enhance our website</h4>
    <form id="cmt-form" method="post" action="">
      <label for="cmt-content">From <?php echo $_SESSION["name"];?> - <?php echo $_SESSION["idacc"];?>:</label>
      <textarea id="cmt-content" name="cmt-content" placeholder="(max 500 letters)" rows="6" cols="70" maxlength="400" required></textarea><br>
      <input type="submit" value="Submit" style="margin-left:425px;">
      <button id="clear-btn" type="button" onclick="clearfunc()">Clear</button>
    </form>
  </div>
  
  <script src="../../javascript.js"></script>
  <script>
    function clearfunc(){
      document.getElementById("cmt-content").value="";
    } 
  </script>
</body>

</html>
