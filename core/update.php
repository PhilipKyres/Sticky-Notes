<?php //php code to update a note's coordinates, called from ajax
	require_once('Util.php');

	if(!(IsNullOrEmptyString($_POST['id']))) {
	  require_once('Note.php');
  	require_once('DAO.php');
  	$dao = new DAO();
  	$id = htmlentities($_POST['id']);
  	$x = htmlentities($_POST['x']);
  	$y = htmlentities($_POST['y']);
  	$note = new Note($id, null, $x, $y);
  	$dao->updateNote($note);
  }
  echo 0;
?>