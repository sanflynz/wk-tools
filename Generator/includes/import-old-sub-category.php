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
	
	
	function hdi($t,$c){
		// HDI
		$data['type'] = "hdi";
		$data['settings']['type'] = "sub-category-default";
		if(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'HDI' table");
		}
		else{
			$q = $c->find('table',$t);
			if($q->find('h2',0)){
				$data['content']['heading'] = tidy($q->find('h2',0)->innertext);
				$data['content']['copy'] = str_replace("<br>", "\n", $q->find('h2', 0)->nextSibling()->innertext);
			}
			elseif($q->find('h1',0)){
				$data['content']['heading'] = tidy($q->find('h1',0)->innertext);
				$data['content']['copy'] = str_replace("<br>", "\n", $q->find('h1', 0)->nextSibling()->innertext);
			}
			else{
				setFlash("warning", "Unable to find HDI content");
			}
			if($q->find('img',0)){
				$data['content']['image'] = $q->find('img',0)->src;  // change slash direction?
			}
		}
		
		return $data;
		
	}
	


	function featured_gateway($t,$c){
		// POPULAR
// 		$p['popular-1'] = "";
// 		$p['popular-2'] = "";
// 		$p['popular-3'] = "";
		$data['type'] = "featured-gateway";
		if($t == "NA"){
			//echo "na";
		}
		elseif(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'Featured / gateway' table");
		}
		elseif(strpos($c->find('table', $t)->innertext, "Popular") === FALSE){
			setFlash("danger", "Could not match 'Featured / gateway' table");
		}
		else{
			$q = $c->find('table', $t);
			$data['content']['heading'] = tidy($q->find('h3',0)->innertext);
			//$i = 1;
			for($x = 0; $x <= 2; $x++){

				$data['content']['items'][$x]['text'] = tidy(strip_tags($c->find('a', $x + 3)->innertext));
				$data['content']['items'][$x]['image'] = $c->find('table',$t)->find('img', $x)->src;
				$data['content']['items'][$x]['url'] = tidy_links($c->find('a', $x)->href);
				$data['content']['items'][$x]['tab'] = ($c->find('a',$x)->target == "_blank") ? "new" : "parent";
			}
		}	
	
		return $data;
	}

	function alternating_hdi($t,$c){
		$data['type'] = "alternating-hdi";
		// FEATURED
		if($t == "NA"){
			//echo "na";
		}
		elseif(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'alternating hdi' table");
		}
		elseif(strpos($c->find('table', $t)->innertext, "Featured") === FALSE){
			setFlash("danger", "Could not match 'alterating hdi' table");
		}
		else{
			$q = $c->find('table',$t);
			$data['content']['heading'] = $q->find('h2', 0)->innertext;
			$count = count($q->find('img'));
			for($x = 1; $x <= $count; $x++){
				$data['content']['items'][$x]['image'] = $q->find('img',$x-1)->src;
				$data['content']['items'][$x]['heading'] = tidy(strip_tags($q->find('a',$x-1)->innertext),'<br>');
				$data['content']['items'][$x]['url'] = tidy_links($q->find('a',$x-1)->href);
				$data['content']['items'][$x]['tab'] = ($q->find('a',$x-1)->target == "_blank") ? "new" : "parent";
				$data['content']['items'][$x]['copy'] = tidy($q->find('p',$x-1)->innertext);
			}
		}

		return $data; 
	}

	function videos($t,$c){
		$data['type'] = "videos";
		//$p['videos'] = "";
		// VIDEOS 
		if($t == "NA"){
			//echo "na";
		}
		elseif(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'videos' table");
		}
		elseif(strpos(strtolower($c->find('table', $t)->innertext), "videos") === FALSE){
			setFlash("danger", "Could not match 'videos' table");
		}
		else{
			$q = $c->find('table',$t);
			$data['content']['heading'] = $q->find('h2',0)->innertext;
			$data['content']['items'][0] = $q->find('iframe',0)->src;
			if($q->find('iframe',1)){
				$data['content']['items'][1] = $q->find('iframe',1)->src;
			}
		}
		return $data;
	}
	
	
	function embedded_promos($t,$c){
		$data['type'] = "embedded-promos";
		$data['settings']['width'] = "wide";
		
		
		if(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'category lists' table");

		}
		else{
			$q = $c->find('table',$t);
			if(!$q->find('img')){
				$q = $c->find('table',$t+1);
			}
			for($x = 1; $x <= 2; $x++){
				$data['content'][$x]['image'] = $q->find('img', $x-1)->src;
				$data['content'][$x]['url'] = tidy_links(strip_tags($q->find('a', $x-1)->href));
				$data['content'][$x]['name'] = $q->find('img', $x-1)->alt;
				$data['content'][$x]['tab'] = ($q->find('a',$x-1)->target == "_blank") ? "new" : "parent";
			}
		}

		return $data;
	}


	function resources($t,$c){
		$data['type'] = "resources";
// 		$p['resources']['left'] = "";
// 		$p['resources']['right'] = "";
		if($t == "NA"){
			//echo "na";
		}
		elseif(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'resources' table");
		}
		elseif(strpos(strtolower($c->find('table', $t)->innertext), "resources") === FALSE){
			setFlash("danger", "Could not match 'resources' table");
		}
		else{
			$q = $c->find('table',$t);
			$rCount = count($q->find('h2'));
			for($x = 0; $x < $rCount; $x++){
				echo $x;
				$data['content'][$x]['heading'] = $q->find('h2',$x)->innertext;
				$parent = $q->find('h2',$x)->parent()->parent();
				if($q->find('ul')){
					$cLinks = count($q->find('ul',$x)->find('li'));
					for($y = 0; $y < $cLinks; $y++){
						$li = $q->find('ul',$x)->find('li',$y);
						$data['content'][$x]['link'][$y]['name'] = str_replace(" &rsaquo;","",$li->find('a',$y)->innertext);
						$data['content'][$x]['link'][$y]['url'] = tidy_links($li->find('a',$y)->href);
						$data['content'][$x]['link'][$y]['tab'] = ($li->find('a',$y)->target == "_blank") ? 'new' : 'parent';
						if(strpos($li->find('a',$y)->href, '.pdf')){ 
							//$p['resources-left'] .= "|PDF|" . $li->find('a',0)->href . "|icon-lt-pdf";
							$data['content'][$x]['link'][$y]['icon'] = "icon-lt-pdf";
							$data['content'][$x]['link'][$y]['tracking']['category'] = "Download";
							$data['content'][$x]['link'][$y]['tracking']['action'] = "PDF";
							$data['content'][$x]['link'][$y]['tracking']['label'] = "this.href";
						}
						//$p['resources-left'] .= "\n";
					}
				}
				else{
					$td = ($x == 0) ? 1 : 3;
					
					$cLinks = count($parent->next_sibling()->find('td',$td)->find('a'));
				
					for($y = 0; $y < $cLinks; $y++){
						$li = $parent->next_sibling()->find('td',$td)->find('a',$y);
						$data['content'][$x]['link'][$y]['name'] = tidy(strip_tags(str_replace(" &rsaquo;","",$li->innertext)));
						$data['content'][$x]['link'][$y]['url'] = tidy_links($li->href);
						$data['content'][$x]['link'][$y]['tab'] = ($li->target == "_blank") ? 'new' : 'parent';
						if(strpos($li->href, '.pdf')){ 
							//$p['resources-left'] .= "|PDF|" . $li->find('a',0)->href . "|icon-lt-pdf";
							$data['content'][$x]['link'][$y]['icon'] = "icon-lt-pdf";
							$data['content'][$x]['link'][$y]['tracking']['category'] = "Download";
							$data['content'][$x]['link'][$y]['tracking']['action'] = "PDF";
							$data['content'][$x]['link'][$y]['tracking']['label'] = "this.href";
						}
						//$p['resources-left'] .= "\n";
					}
				}
			}
			
			
// 			$p['resources-left'] = "[HEADING]" . $q->find('h2',0)->innertext;
// 			$p['resources-left'] .= "[ITEMS]";
// 			foreach($q->find('ul',0)->find('li') as $li){
// 				$p['resources-left'] .= str_replace(" &rsaquo;","",$li->find('a',0)->innertext) . "|";
// 				$p['resources-left'] .= $li->find('a',0)->href . "|";
// 				$p['resources-left'] .= ($li->find('a',0)->target == "_blank") ? 'new' : 'parent';
// 				if(strpos($li->find('a',0)->href, '.pdf')){ 
// 					$p['resources-left'] .= "|PDF|" . $li->find('a',0)->href . "|icon-lt-pdf";
// 				}
// 				$p['resources-left'] .= "\n";
// 			}

// 			if($q->find('ul',1)){ // if is a second list...
// 				$p['resources-right'] = "[HEADING]" . $q->find('h2',1)->innertext;
// 				$p['resources-right'] .= "[ITEMS]";
// 				foreach($q->find('ul',1)->find('li') as $li){
// 					$p['resources-right'] .= str_replace(" &rsaquo;","",$li->find('a',0)->innertext) . "|";
// 					$p['resources-right'] .= $li->find('a',0)->href . "|";
// 					$p['resources-right'] .= ($li->find('a',0)->target == "_blank") ? 'new' : 'parent';
// 					if(strpos($li->find('a',0)->href, '.pdf')){ 
// 						$p['resources-right'] .= "|PDF|" . $li->find('a',0)->href . "|icon-lt-pdf";
// 					}
// 					$p['resources-right'] .= "\n";
// 				}
// 			}
		}
		
		return $data;
	}
	
	$data['sections'][] = hdi($settings['hdi'],$c);
	$data['sections'][] = featured_gateway($settings['featured-gateway'],$c);
	$data['sections'][] = alternating_hdi($settings['alternating-hdi'],$c);
	$data['sections'][] = videos($settings['videos'],$c);
	$data['sections'][] = embedded_promos($settings['embedded-promos'],$c);
	$data['sections'][] = resources($settings['resources'],$c);
	
	
// 	$p = array_merge($p,hdi($settings['hdi'],$c));
// 	$p = array_merge($p,featured_gateway($settings['featured-gateway'],$c));
// 	$p = array_merge($p,category_lists($settings['category-lists'],$c));
// 	$p = array_merge($p,videos($settings['videos'],$c));
// 	$p = array_merge($p, embedded_promos($settings['embedded-promos'],$c));
// 	$p = array_merge($p, resources($settings['resources'],$c));
	
	return $data;

}	

?>