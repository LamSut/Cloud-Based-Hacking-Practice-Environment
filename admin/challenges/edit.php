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

if (isset($_GET['idctf'])) {
  $idctf = $_GET['idctf'];

  $stmt = $db->prepare("select * from ctf where idctf = ?");
  $stmt->bind_param("s", $idctf);  
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();

  if ($result->num_rows > 0) {
    $title = $row['title'];
    $type= $row['type'];
    $des = $row['des'];
    $hint = $row['hint'];
    $filename = $row['file'];
    $keyfile = $row['keyfile'];
  }
}


?> 

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../<?php echo $style; ?>?v=<?php echo time(); ?>">
<title>Edit Challenge</title>
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
    <form action="edit-action.php?idctf=<?php echo isset($idctf) ? $idctf : ''; ?>" method="post" id="edit-container" enctype='multipart/form-data'>
        <div style="display: flex">
            <label for="title" style="font-size: 1.6rem; margin-top: 40px"><b>Title:</b></label>
            <input type="text" id="title" name="title" style="height:25px; width:250px; margin-top: 40px; font-size: 1.4rem;" maxlength="50" required
            value="<?php echo isset($title) ? $title : ''; ?>"><br><br>
        </div>
        <div>
            <h2>Edit Mode</h2>
        </div>
        <div>
            <label for="des"><b>Description:</b></label><br>
            <textarea id="des" name="des" rows="5" cols="45" maxlength="160" required style="font-size: 1.1rem;" ><?php echo isset($des) ? trim($des) : ''; ?></textarea><br><br>

            <label for="file"><b>File:</b></label>
            <a id='download-ctf'; href='../../files/ctf/<?php echo isset($filename) ? trim($filename) : ''; ?>' download>Current File</a>
            <input type="file" id="file" name="file" style="margin-left:5px; font-size: 1.0rem; width:210px"> 
            <br><br>
        </div>
        <div>
            <br>
            <label for="type"><b>Type:</b></label>
                <select id="type" name="type" required style="font-size: 1.0rem; margin-left:5px">
                    <option value="">Select Type</option>
                    <option value="Reverse Engineering" <?php echo isset($type) && $type == 'Reverse Engineering' ? 'selected' : ''; ?>>Reverse Engineering</option>
                    <option value="Web Exploitation" <?php echo isset($type) && $type == 'Web Exploitation' ? 'selected' : ''; ?>>Web Exploitation</option>
                    <option value="Binary Exploitation" <?php echo isset($type) && $type == 'Binary Exploitation' ? 'selected' : ''; ?>>Binary Exploitation</option>
                    <option value="Forensics" <?php echo isset($type) && $type == 'Forensics' ? 'selected' : ''; ?>>Forensics</option>
                    <option value="Cryptography" <?php echo isset($type) && $type == 'Cryptography' ? 'selected' : ''; ?>>Cryptography</option>
                </select><br><br>
            <label for="hint"><b>Hint:</b></label><br>
            <textarea id="hint" name="hint" rows="3" cols="30" maxlength="60" style="font-size: 1.1rem;" required><?php echo isset($hint) ? $hint : ''; ?></textarea><br><br>
        </div>
        <div>
            <label for="key"><b>Key:</b></label>
            <input type="text" id="key" name="key" required value="<?php echo isset($keyfile) ? $keyfile : ''; ?>"><br><br>
        </div>
        <div>
            <input type="submit" value="Confirm" onclick="return confirm('Apply your changes?')">
    </form>
            <button id="cancel-btn" type="button" onclick="location.href='test.php?idctf=<?php echo $idctf; ?>'">Cancel</button>
            <form action="delete-action.php" method="post" style="float: right;">
              <input type="hidden" name="idctf" value="<?php echo $idctf; ?>">
              <input id="delete-btn" type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete?')">
            </form>
        </div>
 
  </div>
  
  <script src="../../javascript.js"></script>
  <script src="../../javascriptCTF.js"></script>

</body>

</html>
