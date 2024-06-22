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

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 0){
  header("location: ../../user/index.php");
  exit;
}

$style = "style.css";
$logo = "Logo.png";
$settingBTN = "settings-icon.png";
$switchto = "Dark";
$switchpic = "moon.png";

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
  $style = "style-dark.css";
  $logo = "Dark-Logo.png";
  $settingBTN = "Dark-settings-icon.png";
  $switchto ="Light";
  $switchpic = "sun.png";
}

if (isset($_POST['darkMode'])) {
  $changemode = $_POST['darkMode'];
  $idacc = $_SESSION["idacc"];

  // Prepare the SQL statement
  $stmt = $db->prepare("UPDATE acc SET darkmode=? WHERE idacc=?");
  $stmt->bind_param("is", $changemode, $idacc);

  // Execute the statement
  if ($stmt->execute()) {
      header("location: index.php");
      $_SESSION['darkmode']= $changemode;
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
<title>Settings</title>
</head>

<body>

  <div id="header">
    <div id="top">
      <a href=""><img src="../../img/<?php echo $logo; ?>" alt="W0rm" style="height: 80px"></a>
      <div id="usermenu">
        <div style="float:right">
          <span><?php echo $_SESSION["name"];?></span>
          <button onclick="usermenu()" class="drop-btn"><img src="../../img/<?php echo $settingBTN; ?>" style="height: 25px;"></button>
        </div>
          <div class="dropdown">
          <div id="dropdownContent" class="dropdown-content">
            <a href="../profile/view.php">Profile</a>
            <a href="../comments/index.php">Comments</a>
            <a href="">Settings</a>
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
    <h2>Settings:</h2>
    <div class="settings">
      <p><span style="margin-right: 10px;">Change Avatar:</span> <a class="edit" href="avatar-change.php">Edit</a></p>
      <p><span style="margin-right: 10px;">Change password:</span> <a class="edit" href="password-verify.php">Edit</a></p>
      <form id="darkModeForm" method="post" style="display: inline-block;">
        <input type="hidden" name="darkMode" value="<?php echo ($switchto == "Dark" ? 1 : 0); ?>"> 
          <button type="submit" class="edit" style="font-size: 1.2rem; font-weight: bold; border: none; background-color: transparent; padding: 0; cursor: pointer">
            Switch to <?php echo $switchto; ?> Mode <img src="../../img/<?php echo $switchpic; ?>" style="height: 25px;">
          </button>
      </form>
    </div>
  </div>
  <script src="../../javascript.js"></script>

</body>

</html>
