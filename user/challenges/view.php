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
      <a class="active" href="">CTF Challenges</a>
      <a href="../labs/view.php">Labs</a>
    </div>
  </div>
  
  <div id="content">
    <div style="display: flex; justify-content: space-between;">
      <h2 style="margin-left: 12px">CTF Challenges</h2>
      <form action="" method="get" style="margin: 25px 25px 0px 0px;">
        <input type="text" name="search" id="search-input" placeholder="Search challenges...">
        <input id="search-btn" type="submit" value="Search">  
      </form>
    </div>
    <div id="ctf-navbar">
      <h3 style="margin-bottom: 20px">Category</h3>
      <!-- Category class in js -->
    </div>
    <div id="ctf-container">
      <?php
      $limit = 9;
      $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $offset = ($currentPage - 1) * $limit;
      
      $search = isset($_GET['search']) ? $_GET['search'] : '';  // Get search term from URL

      $stmt = $db->prepare("SELECT idctf, title, type FROM ctf WHERE title LIKE ? OR type LIKE ? ORDER BY idctf DESC LIMIT ?, ?");
      $search_term = "%$search%"; // Add wildcards for partial matches
      $stmt->bind_param("ssss", $search_term,$search_term, $offset, $limit);

      $stmt->execute();
      $result = $stmt->get_result();
      
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $attemptedClass = "";
          $stmt2 = $db->prepare("SELECT idctf FROM ctfAttempt WHERE idacc = ? AND idctf = ?");
          $stmt2->bind_param("si", $_SESSION['idacc'], $row['idctf']);
          $stmt2->execute();
          $attemptResult = $stmt2->get_result();
          if ($attemptResult->num_rows > 0) {
            $attemptedClass = "attempedCTF"; // add class if attempted
          }
          $stmt2->close();
      
          echo "<a class='" . $attemptedClass . "' href='test.php?idctf=" . $row['idctf'] . "'>";
          echo "<div class='ctf-row'>";
          echo "<h4>" . $row['title'] . "</h4>";
          echo "<p>" . $row['type'] . "</p>";
          echo "</div>";
          echo "</a>";
        }
      } else {
        echo "<p>No CTF challenges found.</p>";
      }
      ?>
    </div>
    <?php

      $stmt1 = $db->prepare("SELECT title, type FROM ctf WHERE title LIKE ? OR type LIKE ?");
      $search_term1 = "%$search%"; // Add wildcards for partial matches
      $stmt1->bind_param("ss", $search_term, $search_term);

      $stmt1->execute();
      $result1 = $stmt1->get_result();
      
      $totalChallenges = $result1->num_rows; // Replace with function to get total CTF entries

      $totalPages = ceil($totalChallenges / $limit);

      if ($totalPages > 1) {
        echo "<div class='pagination'>";
      
        // Generate previous page link (if not on first page)
        if ($currentPage > 1) {
          $prevPage = $currentPage - 1;
          $prevUrl = "?search=$search&page=$prevPage";  
          echo "<a href='?search=$search&page=1'>First</a>";
          echo "<a href='$prevUrl'><</a>";
        }
        else{
          echo "<a href='?search=$search&page=1'>First</a>";
          echo "<a href=''><</a>";
        }
      
        // Generate page number links
        if($totalPages<6){
          for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? "active" : "";
            $pageUrl = "?search=$search&page=$i";  
            echo "<a class='$activeClass' href='$pageUrl'>$i</a>";
          }
        }
        else{
          if ($currentPage < 4) {
            for ($i = 1; $i <= 5; $i++) {
              $activeClass = ($i == $currentPage) ? "active" : "";
              $pageUrl = "?search=$search&page=$i";
              echo "<a class='$activeClass' href='$pageUrl'>$i</a>";
            }
            
          }
          else if ($currentPage == $totalPages) {
            
            for ($i = $currentPage - 4; $i <= $totalPages; $i++) {
              $activeClass = ($i == $currentPage) ? "active" : "";
              $pageUrl = "?search=$search&page=$i";  
              echo "<a class='$activeClass' href='$pageUrl'>$i</a>";
            }
          }
          else if ($currentPage + 2 > $totalPages) {
            
            for ($i = $currentPage - 3; $i <= $totalPages; $i++) {
              $activeClass = ($i == $currentPage) ? "active" : "";
              $pageUrl = "?search=$search&page=$i";  
              echo "<a class='$activeClass' href='$pageUrl'>$i</a>";
            }
          } else {
            
            for ($i = $currentPage - 2; $i <= $currentPage + 2; $i++) {
              $activeClass = ($i == $currentPage) ? "active" : "";
              $pageUrl = "?search=$search&page=$i"; 
              echo "<a class='$activeClass' href='$pageUrl'>$i</a>";
            }
            
          }
        }
      
        // Generate next page link (if not on last page)
        if ($currentPage < $totalPages) {
          $nextPage = $currentPage + 1;
          $nextUrl = "?search=$search&page=$nextPage";  
          echo "<a href='$nextUrl'>></a>";
          echo "<a href='?search=$search&page=" . ($totalPages) . "'>Last</a>";
        }
        else{
          echo "<a href=''>></a>";
          echo "<a href='?search=$search&page=" . ($totalPages) . "'>Last</a>";
        }
        
        echo "</div>";
      }
    ?>
  </div>
  
  <script src="../../javascript.js"></script>
  <script src="../../javascriptCTF.js"></script>

</body>

</html>
