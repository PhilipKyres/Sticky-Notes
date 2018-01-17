<?php //php for the index page. Mostly used for form submission and validation
  session_set_cookie_params(0,"/","",false, true);
  session_start();
  session_regenerate_id(true);

  //if logged in, redirect to dash
  if(isset($_SESSION['user_id'])) {
    header('Location: dash.php');
    die();
  }

  $error = '';
  $usernameL = '';
  $passwordL = '';
  $usernameS = '';
  $passwordS = '';

  //Try catch for sql exceptions so the website runs if the database can't be connected to
  try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      require_once('core/Util.php');
      require_once('core/User.php');
      require_once('core/DAO.php');
      $dao = new DAO();

      if(isset($_POST['usernameL'])) { //login
        $usernameL = htmlentities($_POST['usernameL']);
        $passwordL = htmlentities($_POST['passwordL']);
        if(IsNullOrEmptyString($usernameL) || IsNullOrEmptyString($passwordL)) {
          $error = 'A field is empty';
        }
        else {
          $val = $dao->isValidUser($usernameL, $passwordL);
          if(!($val instanceof User)) {
            if($val != 0) {
              $error = "Invalid username or password, $val login attempts remaining";
            }
            else {
              $error = "Account has been locked, contact system admin";
            }
          }
          else { //Login and redirect to main page
            $_SESSION['user_id'] = $val->getUserId();
            header('Location: dash.php');
            die();
          }
          
        }
      }
      else { //signup
        $usernameS = htmlentities($_POST['usernameS']);
        $passwordS = htmlentities($_POST['passwordS']);
        if(IsNullOrEmptyString($usernameS) || IsNullOrEmptyString($passwordS)) {
          $error = 'A field is empty';
        }
        else if(strlen($usernameS) > 16 || strlen($passwordS) > 64) {
          $error = 'Username or password is too long';
        }
        else if(!$dao->isUsernameFree($usernameS)) {
          $error = 'Username is taken';
        }
        else {
          $_SESSION['user_id'] = $dao->insertUser($usernameS, $passwordS);
          header('Location: dash.php');
          die();
        }
      }
    } 
  } catch (PDOException $e) { 
    $error = 'Failed to connect to server';
	
	//If exception, keep form content
	if(isset($_POST['usernameL'])) { 
		$usernameL = htmlentities($_POST['usernameL']);
	}
  }

  if($error != '')
    $error = '<span class="error">ERROR: '.strtoupper($error).'</span>';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Sign-Up/Login Form</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/index.css">
  </head>
  <body>
    <div class="form">   
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      <?php echo $error; ?>
      <div class="tab-content">
        <div id="signup">   
          <h1>Sign Up</h1>
          
          <form action='' method='post'>

          <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input name="usernameS" value="<?php echo $usernameS; ?>" type="text" maxlength="16" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input name="passwordS" type="password" maxlength="64" required autocomplete="off"/>
          </div>
          
          <button type="submit" class="button button-block"/>Create Account</button>          
          </form>
        </div>
        
        <div id="login">   
          <h1>Welcome Back!</h1>
          
          <form action="" method="post">
          
            <div class="field-wrap">
            <label>
              Username<span class="req">*</span>
            </label>
            <input name="usernameL" value="<?php echo $usernameL; ?>" type="text" maxlength="16" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input name="passwordL" type="password" maxlength="64" required autocomplete="off"/>
          </div>
          <button class="button button-block"/>Log In</button>
          </form>
        </div>
      </div><!-- tab-content -->
    </div> <!-- /form -->
    <div class="footer">
        Sticky Notes © Philip Kyres, 2015
    </div>
  </body>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index.js"></script>
</html>
