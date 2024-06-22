<?php
require_once "../login/config.php";
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
    header("location: ../login/index.php");
    exit;
  }  
}

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 0){
  header("location: ../user/index.php");
  exit;
}

$style = "style.css";
$styleDHH = "style-DHH.css";
$logo = "Logo.png";
$home = "Home.png";
$settingBTN = "settings-icon.png";

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
  $style = "style-dark.css";
  $styleDHH = "style-dark-DHH.css";
  $logo = "Dark-Logo.png";
  $home = "Dark-Home.png";
  $settingBTN = "Dark-settings-icon.png";
}
?> 

<!DOCTYPE html>
<html>

<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Home</title>
   <link rel="stylesheet" href="../<?php echo $style; ?>?v=<?php echo time(); ?>">
   <link rel="stylesheet" href="../<?php echo $styleDHH; ?>?v=<?php echo time(); ?>">
   <style>
      td, th {
         padding: 4px 0px 2px 10px;
      }
      span {
         font-size: 1.4rem;
      }
      h2 {
        text-align: center;
        margin: 20px 0px 20px 0px;
      }
   </style>
</head>

<body>

  <div id="header">
    <div id="top">
      <a href=""><img src="../img/<?php echo $logo; ?>" alt="W0rm" style="height: 80px"></a>
      <div id="usermenu">
        <div style="float:right">
          <span><?php echo $_SESSION["name"];?></span>
          <button onclick="usermenu()" class="drop-btn"><img src="../img/<?php echo $settingBTN; ?>" style="height: 25px;"></button>
        </div>
        <div class="dropdown">
          <div id="dropdownContent" class="dropdown-content">
            <a href="./profile/view.php">Profile</a>
            <a href="./comments/index.php">Comments</a>
            <a href="./settings/index.php">Settings</a>
            <a href="./logout.php" role="button">Log Out</a>
          </div>
        </div>  
      </div>
    </div>
    <div id="navbar">
      <a class="active" href="" style="border-bottom-left-radius:8px; border-top-left-radius:8px">Home</a>
      <a href="./lectures/view.php">Lectures</a>
      <a href="./challenges/view.php">CTF Challenges</a>
      <a href="./labs/view.php">Labs</a>
    </div>
  </div>

  <div id="welcome-container" style="margin: 200px auto 80px auto; width:80%">
      <img style="float:left; height:225px" src="../img/<?php echo $home; ?>">
      <div>
        <h1 style="margin-top: 20px; margin-bottom: 8px;">Welcome to W0rm!</h1>
        <p style="margin-top:10px; margin-bottom: 20px; font-size:1.2rem;"><i>A cloud-based hacking practice environment</i></p>
        <table>
          <tr>
            <td rowspan="4" style="vertical-align: top; text-align: left; padding: 0px">
              <h4 style="margin-top: 0px;">Including: </h4>
            </td>
          <tr>
            <td>
              <li style="font-size: 1.2rem;"><b>Lectures</b> on Information Security. </li>
            </td>
          <tr>
              <td>
              <li style="font-size: 1.2rem;">Interesting <b>CTF Challenges</b>. </li>
              </td>
          <tr>
              <td>
              <li style="font-size: 1.2rem;">Exquisite <b>Labs</b> for attacking pratices.</li>
              </td>
          </tr>
        </table>
      </div>
    </div>


  <section class="feature-box">
      <h2>Main Feature</h2>
      <div class="box-container">
            <div class="box">
               <img src="../img/gif/graduate.gif">
               <h3>Learning</h3>
               <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.</p>
            </div>
            <div class="box">
               <img src="../img/gif/online-learning.gif">
               <h3>Practicing</h3>
               <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.</p>
            </div>
            <div class="box">
               <img src="../img/gif/podium.gif">
               <h3>Competing</h3>
               <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.</p>
            </div>
            <div class="box">
               <img src="../img/gif/presentation.gif">
               <h3>Developing</h3>
               <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quod.</p>
            </div>
      </div>
      </section>
      <section class="about">
            <div class="member">
                <h2> Our Members </h2>
                <div class="member-container">

                    <div class="member-box">
                        <div class="member-img">
                            <a href="https://scholar.google.com.tw/citations?user=0V1HxNUAAAAJ&hl=en">
                                <img src="../img/member-img/thai_tuan.jpg" alt="cict TMTuan">
                            </a>
                        </div>
                        <div class="member-intro">
                            <span>Dr. Thai Minh Tuan</span>
                            <h3>Project Instructor</h3>
                        </div>
                    </div>


                    <div class="member-box">
                        <div class="member-img">
                            <img src="../img/member-img/LS.png" alt="member-img">
                        </div>
                        <div class="member-intro">
                            <span>Truong Dang Truc Lam</span>
                            <h3>Leader of The Project</h3>
                        </div>
                    </div>

                    <div class="member-box">
                        <div class="member-img">
                            <img src="../img/member-img/XT.JPG" alt="member-img">
                        </div>
                        <div class="member-intro">
                            <span>Le Xuan Thanh</span>
                            <h3>Member of The Project</h3>
                        </div>
                    </div>

                    <div class="member-box">
                        <div class="member-img">
                            <img src="../img/member-img/BTT.jpg" alt="member-img">
                        </div>
                        <div class="member-intro">
                            <span>Dang Hoang Hung</span>
                            <h3>Member of The Project</h3>
                        </div>
                    </div>

                    <div class="member-box">
                        <div class="member-img">
                            <img src="../img/member-img/DB.JPG" alt="member-img">
                        </div>
                        <div class="member-intro">
                            <span>Nguyen Duy Bang</span>
                            <h3>Member of The Project</h3>
                        </div>
                    </div>

                </div>
            </div>
        </section>
   <section class="info">
    <h2>Our Sponsor and Advisor</h2>
      <div class="box-container">
         <div class="box">
               <div class="minibox">
                  <a href="https://www.ctu.edu.vn/"><img src="../img/Logo_Dai_hoc_Can_Tho.svg.png" alt="ctu logo"></a>
                  <span>Can Tho University</span>
               </div>
               <div class="minibox">
                  <a href="https://cit.ctu.edu.vn/"><img src="../img/logo_CICT.png" alt="cict logo"></a> 
                  <span>College of Information and Communication Technology</span>
               </div>
         </div>
      </div>
   </section> 
  <script src="../javascript.js"></script>
  <?php include '../footer.php';?>
</body>

</html>
