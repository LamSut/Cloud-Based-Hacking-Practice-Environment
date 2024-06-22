<?php 
require_once "config.php";
require_once "session.php";

$error = '';

if(isset($_POST['login'])){
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $remember_me = isset($_POST['remember-me-box']) ? 1 : 0;
  $stmt = $db->prepare("select * from acc where idacc = ?");
  $stmt->bind_param("s", $username);  
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
    if (mysqli_num_rows($result)>0){
      $password = hash("sha256", $password);
      $validpass=$row['pass'];
      if(strcmp($password, $validpass)==0) {
        $_SESSION['idacc']= $row['idacc'];
        $_SESSION['name']= $row['name'];
        $_SESSION['admin']= $row['admin'];
        $_SESSION['darkmode']= $row['darkmode'];
        if ($remember_me) 
          setcookie("idacc", $_SESSION['idacc'], time() + (86400 * 30), "/", "", true, true);
        else
          setcookie("idacc", $_SESSION['idacc'], 0, "/"); // Expires with session
        if($_SESSION['admin']){
          header("location: ../admin/index.php");
          exit;
        }
        else{
          header("location: ../user/index.php");
          exit;
        }
      }
      else{
        $error = "Not a valid password.";
      }
    }
    else{
      $error = "The username does not exist.";
    }
  mysqli_close($db);
}
?>

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
<div id="login-form-wrap">
  <h2>Welcome to W0rm!</h2>
  <?php 
    echo "<p class='error'>" . $error . "</p>"; 
  ?>
  <form id="login-form" action="" method="post">
    <p>
      <input type="text" id="username" name="username" placeholder="Username" required><i class="validation"><span></span><span></span></i>
    </p>
    <p>
      <input type="password" id="password" name="password" placeholder="Password" required><i class="validation"><span></span><span></span></i>
    </p>
    <div id="remember-me">
      <input type="checkbox" name="remember-me-box" id="remember-me-box" action="" method="post">
      <label for="remember-me-box">Remember Me for 30 Days</label>
    </div>   
    <p>
      <input type="submit" id="login" name="login" value="login">
    </p>
  </form>
</div>
</body>

</html>
