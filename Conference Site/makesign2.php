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
						"name_font_size" => "25",
						"name_box_width" => "340",
						"desc_font_size" => "25",
						"desc_box_width" => "340",
						"page_w" => mmToPx(102),
						"page_h" => mmToPx(148),
						"brand_bar_h" => mmToPx(33),
						"name_bar_h" => mmToPx(23),
						"qr_size" => 130,
						"short_url_font_size" => "25",
						"xIndent" => $buffer + 25,
				),
			"Card" => array(
						"max_logo_height" => mmToPx(12),
						"name_font_size" => "18",
						"name_box_width" => "300",
						"desc_font_size" => "15",
						"desc_box_width" => "240",
						"page_w" => mmToPx(90),
						"page_h" => mmToPx(60),
						"brand_bar_h" => mmToPx(16),
						"name_bar_h" => mmToPx(12),
						"qr_size" => 70,
						"short_url_font_size" => "18",						
						"xIndent" => $buffer + 15,
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





// // Settings

// $name_font_size = $layout[$size]['name_font_size'];
// $desc_font_size = $layout[$size]['desc_font_size'];

// $brandRGBColour = hexToRgb($brand['bg_colour']);
// $brand_colour = imagecolorallocate($my_img, $brandRGBColour[0], $brandRGBColour[1] , $brandRGBColour[2]);
// $lightGrey = imagecolorallocate($my_img, 220, 220, 220);
// $darkGrey = imagecolorallocate($my_img, 85, 87, 89);
// $font = "../__resources/fonts/HelveticaNeueLTStd-Lt.otf";

// // TOP BRAND BOX
// imagefilledrectangle($my_img, $buffer, $buffer, ($imgW - $buffer), $buffer + $layout[$size]['brandBarH'], $brand_colour);


// // PRODUCT BOX

// // if chars > max chars 2 lines
// imagefilledrectangle($my_img, $buffer, ($buffer + $layout[$size]['brandBarH']), ($imgW - $buffer), ($buffer + ($layout[$size]['brandBarH'] + $layout[$size]['nameBarH'])), $lightGrey);


 



// // LOGO	
// $logo = imagecreatefrompng($brand['logoImg']); // NEED TO DO A FILE TYPE CHECK HERE
// list($lW,$lH) = getimagesize($brand['logoImg']);
// //$rLogo = imagecreatefromjpeg($brand['logoImg']);
// 	// resize to maxheight
// 	// $new = resizeImg($layout[$size]['max_logo_height'], $brand['logoImg']);
// 	// imagecopyresampled($my_img, $logo, 0, 0, 0, 0, $new['width'], $new['height'], $cW, $cH);

// 	// find Y posn
// 	$lY = ($layout[$size]['brandBarH'] / 2)  -  ($lH / 2) + $buffer;
// imagecopy($my_img, $logo, $layout[$size]['xIndent'], $lY, 0, 0, $lW, $lH);	


// // QR Code
// $qr = imagecreatefrompng("https://chart.googleapis.com/chart?cht=qr&chs=" . $layout[$size]['qr_size'] . "&chl=" . urlencode($product['url']) . "&choe=UTF-8&chld=L|2");
// $qrX = imagesx($qr);
// $qrY = imagesY($qr);
// imagefilter($qr, IMG_FILTER_COLORIZE, 85,87,89);

// if($product['size'] == "A6"){
// 	imagecopy($my_img, $qr, 300, 470, 0, 0, $qrX, $qrY);	
// }
// elseif($product['size'] == "Card"){
// 	imagecopy($my_img, $qr, 300, 190, 0, 0, $qrX, $qrY);
// }



//imageline($my_img, $imgW-mmToPx($buffer),0,$imgW-mmToPx($buffer),mmToPx($buffer));


//header( "Content-type: image/png" );

$bg_name = "images/signs_base/" . $product['name'] . ".png";
imagepng( $my_img, $bg_name );
imagedestroy( $my_img );
//imagepng( $my_img );

list($w,$h) = getimagesize($bg_name);

list($lw,$lh) = getimagesize("images/" . $logoImg);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $product['name']; ?></title>
	<link rel="stylesheet" href="">
	<style>
		@font-face {
		    font-family: 'HelveticaNeue';
		    src: url('../__resources/fonts/HelveticaNeueLTStd-Lt.otf');
		}
		html,body{
			color: rgb(85, 87, 89);
		}
		.base{
			width: <?php echo $w; ?>px; 
			height: <?php echo $h; ?>px; 
			background: url('<?php echo $bg_name; ?>'); 
			z-index: 0; 
			position: absolute; 
			top: 0px; 
			left: 0px;
		}
		.brandBar{
			width: <?php echo ($w - (2*$buffer)); ?>px;
			height: <?php echo $layout[$size]['brand_bar_h']; ?>px;
			z-index: 1;
			position: absolute;
			top: <?php echo $buffer; ?>px;
			left: <?php echo $buffer; ?>px;
			background-color: #<?php echo $brand['bg_colour']; ?>;
		}
		.logo{
			z-index: 10;
			position: absolute;
			top: <?php echo ($buffer + (($layout[$size]['brand_bar_h'] / 2) - ($lh / 2))); ?>px;
			left: <?php echo $layout[$size]['xIndent']; ?>px;
		}
		.nameBar{
			width: <?php echo ($w - (2*$buffer)); ?>px;
			height: <?php echo $layout[$size]['name_bar_h']; ?>px;
			z-index: 1;
			position: absolute;
			top: <?php echo ($buffer + $layout[$size]['brand_bar_h']); ?>px;
			left: <?php echo $buffer; ?>px;
			background-color: #dcdcdc;
		}
		.nameBarText{
			width: <?php echo $layout[$size]['name_box_width']; ?>px; 
			z-index: 2; 
			position: absolute; 
			top: <?php echo ($buffer + $layout[$size]['brand_bar_h'] + ($layout[$size]['name_font_size'] /2) ); ?>px; 
			left: <?php echo $layout[$size]['xIndent']; ?>px; 
			font-family: 'HelveticaNeue';
			font-size: <?php echo $layout[$size]['name_font_size']; ?>px;
			font-weight: 500;
			color:  ;
		}
		.descBox{
			width: <?php echo $layout[$size]['desc_box_width']; ?>px; 
			z-index: 2; 
			position: absolute; 
			top: <?php echo ($buffer + $layout[$size]['brand_bar_h'] + $layout[$size]['name_bar_h'] + ($layout[$size]['name_font_size'] /2) ); ?>px; 
			left: <?php echo $layout[$size]['xIndent']; ?>px; 
			font-family: 'HelveticaNeue';
			font-size: <?php echo $layout[$size]['desc_font_size']; ?>px;
			font-weight: 500;
			word-wrap: normal;
		}
		.shortURL{
			z-index: 3; 
			position: absolute; 
			top: <?php echo ($h - $buffer - $layout[$size]['short_url_font_size'] * 2); ?>px; 
			left: <?php echo $layout[$size]['xIndent']; ?>px; 
			font-family: 'HelveticaNeue';
			font-size: <?php echo $layout[$size]['short_url_font_size']; ?>px;
			color: #000000;
		}
		.qr{
			z-index: 4; 
			position: absolute; 
			top: <?php echo ($h - $layout[$size]['qr_size'] - ($buffer)); ?>px; 
			left: <?php echo ($w - $layout[$size]['qr_size'] - ($buffer * 1.2) ); ?>px; 
		}

	</style>
</head>
<body onload="window.print();">
	
<div class="base">

</div>	
<div class="brandBar"></div>
<img class="logo" src="images/<?php echo $logoImg; ?>">
<div class="nameBar"></div>
<div class="nameBarText">
	<?php echo $product['name']; ?>
</div>
<div class="descBox">
	<?php echo $product['description']; ?>
</div>
<div class="shortURL">
	<?php 
		$u = explode("/", $product['bitly']);
		echo $u[0] . "/";
		echo "<span style='font-weight: 900;'>" . $u[1] . "</span>"; 

	?>
</div>
<img class="qr" src="https://chart.googleapis.com/chart?cht=qr&chs=<?php echo $layout[$size]['qr_size']; ?>&chl=<?php echo urlencode($product['url']); ?>&choe=UTF-8&chld=L|2" alt="">
<script src="jquery-2.1.4.min.js"></script>

</body>
</html>


<?php
/**Name Bar**/
// $txt = wordwrap($product['name'], $layout[$size]['name_chars_per_line'], "\n");
// $txtA = explode("\n", $txt);
// // get Y posn
// if(count($txtA) > 1){
// 	$pY = $buffer + $layout[$size]['brandBarH'] + ($layout[$size]['name_font_size'] * 1.75);
// }
// else{
// 	$pY = $buffer + $layout[$size]['brandBarH'] + (($layout[$size]['nameBarH'] / 2) + ($layout[$size]['name_font_size'] / 2));
// }
// foreach($txtA as $t){
// 	imagefttext($my_img, $layout[$size]['name_font_size'], 0, $layout[$size]['xIndent'], $pY, $darkGrey, $font, $t);
// 	$pY = $pY + ($layout[$size]['name_font_size'] * 1.5);	
// }
// 
// // SHORT DESCRIPTION
// $txt = wordwrap($product['description'], $layout[$size]['desc_chars_per_line'], "\n");
// $txtA = explode("\n", $txt);
// 	// get Y posn
// 	$dY = $buffer + $layout[$size]['brandBarH'] + $layout[$size]['nameBarH'] + ($layout[$size]['desc_font_size'] * 2);
// foreach($txtA as $t){
// 	imagefttext($my_img, $layout[$size]['desc_font_size'], 0, $layout[$size]['xIndent'], $dY , $darkGrey, $font, $t);
// 	$dY = $dY + ($layout[$size]['desc_font_size'] * 1.5);	
// }


// // BITLY LINK
// if($product['size'] == "A6"){
// 	imagefttext($my_img, 17, 0, $layout[$size]['xIndent'], 570 , $darkGrey, $font, $product['bitly']);
// }
// elseif($product['size'] == "Card"){
// 	imagefttext($my_img, 13, 0, $layout[$size]['xIndent'], 250 , $darkGrey, $font, $product['bitly']);
// }
// 
// 
// 
// 

//



?>

