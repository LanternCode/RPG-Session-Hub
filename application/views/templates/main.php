<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= isset( $title ) ? $title : 'RPG Session Hub'; ?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
			integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Dancing+Script:700" rel="stylesheet">
		<link rel="stylesheet" href="<?=base_url( 'styles/main.css' )?>">
		<link rel="shortcut icon" href="<?=base_url( 'favicon.ico' )?>" type="image/x-icon">
		<link rel="icon" href="<?=base_url( 'favicon.ico' )?>" type="image/x-icon">
	</head>
	<body>
	    <main>
	        <?php isset( $body ) ? $this->load->view( $body ) : redirect( base_url( 'logout' ) ); ?>
	    </main>
		<footer style="<?=($body == 'rolllist' ? 'display: none;' : 'display: block;')?>">
		    <p class="foot">
				iLeanbox 2017-<?=date( 'Y' )?>
				<a class="homepage--admin-link" href="<?=base_url( 'admin/adminLogin' )?>">&copy;</a>
				All rights reserved.
			</p>
		</footer>
	</body>
</html>
