<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<h1>Homepage</h1>

<?php
if (isset($_SESSION['name'])) {
	echo '<h2>Welcome '.$_SESSION['name'].'</h2>';
}
;?>
