<?php
	$link = mysqli_connect('localhost', 'root', '','jozveyab') or die('error');
	
	if($_REQUEST['postId'])
	{
		$userip = $_SERVER['REMOTE_ADDR'];
		$post_id = $_REQUEST['postId'];
		mysqli_query($link, "update likes set likes=likes-1 where post_id='$post_id' ");
		
		mysqli_query($link, "delete from likers_ip where userip='$userip' AND post_id='$post_id'");
		
		$total_likes = mysqli_query($link, "SELECT * FROM likes where post_id ='$post_id'");
		$likes = mysqli_fetch_array($total_likes);
		$likes = $likes['likes'];
	}
	$link = null;
	echo $likes;
?>
