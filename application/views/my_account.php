<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>My Account</h1>

<?php echo form_open_multipart('main/image_upload');?>
<form class="dropzone" id="fileupload">
	<label>Profile Image Upload</label><br/>
	<input type="file" id="profile-image" name="profile-image"/>
	<input type="submit" id="submit" name="submit" value="Upload Profile Image"/>
</form>

<div id="profile-image" >
	<h3>Profile Image: </h3>
	<?php if (isset($profile_image_filepath)) ?>
	<img src='<?php echo $profile_image_filepath;?>' width="90" height="60"/>
</div>

<?php echo '<h2>User ID: '.$_SESSION['user_id'].'</h2>';?>

<?php echo '<h2>Email: '.$_SESSION['email'].'</h2>';?>
<?php echo form_open('main/change_email'); ?>
<form>
	<label>Change Email</label>
	<input type="email" id="change-email" name="change-email"/>
	<input type="submit" name="submit" value="Change Email"/>
</form>

<?php echo '<h2>Name: '.$_SESSION['name'].'</h2>';?>
<?php echo form_open('main/change_name'); ?>
<form>
	<label>Change Name</label>
	<input type="text" id="change-name" name="change-name"/>
	<input type="submit" name="submit" value="Change Name"/>
</form>

<?php echo '<h2>Birthday: '.$_SESSION['birthday'].'</h2>';?>
<?php echo form_open('main/change_birthday'); ?>
<form>
	<label>Change Birthday</label>
	<input type="date" id="change-birthday" name="change-birthday"/>
	<input type="submit" name="submit" value="Change Birthday"/>
</form>

<?php echo $this->session->flashdata("error"); ?>

<a href="password_reset">Change Password</a>

<?php echo form_open('main/send_email'); ?>
<form>
	<input type="email" id="send-email" name="send-email"/>
	<input type="submit" name="submit" value="Send email for some reason"/>
</form>
