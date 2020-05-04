<?php

$sql = "SELECT * FROM `webpromopodsf` ORDER BY `order`";
$r = $conn->query($sql);



$target = "";

if(!isset($_GET['site'])){
	$site = "";
}
 ?>
<style>
	.promo-filter-container {
		width: 100%;
		text-align: center;
		margin-bottom: 30px;
	}
	.promo-filter-container .btn {
		margin-bottom: 10px;
	}
	.promo-filter-container .btn-primary.active {
		color: #616265;
	}
	.wrapper {
		width: 100%;
		display: grid;
		margin: 0 auto;
		/*grid-template-columns: repeat(3,1fr);*/
		grid-template-columns: repeat(auto-fit, minmax(315px,1fr));
		grid-gap: 15px;

	}
	.promo {
		background: #FFF;
		border:1px solid #C9C8C8; 
		padding: 8px;
		display: grid;
		/*grid-template-columns: repeat(3, 1fr);*/
		grid-template-columns: 105px auto auto;
		grid-template-rows: 105px 150px auto;
		grid-gap: 8px;
		align-items: justify;

	}
	.promo-offer {
		background-color: #ee2d35;
		font-size: 20px;
		color: #FFF;
		text-transform: uppercase;
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;


	}
	.promo-detail {
		grid-column: 2 / 4;
		display: flex;
		align-items: center;
	}
	.promo-detail a {
		font-size: 18px;
		line-height: 21px;
	}
	.promo-image {
		grid-column: 1 / 4;
	}
	.promo-action{
		grid-column: 1 / 4;
	}

	
</style>
<div class="full-width">
			<table width="980" border="0" cellpadding="0" cellspacing="0">
			    <tbody>
			        <tr>
			            <td>&nbsp;</td>
			        </tr>
			    </tbody>
			</table>
			<table border="0" cellspacing="0" cellpadding="0" width="980">
			    <tbody>
			        <tr>
			            <td style="font-family: Arial, Helvetica, sans-serif; Line-height: 39.8px; font-size: 29px; color: #333;">
			            	<h1><?php if(isset($_GET['title'])){ echo $_GET['title']; } ?></h1>
			            </td>
			        </tr>
			    </tbody>
			</table>
			<table width="980" border="0" cellpadding="0" cellspacing="0">
			    <tbody>
			        <tr>
			            <td>&nbsp;</td>
			        </tr>
			    </tbody>
			</table>


	<!-- OPTIONAL PROMO HEADER 

			<table border="0" cellspacing="0" cellpadding="0" width="980">
			    <tbody>
			        <tr>
			            <td valign="top" bgcolor="#ececec" style="padding:15px;">
			            <h3 style="margin-bottom:10px;"><b>Optional title</b></h3>
			            <p>Some text can go here</p>
			            <p style="margin-top:25px;"><a href="#" class="btn btn-primary">A button can go here</a></p>
			            </td>
			            <td width="640">
			            	<a href="#" target="_blank"><img src="/Uploads/image/landing-page-banner-image.jpg" style="border: 1px solid grey; width: 640px; height: 300px;"></a>
			            </td>
			        </tr>
			    </tbody>
			</table>

			<table width="980" border="0" cellpadding="0" cellspacing="0">
			    <tbody>
			        <tr>
			            <td>&nbsp;</td>
			        </tr>
			    </tbody>
			</table>
	
	-->

<?php

// Filter Buttons


if(isset($_GET['filters']) && !empty($_GET['filters'])){
	echo "<div class=\"promo-filter-container\" id=\"myBtnContainer\">\n";
	echo "\t<button type=\"button\" class=\"btn btn-primary active\" data-filter=\"all\" onClick=\"_gaq.push(['_trackEvent', 'Promo Filter', 'Click', 'All']);\">All Promotions</button>&nbsp&nbsp;\n";
	foreach(explode("\n",$_GET['filters']) as $f){
		echo "\t<button type=\"button\" class=\"btn btn-primary\" data-filter=\"" . str_replace(" ", "", trim($f)) . "\" onClick=\"_gaq.push(['_trackEvent', 'Promo Filter', 'Click', '" . trim($f) . "']);\">" . trim($f) . "</button>&nbsp&nbsp;\n";
	}
	echo "</div>\n\n";
}

$i = 1;
echo "<div class=\"wrapper\">\n";
while($row = $r->fetch_assoc()){
	$target = "";
	if(substr($row['url'],-4) == ".pdf"){
		$target = "target='_blank'";
	}
	echo "\t<div class=\"promo filterDiv " . $row['filters'] . "\">\n";
	echo "\t\t<div class=\"promo-offer\">\n";
	echo "\t\t\t" . $row['offer'] . "\n";
	echo "\t\t</div>";
	echo "\t\t<div class=\"promo-detail\">\n";
	echo "\t\t\t<h3><a onClick=\"_gaq.push(['_trackEvent', 'Promotions', '" . $row['promo_name'] . "', '" . $row['item_name'] . "']);\" href=\"" . $site . $row['url'] ."\" " . $target . ">" . $row['offer_detail'] . "</a></h3>\n";
	echo "\t\t</div>\n";
	echo "\t\t<div class=\"promo-image\">\n";
	echo "\t\t\t<img src=\"" . $site . $row['image'] . "\" width=\"294\" height=\"150\">\n";
	echo "\t\t</div>\n";
	echo "\t\t<div class=\"promo-action\">\n";
	echo "\t\t\t" . $row['tagline'] . "<br>\n";
	echo "\t\t\t<a href=\"" . $site . $row['url'] . "\" " . $target . " onClick=\"_gaq.push(['_trackEvent', 'Promotions', '" . $row['promo_name'] . "', '" . $row['item_name'] . "']);\">" . $row['call_to_action'] . "</a>\n";
	echo "\t\t</div>\n";
	echo "\t</div>\n";

}




echo "</div>\n";


?>

</div>
<script src="https://www.thermofisher.com.au/scripts/jquery-1.8.3.min.js" type="text/javascript"></script>
<script>
document.addEventListener("DOMContentLoaded", hideSide);
function hideSide(){
    $("#side").hide();
}    

/* ========================================================================
 * Sandie's JS Components: filter-buttons.js v1.0.0
 * http://www.sandie.io
 * Modified from W3schools: 
 * https://www.w3schools.com/howto/howto_js_filter_elements.asp
 * ======================================================================== */

filterSelection("all");

$('.promo-filter-container button').click(function(){
    filterSelection($(this).data('filter'));
});

function filterSelection(c){  
  $(".filterDiv").each(function(){
    $(this).hide();

    if(c == "all"){
      $(this).show();
    }
    else{
      if($(this).hasClass(c)){       
        $(this).show();        
      }
    }
  });
}

//Add active class to the current control button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
if(btnContainer){
  var btns = btnContainer.getElementsByClassName("btn");
  for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
      var current = document.getElementsByClassName("active");
      current[0].className = current[0].className.replace(" active", "");
      this.className += " active";
    });
  }
}
</script>