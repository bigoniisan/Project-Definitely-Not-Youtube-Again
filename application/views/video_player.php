<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Video Player</h1>

<?php if (isset($video_data))?>
<video id="video" class="video-js vjs-default-skin" width="1280" height="720" controls>
	<source src="<?php echo $video_data['filepath'];?>">
</video>
<h2><?php echo $video_data['video_name'];?></h2>

<?php echo 'Likes/dislikes: ' . $video_data['video_likes'] . '/' . $video_data['video_dislikes'];?>

<?php echo form_open('main/like_video/' . $video_data['video_id']);?>
<form>
	<input type="submit" name="like-video" value="Like"/>
</form>

<?php echo form_open('main/dislike_video/' . $video_data['video_id']);?>
<form>
	<input type="submit" name="dislike-video" value="Dislike"/>
</form>

<h1>Comments</h1>
<?php echo form_open('main/submit_comment/' . $video_data['video_id']);?>
<form>
	<input type="text" name="comment" placeholder="Add a comment" required/>
	<input type="submit" name="submit" value="Comment"/>
</form>

<?php if (isset($comments))
foreach($comments as $comment): ?>
<td>
	<p><?php echo $comment['name'] . ' ' . $comment['date'];?></p>
	<p><?php echo $comment['comment'];?></p>
</td>

<?php endforeach;?>

<?php if (!isset($video_data)) {
	echo "Error: No video with that ID found.";
}?>

