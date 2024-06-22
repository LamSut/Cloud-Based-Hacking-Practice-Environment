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
    $avatar = base64_encode($row['avatar']);
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
$styleLXT = "style-LXT.css";
$logo = "Logo.png";
$settingBTN = "settings-icon.png";

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
  $style = "style-dark.css";
  $styleLXT = "style-dark-LXT.css";
  $logo = "Dark-Logo.png";
  $settingBTN = "Dark-settings-icon.png";
}
  $username = $_COOKIE["idacc"];
  $_SESSION['idacc'] = $username;
  $stmt = $db->prepare("select * from acc where idacc = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $avatar = base64_encode($row['avatar']);
?> 

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh">
<link rel="stylesheet" href="../../<?php echo $style; ?>?v=<?php echo time(); ?>">
<link rel="stylesheet" href="../../<?php echo $styleLXT; ?>?v=<?php echo time(); ?>">
<title>Lectures</title>
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
            <a href="../settings/index.php">Settings</a>
            <a href="../logout.php" role="button">Log Out</a>
          </div>
        </div>  
      </div>
    </div>
    <div id="navbar">
      <a href="../index.php">Home</a>
      <a class="active" href="../lectures/view.php">Lectures</a>
      <a href="../challenges/view.php">CTF Challenges</a>
      <a href="../labs/view.php">Labs</a>
    </div>
  </div>
  
  <div id="news-content">
    <?php
      $idlecture = $_GET['idlectures'];
      $sql = "SELECT title FROM lectures WHERE id_lectures= $idlecture";
      $result = $db->query($sql); // Execute the query and store the result

      // Check if there are any results
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch the first row as an associative array
        $title = $row['title']; // Extract the 'title' value from the row
        echo "<h3> $title </h3>";
      } else {
        echo "<h3> No lecture found with id: $idlecture <h3>"; // Handle no results case
      }

      // Close the result set (optional, recommended practice)
      $result->close();
    ?>

    <div id="addBox" class="box-add" style="margin-bottom: 60px;">
      <img src="data:image/png;base64,<?php echo $avatar; ?>" style="border-radius: 50%; height: 50px; width: 50px">
      <button id="addNewsBtn" class="button" onclick=submitForm()>Add news</button>
    </div>
    
    <!-- <div id="upFile" class="box-add" style="margin-bottom: 60px;">
      <img src="../../img/upload-icon.webp" width="35px" style="border-radius: 50%;">
      <button id="addNewsBtn" class="button">Upload files</button>
    </div> -->
   
  <!-- print message -->
  <?php
      $sql = "SELECT nf.*, a.avatar, a.name
        FROM newsfeed nf
        INNER JOIN acc a ON nf.idacc = a.idacc
        WHERE nf.id_lectures = $idlecture
        ORDER BY nf.timeSend DESC";
      $result = $db->query($sql);
      if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
          $avatar = base64_encode($row['avatar']);
          echo <<< data
            <div id="boxchat">
              <div class="author">
                <img src="data:image/png;base64,$avatar" style="border-radius: 50%; height: 50px; width: 50px">
                <p style="margin: 5px 10px 0px 15px">
                  <b style="font-size: 22px">$row[name]</b>
                <br>
                  <i style="font-size: 15px">$row[timeSend]</i>
                </p>
                <a href='?del=$row[idnews]' id="removeBtn" data-title="Delete message">
                    X
                </a>
              </div>
              <div class="message" style="font-size: 18px; margin-left:4px">
                $row[textNews]
              </div>
            </div>
          data;
        }
      }
    ?>
  </div>
  
  <script src="../../javascript.js"></script>
  <script>
    function submitForm() {
      const btnChange = document.getElementById('addNewsBtn');
      const replacement = document.createElement('form'); // Create form element to replace button

      replacement.setAttribute('id', 'addNewsForm'); // Set form ID
      replacement.setAttribute('method', 'post');
      replacement.setAttribute('class', 'form');
      btnChange.replaceWith(replacement);

      const textEle = document.createElement('textarea');
      textEle.setAttribute('id', 'textNews');
      textEle.setAttribute('name', 'textNews');
      textEle.setAttribute('rows', '3');
      textEle.setAttribute('cols', '120');
      textEle.setAttribute('placeholder', 'Enter message');
      replacement.appendChild(textEle);

      const submitEle = document.createElement('input');
      submitEle.setAttribute('id', 'submit-btn');
      submitEle.setAttribute('name', 'sendForm');
      submitEle.setAttribute('type', 'submit');
      submitEle.innerHTML = 'Submit';
      submitEle.addEventListener('submit', event => {
        event.preventDefault();
        replacement.replaceWith(btnChange);
      });
      replacement.appendChild(submitEle);

      const cancelEle = document.createElement('button');
      cancelEle.setAttribute('id', 'cancel-btn');
      cancelEle.setAttribute('type', 'button');
      cancelEle.innerHTML = 'Cancel';
      cancelEle.addEventListener('click', () => {
        replacement.replaceWith(btnChange); // Replace form with button on cancel
      });
      replacement.appendChild(cancelEle);
    }
    
    
  </script>
    <?php
      if(isset($_GET['idlectures'])) {
        if (isset($_POST['sendForm']) && !empty($_POST['textNews'])) {
          $textNews = $_POST['textNews']; 
          $idacc = $_COOKIE['idacc'];
          date_default_timezone_set("Asia/Ho_Chi_Minh");
          $idlecture = $_GET['idlectures'];
          $sql = "INSERT INTO newsfeed (idacc, textNews, timeSend, id_lectures) VALUES ('$idacc', '$textNews', sysdate(), '$idlecture');";
          $db->query($sql);
          echo '<script>window.location.href = "http://localhost/w0rm/admin/lectures/chats.php?idlectures=' . $idlecture .'";</script>'; // Redirect to page
          // header('Location: http://localhost/w0rm/admin/lectures/chats.php' . '?idlectures=' . $idlecture);
          // echo '<script>window.location.replace("http://localhost/w0rm/user/lectures/chats.php?idlectures=' . $idlecture . '")</script>';
          exit();
        }

        if(isset($_GET['del'])){
            $idlecture = $_GET['idlectures'];
            $sql = "DELETE FROM newsfeed WHERE idnews=? AND id_lectures=?";
            $stmt = mysqli_prepare($db, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $_GET['del'], $_GET['idlectures']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            
            // echo '<script>window.location.href = "http://localhost/w0rm/user/lectures/chats.php";</script>'; // Redirect to page
            echo '<script>window.location.replace("http://localhost/w0rm/admin/lectures/chats.php?idlectures=' . $idlecture . '")</script>';
            exit();
        }
      } else {
        echo "No lecture found";
      }
    ?>
</body>

</html>
