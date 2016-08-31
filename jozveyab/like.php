<?php

	include_once ('dbconn.php');

	$link = mysqli_connect($DB_HOST,$DB_USER,$DB_PASS,$DB_NAME) or die('error');
	
	if($_REQUEST['postId'])
	{
		$userip = $_SERVER['REMOTE_ADDR'];
		
		mysqli_query($link,"update likes set likes=likes+1 where post_id= ".$_REQUEST['postId']);
		
		mysqli_query($link,"INSERT INTO likers_ip (userip,post_id) VALUES('".$userip."','".$_REQUEST['postId']."')");
		
		$total_likes = mysqli_query($link, "SELECT * FROM likes where post_id = ".$_REQUEST['postId']." ");
		$likes = mysqli_fetch_array($total_likes);
		$likes = $likes['likes'];
	}
	$link = null;
	echo $likes;
?>
