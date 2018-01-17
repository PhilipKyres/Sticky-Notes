<?php //php code to create a note, called from ajax
	session_start();
  	session_regenerate_id(true);

	require_once('Util.php');

  	if(isset($_POST['text']) && isset($_SESSION['user_id']) && strlen($_POST['text']) <= 500) {
    	require_once('Note.php');
      	require_once('DAO.php');
      	$dao = new DAO();
      	$user_id = $_SESSION['user_id'];
      	$text = htmlentities($_POST['text']);
      	$x = 100;
      	$y = 100;
      	$note = new Note(null, $text, $x, $y); //Random Id, not getting used anyway
      	$id = $dao->insertNote($note, $user_id);
      	echo $id;
  	}
?>