<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Homepage</h1>

<?php
if (isset($_SESSION['name'])) {
	echo '<h2>Welcome '.$_SESSION['name'].'</h2>';
}
;?>

<!--this variable to display 3 videos per row-->
<?php //$k=0 ?>
<?php if (isset($video_list))
foreach($video_list as $video): ?>
	<td>
		<a href="video_player/<?php echo $video['video_id'];?>"><?php echo $video['video_name'];?></a>
		<br>
		<video id="video" class="video-js vjs-default-skin" width="320" height="180" controls>
			<source src="<?php echo $video['filepath'];?>">
		</video>
		<br>
	</td>
<br>
<br>
<!--	<br/>-->
<!--	--><?php //$k++;
//	if($k%3==0)
//		echo "<tr>";
//	?>
<?php endforeach; ?>
