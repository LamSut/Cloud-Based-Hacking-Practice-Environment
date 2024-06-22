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

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
  $style = "style-dark.css";
  $logo = "Dark-Logo.png";
  $settingBTN = "Dark-settings-icon.png";
}

$currentPasswordErr = $newPasswordErr = $confirmPasswordErr = "";
$newPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];
  
  $username = $_SESSION["idacc"];
  $stmt = $db->prepare("SELECT * FROM acc WHERE idacc = ?");
  $stmt->execute([$username]);

  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  
  $validpass=$row['pass'];
  $hashNewPassword= hash("sha256", $newPassword);

  if (strlen($newPassword) < 8) 
    $newPasswordErr = "New password must be at least 8 characters long";
  else if (strcmp($hashNewPassword, $validpass)==0)
    $newPasswordErr = "New password must be different from current password";
  else if ($confirmPassword !== $newPassword)
    $confirmPasswordErr = "Do not match with new password";
  else {
      $stmt = $db->prepare("UPDATE acc SET pass=? WHERE idacc=?");
      $stmt->bind_param("ss", $hashNewPassword, $username);

      if ($stmt->execute()) {
        ?>
        <script>
          alert("Changed password successfully!");
          window.location = "../index.php";
        </script>
        <?php
      }
      else 
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
<title>Change password</title>
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
            <a href="../comments/index.php">Comments</a>
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
    <h4>Change Password</h4>
    <form id="change-password-form" method="post" action="password-change.php">  
      <br>

      <label for="newPassword">Enter new password:</label>
      <input type="password" id="newPassword" name="newPassword" value="<?php echo $newPassword; ?>" required>
      <?php echo "<p class='error'>" . $newPasswordErr . "</p>"; ?>
      <br><br>

      <label for="confirmPassword">Confirm new password:</label>
      <input type="password" id="confirmPassword" name="confirmPassword" required>
      <?php echo "<p class='error'>" . $confirmPasswordErr . "</p>"; ?>
      <br><br>

      <input type="submit" value="Change Password" onclick="return confirm('Change your password?')">
      <button id="cancel-btn" type="button" onclick="location.href='index.php'">Cancel</button>
    </form>
  </div>
  
  <script src="../../javascript.js"></script>
</body>

</html>
