<?php
function import_page($url, $settings){

// 	print '<pre>'; 
// 	print_r($settings);
// 	print '</pre>';

	include_once('../__vendor/simple_html_dom.php');

	// $url = "http://www.thermofisher.com.au/show.aspx?page=/ContentAUS/Lab-Equipment/Biological-Safety-Cabinets-Benches/Biological-Safety-Cabinets-Benches.html"; // l2
	//$url = "http://www.thermofisher.com.au/show.aspx?page=/ContentAUS/Lab-Equipment/Biological-Safety-Cabinets-Benches/ClassII-Biological-Safety-Cabinets.html"; // l3
	//$url = urldecode($_GET['url']);
	$html = new simple_html_dom();
	$html->load_file($url);

	// $content = $html->find('#PageContent');

	// $pageContent = new simple_html_dom();
	// $pageContent->load($content[0]->innertext);
	
	$c = $html->find('#PageContent',0);

	$p = array();

	function tidy($text){
		$new_text = preg_replace('/\s+/', ' ',$text);
		$new_text = str_replace("&rsaquo;", "",$new_text);
		$new_text = str_replace("™", "&trade;",$new_text);	
		//$new_text = htmlentities($new_text);
		$new_text = str_replace("&amp;", "and", $new_text);
		$new_text = trim($new_text);

		return $new_text;
	}

	function tidy_links($url){
		if(substr($url,0,30) == "http://www.thermofisher.com.au"){
			$url = substr($url,30);
		}
		if(substr($url,0,29) == "http://www.thermofisher.co.nz"){
			$url = substr($url,29);
		}
		if(substr($url, 0, 8) == "/Content"){
			$url = "/show.aspx?page=" . $url;
		}
// 		else{
// 			$new_url = $url;
// 		}

		return($url);
		//return substr($url, 0, 7);
	}
	
	
	function hdi($c){
		// HDI
		$data['type'] = "hdi";
		$data['settings']['type'] = "sub-category-default";
		
		if($c->find('h2')){
			$data['content']['heading'] = $c->find('h2',0)->innertext;
			$data['content']['copy'] = $c->find('h2',0)->nextSibling('p',0);
		}
		
		return $data;
		
	}

	function featured_gateway(){
		$data['type'] = "featured-gateway";
		return $data;
	}

	function alternating_hdi($c){
		$data['type'] = "alternating-hdi";
		
// 		if($c->find('.items-list')){
// 			$q = $c->find('.items-list');
			$cItems = count($c->find('h3'));
			for($x = 0; $x < $cItems; $x++){
				$data['content']['items'][$x]['heading'] = tidy(strip_tags($c->find('h3',$x)->innertext));
				$data['content']['items'][$x]['url'] = tidy_links($c->find('h3',$x)->find('a',0)->href);
				$data['content']['items'][$x]['tab'] = ($c->find('h3',$x)->find('a',0)->target == "_blank" ? "new" : "parent");
				$data['content']['items'][$x]['copy'] = tidy(strip_tags($c->find('h3',$x)->nextSibling('p',0)->innertext));
			}

		return $data; 
	}

	function videos(){
		$data['type'] = "videos";
		return $data;
	}
	
	
	function embedded_promos(){
		$data['type'] = "embedded-promos";
		$data['settings']['width'] = "normal";
		return $data;
	}


	function resources(){
		$data['type'] = "resources";
		return $data;
	}
	
	$data['sections'][] = hdi($c);
	$data['sections'][] = featured_gateway();
	$data['sections'][] = alternating_hdi($c);
	$data['sections'][] = videos();
	$data['sections'][] = embedded_promos();
	$data['sections'][] = resources();
	
	return $data;

}	

?>