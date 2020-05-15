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
	<label>Upload Video (MP4 Only)</label><br>
	<input type="file" id="userfile" name="userfile" required /><br><br>
	<label>Video Title (Required)</label><br>
	<input type="text" id="filename" name="filename" required />
	<br><br>
	<input type="submit" id="submit" name="submit" value="Upload Video"/>
</form>
<?php echo $this->session->flashdata("error"); ?>

<!--<div id="video-container">-->
<!--	<p>'--><?php //echo $data->video_name;?><!--'</p>-->
<!--	<video width="320" height="180" controls>-->
<!--		<source src='--><?php //echo $filepath;?><!--' type="video/mp4"/>-->
<!--	</video>-->
<!--</div>-->
