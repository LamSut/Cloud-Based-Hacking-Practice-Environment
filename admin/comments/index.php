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
?> 



<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../<?php echo $style; ?>?v=<?php echo time(); ?>">
<style>
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
    <h4>Comments from users: </h4>
    <div id="comments-container"></div>
  </div>
  
  <script src="../../javascript.js"></script>

  <script>
    //AJAX functionality
    function makeRequest(url, method, data, callback) {
      var xhr = new XMLHttpRequest();
      xhr.open(method, url);
      xhr.onload = function() {
        if (xhr.status === 200) {
          callback(xhr.responseText);
        } else {
          console.error("Request failed:", xhr.statusText);
        }
      };
      if (method === "POST") {
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      }
      xhr.send(data);
    }

    window.onload = function(){
      var offset = 0;

      // Load initial comments
      loadComments(offset);

      function loadComments(offset) {
        makeRequest("comments.php", "POST", "offset=" + offset, function(response) {
          var commentElement = document.createElement('div');
          commentElement.innerHTML = response; // Parse response into HTML element
          console.log(response);
          document.getElementById("comments-container").append(commentElement);
        });
      }

      window.addEventListener("scroll", function() {
        // Check if user scrolled near the bottom of the page
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
          offset += 6; // Update offset for next request
          loadComments(offset); // Load more comments
        }
      });
    };
  </script>

</body>

</html>
