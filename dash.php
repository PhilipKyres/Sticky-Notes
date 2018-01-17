<?php //php for the dashboard page. Mostly used for session checking and the logout button
  session_set_cookie_params(0,"/","",false, true);
  session_start();
  session_regenerate_id(true);

  //if not logged in, redirect to index
  if(!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    die();
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  	$_SESSION = array();
  	$params = session_get_cookie_params();
  	setCookie(session_name(), '', time() -50000);
  	session_destroy();
  	header('Location: index.php');
  	die();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/dash.css">
  </head>
  <body>
    <div class="header">
    	<div id="plus">+</div> <textarea id="textarea" maxlength="500" placeholder="Max length 500 characters"></textarea>
    	<div class="center">
        <span>Sticky Notes © Philip Kyres, 2015</span>
      </div>
      <div class="logout">
        <form action="" method="post">
    		  <button id='logoutButton' name="logout" value="logout">Logout</button>
			  </form>
      </div>
    </div>
    <div id="main"></div>
  </body>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script src="js/dash.js"></script>
</html>