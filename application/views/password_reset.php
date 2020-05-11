<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Change Password</h1>

<?php echo form_open('main/reset_password'); ?>
<form>
	<label>Email</label>
	<input type="email" id="email" name="email" required/>
	<input type="submit" id="submit" name="submit" value="Send reset password email"/>
</form>
