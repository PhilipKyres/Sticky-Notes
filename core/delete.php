<?php //php code to delete a note, called from ajax
	require_once('Util.php');

	if(!(IsNullOrEmptyString($_POST['id']))) {
  	require_once('DAO.php');
  	$dao = new DAO();
  	$id = htmlentities($_POST['id']);
  	$id = $dao->deleteNote($id);
  }
  echo 0;
?>