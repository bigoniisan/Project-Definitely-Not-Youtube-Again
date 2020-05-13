<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<head>
	<script type="text/javascript" src="../../resources/dropzone.js"></script>
	<link rel="stylesheet" href="../../resources/dropzone.js">
</head>

<h1>Upload Video</h1>

<?php echo form_open_multipart('main/upload_video'); ?>
<form class="dropzone" id="fileupload">
	<label>Upload Video</label>
	<input type="file" id="userfile" name="userfile"/>
	<input type="submit" id="submit" name="submit" value="Upload MP4"/>
</form>
<?php echo $this->session->flashdata("error"); ?>

<div id="video-container">
<!--	<p>'--><?php //echo $data->video_name;?><!--'</p>-->
	<video width="320" height="180" controls>
		<source src='<?php echo $filepath;?>' type="video/mp4"/>
	</video>
</div>
