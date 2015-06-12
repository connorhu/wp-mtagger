<?php

//$s = 'http://www.photos-dauphine.com/wp-content/uploads/2010/07/champ-chatelard-425x282.jpg';
/*
	$image_type = exif_imagetype($s);
			
	switch($image_type) {
		case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($s); break;
		case IMAGETYPE_GIF: $src = imagecreatefromgif($s); break;
		case IMAGETYPE_PNG: $src = imagecreatefrompng($s); break;
		default: 
			echo "Exif problem : exif_imagetype('$s') returned '" . (!$image_type ? 'FALSE' : $image_type) . "' <br/>";
			echo "<pre>";print_r(gd_info());echo "</pre>";
			echo "Aborting<br/>";
			exit();
	}
	
	header("Content-type: {$image_type}");
		
	list($width, $height) = getimagesize($s);
	$thumb = imagecreatetruecolor($w, $h);
	imagecopyresampled($thumb, $src, 0, 0, 0, 0, $w, $h, $width, $height);
	imagejpeg($thumb);
	imagedestroy($thumb);
	imagedestroy($src);
*/

	$s = '';
	$w = 0;
	$h = 0;
	if (isset($_GET['s'])) {
		$s = filter_var(trim($_GET['s']), FILTER_VALIDATE_URL);
		if ( ! $s ) { // haven't got a valid URL file so give up now..
			echo 'FATAL EXCEPTION: Not a valid file';
			die();
		}
	}
	if (isset($_GET['w'])) {
		$w = filter_var(trim($_GET['w']), FILTER_VALIDATE_INT);
	}
	if (isset($_GET['h'])) {
		$h = filter_var(trim($_GET['h']), FILTER_VALIDATE_INT);
	}

	// if we don't have BOTH dimensions
	// default to actual image (direct, no need to start creating images, huh?)
	// otherwise we could end up with mis-shaped image
	if ( ! ( $w && $w > 0 )
			|| ! ($h && $h > 0 ) ) {
		header('Location: ' . $s);
		die();
	}

	$image_type = exif_imagetype($s);

	switch($image_type) {
		case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($s); break;
		case IMAGETYPE_GIF: $src = imagecreatefromgif($s); break;
		case IMAGETYPE_PNG: $src = imagecreatefrompng($s); break;
		default:
			echo "Exif problem : exif_imagetype('$s') returned '" . (!$image_type ? 'FALSE' : $image_type) . "' <br/>";
			echo "<pre>";print_r(gd_info());echo "</pre>";
			echo "Aborting<br/>";
			exit();
	}

	header("Content-type: {$image_type}");

	list($width, $height) = getimagesize($s);

	$thumb = imagecreatetruecolor($w, $h);
	imagecopyresampled($thumb, $src, 0, 0, 0, 0, $w, $h, $width, $height);
	imagejpeg($thumb);
	imagedestroy($thumb);
	imagedestroy($src);

?>