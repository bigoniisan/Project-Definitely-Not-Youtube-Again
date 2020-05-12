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

<!--1-
am not sure if you store the video names in database, for me

i did it like this :

when i upload the video, i store the video name in the database and the video file in the uploads folder

to display videos
in the controllers , select videos from database, and pass the videos to the view-->
<!---->
<!--$this->load->model('queries');-->
<!--$videos=$this->queries->viewAllVideos();-->
<!--$this->load->view('home',['videos'=>$videos]);-->
<!---->
<!--2- inside the view: ( home )-->
<!---->
<?php //$k=0?><!--  //this variable to diplsay 3 videos per row-->
<!---->
<?php //foreach ($videos as $video): ?>
<!--	<td>-->
<!--		<video id="video1" class="video-js vjs-default-skin" width="320" height="240"-->
<!--			   data-setup='{"controls" : true, "autoplay" : false, "preload" : "auto"}'>-->
<!--			<source src="http://localhost/projectname/uploads/--><?php //echo $video->filename; ?><!--" >-->
<!---->
<!--		</video>-->
<!--	</td>-->
<!---->
<!--	--><?php //$k++;
//	if($k%3==0)
//		echo"<tr>";
//
//	?>
<!---->
<?php //endforeach; ?>
