<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Login Page</h1>

<?php echo form_open('main/login_submit')?>
<form>
	<label>Email</label>
	<input type="email" id="email" name="email" required/>
	<br/>
	<label>Password</label>
	<input type="password" id="password" name="password" required/>
	<br/>
	<input type="checkbox" id="remember-me" name="remember-me"/>
	<label>Remember Me?</label>

	<br/>
	<a href="reset_password">Forgot Password?</a>

	<input type="submit" id="submit" name="submit" value="Log In"/>

</form>
<?php echo $this->session->flashdata("error"); ?>
