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

$remaining = "#D6D6D6";
$remainingHover = "#DDDDDD";
$lecProgress = "#00AB9F";
$lecProgressHover = "#12BA9B";
$ctfProgress = "#008181";
$ctfProgressHover = "#109990";
$labProgress = "#054952";
$labProgressHover = "#0e6c79";
$labelColor = "#222222";

if (isset($_SESSION['darkmode']) && $_SESSION['darkmode'] == 1) {
  $style = "style-dark.css";
  $logo = "Dark-Logo.png";
  $settingBTN = "Dark-settings-icon.png";

  $remaining = "#333333";
  $remainingHover = "#444444";
  $lecProgress = "#B6D600";
  $lecProgressHover = "#C5E00A";
  $ctfProgress = "#75AB00";
  $ctfProgressHover = "#88BF06";
  $labProgress = "#30A103";
  $labProgressHover = "#34B003";
  $labelColor = "#eeeeee";
}

$stmt = $db->prepare("select * from acc where idacc = ?");
$stmt->bind_param("s", $_SESSION['idacc']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$gender= $row['gender'];
$email= $row['email'];
$avatar = base64_encode($row['avatar']);

mysqli_close($db);
?> 

<!DOCTYPE html>
<html>

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../<?php echo $style; ?>?v=<?php echo time(); ?>">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<title>Profile</title>
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
      <a href="../challenges/view.php">CTF Challenges</a>
      <a href="../labs/view.php">Labs</a>
    </div>
  </div>

  <div id="content" style="margin-top:160px">
    <div style="float: left; width: 30%; margin-left:10px">
      <br><br>
      <img id="avatar" src="data:image/png;base64,<?php echo $avatar; ?>">
      <h3 style="margin: 21px 0px 14px 14px;"><?php echo $_SESSION['name']; ?></h3>
      <h4 style="margin: 0px 0px 7px 14px; font-weight:normal"> <?php echo $_SESSION['idacc'] ?> - <?php echo $gender === 1 ? "He/Him" : "She/Her" ?></h4>
      <h5 style="margin: 0px 0px 7px 14px; font-weight:normal"> <?php echo $email?> </h5>
    </div>
    <div style="display: flex; justify-content: space-between">
      <canvas id="lecChart"></canvas>
      <canvas id="ctfChart"></canvas>
      <canvas id="labChart"></canvas>
    </div>
    <div id="achievement">
      <h4 style="margin-bottom: 10px;">Achievements:</h4>
      <div id="achievement-container">

      </div>
    </div>
  </div>
  <script src="../../javascript.js"></script>
  <script>
    const remaining = '<?php echo $remaining?>';
    const remainingHover = '<?php echo $remainingHover?>';
    const lecProgress = '<?php echo $lecProgress?>';
    const lecProgressHover = '<?php echo $lecProgressHover?>';
    const ctfProgress = '<?php echo $ctfProgress?>';
    const ctfProgressHover = '<?php echo $ctfProgressHover?>';
    const labProgress = '<?php echo $labProgress?>';
    const labProgressHover = '<?php echo $labProgressHover?>';
    const labelColor = '<?php echo $labelColor?>';


    const lecChart = document.getElementById('lecChart').getContext('2d');
    const attemptedLec = 1;
    const totalLec = 1;
    const percentageLec = (attemptedLec / totalLec) * 100;
    const chartData = {
        labels: ['Attempted', 'Remaining'],
        datasets: [{
            data: [percentageLec, 100 - percentageLec],
            backgroundColor: [lecProgress, remaining],
            hoverBackgroundColor: [lecProgressHover, remainingHover],
        }]
    };
    new Chart(lecChart, {
        type: 'doughnut',
        data: chartData,
        layout: {
          height: 50,
          width: 50,
        },
        options: {
            responsive: false,
            
            plugins: {
              title: {
                  display: true,
                  text: 'Lecs Progression (%)',
                  color: labelColor,
                  font: {
                    size: 26
                  },
                  padding: {
                      top: 10,
                      bottom: 20
                  }
              },
              legend: {
                  position: 'bottom',
                  labels: {
                      color: labelColor,
                      padding: 20
                  },
              }
            }
        }
    });

    const ctfChart = document.getElementById('ctfChart').getContext('2d');
    const attemptedCTF = 1;
    const totalCTF = 1;
    const percentageCTF = (attemptedCTF / totalCTF) * 100;
    const chartData1 = {
        labels: ['Attempted', 'Remaining'],
        datasets: [{
            data: [percentageCTF, 100 - percentageCTF],
            backgroundColor: [ctfProgress, remaining],
            hoverBackgroundColor: [ctfProgressHover, remainingHover],
        }]
    };
    new Chart(ctfChart, {
        type: 'doughnut',
        data: chartData1,
        layout: {
          height: 50,
          width: 50,
        },
        options: {
            responsive: false,
            
            plugins: {
              title: {
                  display: true,
                  text: 'CTF Progression (%)',
                  color: labelColor,
                  font: {
                    size: 26
                  },
                  padding: {
                      top: 10,
                      bottom: 20
                  }
              },
              legend: {
                  position: 'bottom',
                  labels: {
                      color: labelColor,
                      padding: 20
                  }
              }
            }
        }
    });

    const labChart = document.getElementById('labChart').getContext('2d');
    const attemptedLab = 1;
    const totalLab = 1;
    const percentageLab = (attemptedLab / totalLab) * 100;
    const chartData2 = {
        labels: ['Attempted', 'Remaining'],
        datasets: [{
            data: [percentageLab, 100 - percentageLab],
            backgroundColor: [labProgress, remaining],
            hoverBackgroundColor: [labProgressHover, remainingHover]
        }]
    };
    new Chart(labChart, {
        type: 'doughnut',
        data: chartData2,
        layout: {
          height: 50,
          width: 50
        },
        options: {
            responsive: false,
            plugins: {
              title: {
                  display: true,
                  text: 'Labs Progression (%)',
                  color: labelColor,
                  font: {
                    size: 26
                  },
                  padding: {
                      top: 10,
                      bottom: 20
                  }
              },
              legend: {
                  position: 'bottom',
                  labels: {
                      color: labelColor,
                      padding: 20
                  }
              }
            }
        }
    });

    </script>
</body>

</html>
