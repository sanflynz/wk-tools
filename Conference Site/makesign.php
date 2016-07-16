<?php

include("includes/db.php");

function mmToPx($mm,$dpi = 96){
	$px = (($mm / 10) * $dpi) / 2.54;
	return $px;
}

function hexToRgb($hex){
	$hex = trim(str_replace("#", "", $hex));
	$h = str_split($hex,2);
	$rgb = array();
	foreach ($h as $r) {
		$rgb[] = hexdec($r);
	}
	return $rgb;
}

function resizeImg($maxHeight, $img){
	list($cW, $cH) = getimagesize($img);
	if($cH > $maxHeight){
		$ratio = $maxHeight / $cH;
		$new['height'] = $cH * $ratio;
		$new['width'] = $cW * $ratio;
	}
	else{
		$new['height'] = $cH;
		$new['width'] = $cH;
	}

	return $new;

}

$buffer = mmToPx(10);

$layout = array(
			"A6" => array(
						"max_logo_height" => mmToPx(30),
						"name_font_size" => "21",
						"name_chars_per_line" => "25",
						"desc_font_size" => "21",
						"desc_chars_per_line" => "24",
						"page_w" => mmToPx(102),
						"page_h" => mmToPx(148),
						"brandBarH" => mmToPx(33),
						"nameBarH" => mmToPx(23),
						"qr_size" => 130,
						"xIndent" => $buffer + 10,
				),
			"Card" => array(
						"max_logo_height" => mmToPx(12),
						"name_font_size" => "15",
						"name_chars_per_line" => "30",
						"desc_font_size" => "13",
						"desc_chars_per_line" => "35",
						"page_w" => mmToPx(90),
						"page_h" => mmToPx(60),
						"brandBarH" => mmToPx(16),
						"nameBarH" => mmToPx(12),
						"qr_size" => 80,						
						"xIndent" => $buffer + 10,
				),
		);  



// CONTENT


// $product = array(
// 			"name" => "Multiskan&trade; GO", 
// 			"description" => "Microplate spectrophotometer with a broad wavelength range, path length correction and a fast reading speed",
// 			"url" => "http://info.thermofisher.com.au/LP=3935",
// 			"bitly" => "bit.ly/263UFZy",
// 			"size" => "A6",
// 	);

$r = $conn->query("SELECT p.brand_id,p.sign_name, p.sign_desc, p.redirect_url, p.sign_short_url, p.sign_size, b.* FROM products p LEFT JOIN brands b ON p.brand_id = b.id WHERE p.id='" . $_GET['product'] . "'");
$row = $r->fetch_assoc();

if($row['sign_size'] == "A6"){
	$logoImg = $row['logo_md'];
}
elseif($row['sign_size'] == "Card"){
	$logoImg = $row['logo_sm'];
}

$brand = array(
		"logoImg" => "images/" . $logoImg,
		"name" => $row['name'],
		"bg_colour" => $row['bg_colour'],
	);

$product = array(
			"name" => $row['sign_name'], 
			"description" => $row['sign_desc'],
			"url" => $row['redirect_url'],
			"bitly" => $row['sign_short_url'],
			"size" => $row['sign_size'],
	);

$size = $product['size'];

$imgW = ($buffer * 2) + $layout[$size]['page_w'];
$imgH = ($buffer * 2) + $layout[$size]['page_h'];

$my_img = imagecreate( $imgW, $imgH );
$background = imagecolorallocate( $my_img, 255, 255, 255 );

// SET CUT MARKS
$cut_colour = imagecolorallocate( $my_img, 0, 0, 0 );
imagesetthickness ( $my_img, 2 );

imageline($my_img, 0, $buffer, $buffer*0.6, $buffer, $cut_colour);
imageline($my_img, $buffer, 0, $buffer, $buffer*0.6, $cut_colour);

imageline($my_img, ($imgW - $buffer),0,($imgW - $buffer),$buffer*0.6,$cut_colour);
imageline($my_img, ($imgW - $buffer*0.6),$buffer,$imgW,$buffer,$cut_colour);

imageline($my_img, ($imgW - $buffer*0.6),($imgH - $buffer),$imgW,($imgH - $buffer),$cut_colour);
imageline($my_img, ($imgW - $buffer),($imgH - $buffer*0.6),($imgW - $buffer),$imgH,$cut_colour);

imageline($my_img, $buffer,($imgH - $buffer*0.6),$buffer,$imgH,$cut_colour);
imageline($my_img, 0,($imgH - $buffer),$buffer*0.6,($imgH - $buffer),$cut_colour);





// Settings

$name_font_size = $layout[$size]['name_font_size'];
$desc_font_size = $layout[$size]['desc_font_size'];

$brandRGBColour = hexToRgb($brand['bg_colour']);
$brand_colour = imagecolorallocate($my_img, $brandRGBColour[0], $brandRGBColour[1] , $brandRGBColour[2]);
$lightGrey = imagecolorallocate($my_img, 220, 220, 220);
$darkGrey = imagecolorallocate($my_img, 85, 87, 89);
$font = "../__resources/fonts/HelveticaNeueLTStd-Lt.otf";

// TOP BRAND BOX
imagefilledrectangle($my_img, $buffer, $buffer, ($imgW - $buffer), $buffer + $layout[$size]['brandBarH'], $brand_colour);


// PRODUCT BOX

// if chars > max chars 2 lines
imagefilledrectangle($my_img, $buffer, ($buffer + $layout[$size]['brandBarH']), ($imgW - $buffer), ($buffer + ($layout[$size]['brandBarH'] + $layout[$size]['nameBarH'])), $lightGrey);
$txt = wordwrap($product['name'], $layout[$size]['name_chars_per_line'], "\n");
$txtA = explode("\n", $txt);
// get Y posn
if(count($txtA) > 1){
	$pY = $buffer + $layout[$size]['brandBarH'] + ($layout[$size]['name_font_size'] * 1.75);
}
else{
	$pY = $buffer + $layout[$size]['brandBarH'] + (($layout[$size]['nameBarH'] / 2) + ($layout[$size]['name_font_size'] / 2));
}
foreach($txtA as $t){
	imagefttext($my_img, $layout[$size]['name_font_size'], 0, $layout[$size]['xIndent'], $pY, $darkGrey, $font, $t);
	$pY = $pY + ($layout[$size]['name_font_size'] * 1.5);	
}

 


// SHORT DESCRIPTION
$txt = wordwrap($product['description'], $layout[$size]['desc_chars_per_line'], "\n");
$txtA = explode("\n", $txt);
	// get Y posn
	$dY = $buffer + $layout[$size]['brandBarH'] + $layout[$size]['nameBarH'] + ($layout[$size]['desc_font_size'] * 2);
foreach($txtA as $t){
	imagefttext($my_img, $layout[$size]['desc_font_size'], 0, $layout[$size]['xIndent'], $dY , $darkGrey, $font, $t);
	$dY = $dY + ($layout[$size]['desc_font_size'] * 1.5);	
}


// BITLY LINK
if($product['size'] == "A6"){
	imagefttext($my_img, 17, 0, $layout[$size]['xIndent'], 570 , $darkGrey, $font, $product['bitly']);
}
elseif($product['size'] == "Card"){
	imagefttext($my_img, 13, 0, $layout[$size]['xIndent'], 250 , $darkGrey, $font, $product['bitly']);
}
// LOGO	
$logo = imagecreatefrompng($brand['logoImg']); // NEED TO DO A FILE TYPE CHECK HERE
list($lW,$lH) = getimagesize($brand['logoImg']);
//$rLogo = imagecreatefromjpeg($brand['logoImg']);
	// resize to maxheight
	// $new = resizeImg($layout[$size]['max_logo_height'], $brand['logoImg']);
	// imagecopyresampled($my_img, $logo, 0, 0, 0, 0, $new['width'], $new['height'], $cW, $cH);

	// find Y posn
	$lY = ($layout[$size]['brandBarH'] / 2)  -  ($lH / 2) + $buffer;
imagecopy($my_img, $logo, $layout[$size]['xIndent'], $lY, 0, 0, $lW, $lH);	


// QR Code
$qr = imagecreatefrompng("https://chart.googleapis.com/chart?cht=qr&chs=" . $layout[$size]['qr_size'] . "&chl=" . urlencode($product['url']) . "&choe=UTF-8&chld=L|2");
$qrX = imagesx($qr);
$qrY = imagesY($qr);
imagefilter($qr, IMG_FILTER_COLORIZE, 85,87,89);

if($product['size'] == "A6"){
	imagecopy($my_img, $qr, 300, 470, 0, 0, $qrX, $qrY);	
}
elseif($product['size'] == "Card"){
	imagecopy($my_img, $qr, 300, 190, 0, 0, $qrX, $qrY);
}



//imageline($my_img, $imgW-mmToPx($buffer),0,$imgW-mmToPx($buffer),mmToPx($buffer));


header( "Content-type: image/png" );
imagepng( $my_img );
imagepng( $my_img, "images/signs/" . $product['name'] . ".png" );

imagecolordeallocate( $cut_color );
imagecolordeallocate( $background );
imagedestroy( $my_img );
?>

