	<?php
    $post_id = $_GET['post_id'];
    $link = mysqli_connect('localhost', 'root', '','jozveyab') or die('error');
	$result = mysqli_query($link,"SELECT * FROM jozve WHERE `id`='$post_id'");

	$userip = $_SERVER['REMOTE_ADDR'];


	while ($row = mysqli_fetch_array($result))
	{
		$like_ip = mysqli_query($link,"SELECT count(*) FROM likers_ip where `post_id`='$post_id' AND `userip`='$userip'");
		$like_ip_num = mysqli_num_rows($like_ip);


		$total_likes = mysqli_query($link,"SELECT * FROM likes where `post_id`='$post_id' ");
		$likes = mysqli_fetch_array($total_likes);
		$likes = $likes['likes'];

        $is_like = mysqli_query($link,"SELECT * FROM likers_ip where `userip`='$userip' AND `post_id`='$post_id'");
        $is_like_count = mysqli_num_rows($is_like);

        if ($is_like_count == 1){
            $is_like = true;
        }
        else{
            $is_like = false;
        }

		?>
		
	   <div class="jozveyab_area">

			<span id="like-panel-<?php  echo $row['id']?>">
				
			<?php
			if($is_like){?>
				<a href="javascript: void(0)" id="post_id<?php  echo $row['id']?>" class="Unlike">Unlike</a>
			<?php }else{?>
				<a href="javascript: void(0)" id="post_id<?php  echo $row['id']?>" class="LikeThis">Like</a>
			<?php }?>

			</span>
			
		   </label>
			
			<input type="hidden" value="<?php echo $records?>" id="totals-<?php  echo $row['id'];?>" />
			

			
			<div class="commentPanel" align="left">
				<img src="static/images/like.png" style="float:left;" alt="" />
				
				<span id="like-stats-<?php  echo $row['id'];?>"> <?php echo $likes;?> </span> people like this.
				
				<span id="like-loader-<?php  echo $row['id']?>">&nbsp;</span>
			</div>


	   </div>
	<?php
	}
	$link = null;
    ?>
	