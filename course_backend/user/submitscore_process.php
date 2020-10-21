<?php
	SESSION_START();
   
	include("../database.php");
	$db = new Database();
	
	$nik = (isset($_SESSION['nik'])) ? $_SESSION['nik'] : "";
	$token = (isset($_SESSION['token'])) ? $_SESSION['token'] : "";

	$game_id = $_POST['gameid'];
	$game_score = $_POST['score'];
	
	if($token && $nik)
	{	
		$playerStatus = $db->execute("SELECT status FROM user_tbl WHERE nik = '".$nik."' ");
		
        $db->execute("INSERT INTO user_game_data_tbl(nik, game_id, score, status)
								VALUES('".$nik."', ".$game_id.", ".$game_score.", ".$playerStatus.")");
   }

   header("Location: http://localhost/course_backend/");   
?>