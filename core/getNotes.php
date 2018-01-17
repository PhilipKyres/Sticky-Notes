<?php //php code to get all of the logged in users notes, called from ajax\
  session_start();
  session_regenerate_id(true);
  if(isset($_SESSION['user_id'])) {
  	require_once('DAO.php');
  	$dao = new DAO();
  	$id = $_SESSION['user_id'];
  	echo $dao->getAllNotes($id);
  }
?>