<?php 
$picture = new PicturesModel();


if(isset($_GET['id']) && ((int) $_GET['id']) > 0){
	$b = $picture->getById($_GET['id']);
}else{
	exit("KO");
}


# echo json_encode($picture);
# echo json_encode($b->name);
$pictureData = @explode('data:', $b->data);
if(isset($pictureData[1])){
	$Base64Img = new stdClass();
	$Base64Img->type = "image\/none";
	$Base64Img->data = "";
	$Base64ImgTemp = @explode(';base64,', $pictureData[1]);
	
	if(isset($Base64ImgTemp[0]) && isset($Base64ImgTemp[1])){
		
		$Base64Img->type = ($Base64ImgTemp[0]);
		$Base64Img->data = ($Base64ImgTemp[1]);
		$data = $Base64Img->data;
		$data = base64_decode($data);
		$im = ImageCreateFromString($data);
		if ($im !== false) 
			{
				header('Content-Type: image/png');
				
				if(isset($_GET['w']) && $_GET['w'] == 'original')
					{
						imagepng($im);
						imagedestroy($im);
					} 
				else if(!isset($_GET['thumb']) || $_GET['thumb'] == false)
					{
						$height = true;
						$width = 150;
						if(isset($_GET['w']) && $_GET['w'] > 0){ $width = (int) $_GET['w']; }
						$height = $height === true ? (ImageSY($im) * $width / ImageSX($im)) : $height;
						$output = ImageCreateTrueColor($width, $height);
						ImageCopyResampled($output, $im, 0, 0, 0, 0, $width, $height, ImageSX($im), ImageSY($im));
						# ImageJPEG($output, "temp/images/{$picture->name}", 95);
						imagepng($output);
						imagedestroy($output);
					} 
				else
					{
						imagepng($im);
						imagedestroy($im);
					}
			}
		else
			{
				echo 'Ocurrió un error.';
			}
	}
}else{
	exit("Error");
}