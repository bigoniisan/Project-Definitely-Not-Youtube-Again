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
<?php $k=0 ?>
<?php if (isset($video_list))
foreach($video_list as $video): ?>
	<td>
		<video id="video" class="video-js vjs-default-skin" width="320" height="180" controls>
			<source src="<?php echo $video['filepath'];?>">
		</video>
<!--		<p>--><?php //echo $video['video_name']?><!--</p>-->
	</td>
	<br/>
	<?php $k++;
	if($k%3==0)
		echo "<tr>";
	?>
<?php endforeach; ?>
