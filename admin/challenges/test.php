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
<title>CTF Challenges</title>
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
      <a href="../lectures/view.php">Lectures</a>
      <a class="active" href="./view.php">CTF Challenges</a>
      <a href="../labs/view.php">Labs</a>
    </div>
  </div>
  
  <div id="content">
    <div style="display: flex; justify-content: space-between;">
      <h2 style="margin-left: 12px">CTF Challenges</h2>
      <form action="./view.php" method="get" style="margin: 25px 25px 0px 0px;">
        <a href="add.php" id="add-btn">New Challenge <b>+</b></a> 
        <input type="text" name="search" id="search-input" placeholder="Search challenges...">
        <input id="search-btn" type="submit" value="Search">  
      </form>
    </div>
    <div id="ctf-navbar">
      <h3 style="margin-bottom: 20px">Category</h3>
      <!-- Category class in js -->
    </div>
    <div id="ctfAttempt-container">
      <?php
        if (isset($_GET['idctf'])) {
          $idctf = $_GET['idctf'];
        
          $sql = "SELECT * FROM ctf WHERE idctf = $idctf";
          $result = $db->query($sql);
        
          if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();  // Fetch only the first row (assuming single challenge)
            
            echo "<div><h2>" . $row['title'] . "</h2></div>";
            
            echo "<div><h4 style='margin-top:40px'>" . $row['type'] . "</h4></div>";
            
            echo "<div><h4 style='margin-bottom:10px'>Description</h4>";
            echo "<p style='margin-right:60px'>";
            $words = explode(' ', $row['des']);  // Split description into words
            $currentLine = "";  // Initialize an empty string for the current line
            foreach ($words as $word) {
              $proposedLine = $currentLine . $word . ' ';  // Add word and space to proposed line
              // Check if proposed line exceeds a threshold (adjust as needed)
              if (strlen($proposedLine) > 70) {  // Replace 50 with your desired character limit
                echo trim($currentLine, ' ') . "<br>";  // Print trimmed current line with line break
                $currentLine = $word . ' ';  // Start a new line with the current word
              } else {
                $currentLine = $proposedLine;  // Update current line if within limit
              }
            }
            // Handle remaining line and "Download" link
            $remainingLine = trim($currentLine, ' ') . " <a id='download-ctf'; href='../../files/ctf/" . $row['file'] . "' download>Download</a>";
            echo $remainingLine . "</p></div>";

            echo"<div>";
            echo"<h4 style='margin-bottom:10px'>Hint</h4>";
            echo"<a id='show-hint'>Show Hint</a>";
            echo"</div>";

            echo "<div>";
              echo "<form action='' method='post' style=''>";
              echo "  <input type='text' name='key' id='key-input' value='' placeholder='Enter the key...'>";
              echo "  <input type='submit' value='Submit' id='keySubmit'>";
              echo "<span id='ctfAttempted' style='margin-left:10px'></span>";
              if (isset($_POST['key'])) {
                if($_POST['key'] == $row['keyfile']){
                  echo "<span id='correct-key''>Correct!</span>";
                  echo "<script>document.getElementById('key-input').disabled = true;</script>";
                  echo "<script>document.getElementById('keySubmit').disabled = true;</script>";
                }
                else
                  echo "<span id='incorrect-key'>Incorrect!</span>";
              }
              echo "</form>";
            echo "</div>";
            
            echo "<div>";
            echo "<a href='edit.php?idctf=" . $idctf . "' id='edit-btn'>Edit Mode</a>";
            echo "<form action='./view.php' method='get' style='float: right;'>";  // Added form
              echo "  <input id='cancel-btn' type='submit' style='font-size: 1.3rem; padding: 7px 12px 7px 12px;' value='Close'>";
            echo "</form>";
            echo "</div>";
          } 
          else 
            echo "<h3>Challenge not found.</h3>";
        }
      ?>
    </div>
  </div>
  
  <script src="../../javascript.js"></script>
  <script src="../../javascriptCTF.js"></script>
  <script>
    const showHint = document.getElementById("show-hint");
    showHint.addEventListener("click", function() {
      const hintText = document.createElement("p");
      hintText.textContent = "<?php echo $row['hint']; ?>";
      // replace the button with the hint paragraph
      showHint.parentNode.replaceChild(hintText, showHint);
    });
  </script>

</body>

</html>
