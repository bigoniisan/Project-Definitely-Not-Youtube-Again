<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Video Search</h1>

<?php //$k=0 ?>
<?php if(isset($search_result))?>
<?php foreach($search_result as $item):?>
	<td>
		<p><?php echo $item['video_name']?></p>
		<video id="video" class="video-js vjs-default-skin" width="320" height="180" controls>
			<source src="<?php echo $item['filepath'];?>">
		</video>
	</td>
<!--	<br/>-->
<!--	--><?php //$k++;
//	if($k%3==0)
//		echo "<tr>";
//	?>
<?php endforeach;?>

<?php //if(!isset($search_result)) {
//	echo "No videos found";
//}?>
