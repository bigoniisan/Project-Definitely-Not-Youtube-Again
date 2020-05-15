<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Video Player</h1>

<?php if (isset($video_data))?>
<video id="video" class="video-js vjs-default-skin" width="1280" height="720" controls>
	<source src="<?php echo $video_data['filepath'];?>">
</video>
<h2><?php echo $video_data['video_name'];?></h2>

<?php if (!isset($video_data)) {
	echo "Error: No video with that ID found.";
}?>

