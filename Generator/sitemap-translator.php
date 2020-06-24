<?php 

if($_FILES){
	//print_r($_FILES);

	$xml=simplexml_load_file($_FILES['uploadfile']['tmp_name']);
	// echo "<pre>";
	// print_r($xml);
	// echo "</pre>";

	// foreach($xml->url as $url){
	// 	echo urldecode($url->loc) . "<br>";
	// }

	function tidyURL($url){
		$url = urldecode($url);
		$url = strtolower($url);
		$url = str_replace("https://www.thermofisher.com.au/show.aspx?page=/contentaus", "", $url);
		$url = str_replace("https://www.thermofisher.com.au/contentaus", "", $url);

		return $url;
	}

	function isPDF($url){
		if(substr($url,-3) == "pdf"){
			return true;
		}
		else{
			return false;
		}
	}

}



//include("includes/db.php");
//include("includes/db.php");
include("includes/header.php"); 


?>



<h1>Sitemap Translator</h1>


<div class="row">
	<div class="col-md-6">
		<form action="sitemap-translator.php?action=upload" method="post" enctype="multipart/form-data">
			<input type="file" name="uploadfile" class="form-control">
			<input type="submit" value="Upload" name="uploadxml" class="btn btn-primary">
		</form>
	</div>
</div>

<?php 
	if($_FILES){ ?>
	<br>
	<br>

	<table class="table addTableFilters">
		<thead>
			<tr>
				<th>URL</th>
			</tr>
		</thead>
		<tbody>
	<?php
		$i = 0;
		foreach($xml->url as $url){

			$u = tidyURL($url->loc);

			if(isPDF($url) === false){
				$trClass = "";
				if(strpos($u, "environmental-industrial/")){
					$trClass = "danger";
				}

				echo "<tr class=" . $trClass . ">";
				echo "<td>" . $u . "</td>";
				echo "</tr>";
				$i++;
			}

			
		}
	?>		
		</tbody>
	</table>
	<span>There were <?php echo $i; ?> URLs (excluding PDFs)</span>

<?php	
	}?>


<?php

include("includes/footer.php"); ?>