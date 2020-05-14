<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<nav>
	<a href="homepage">
		Homepage
	</a>

	<?php echo form_open('main/item_search')?>
	<form>
		<input type="search" id="search" name="search" placeholder="Search">
		<input type="submit" id="submit" name="submit" value="Search"/>
	</form>

	<a href="upload">
		Upload
	</a>
	<a href="my_account">
		My Account
	</a>
	<a href="logout">
		Logout
	</a>
</nav>
