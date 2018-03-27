<?php
function import_old_page($url, $settings){

	// print '<pre>'; 
	// print_r($settings);
	// print '</pre>';

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
		$new_text = trim($new_text);

		return $new_text;
	}
	
	function hdi($t,$c){
		// HDI
		// $t = 0;
		$q = $c->find('table',$t);
		if($q->find('h2',0)){
			$s['page-heading'] = tidy($q->find('h2',0)->innertext);
			$s['description'] = str_replace("<br>", "\n", $q->find('h2', 0)->nextSibling()->innertext);
		}
		elseif($q->find('h1',0)){
			$s['page-heading'] = tidy($q->find('h1',0)->innertext);
			$s['description'] = str_replace("<br>", "\n", $q->find('h1', 0)->nextSibling()->innertext);
		}
		$s['main-image'] = $q->find('img',0)->src;  // change slash direction?
		
		//$p['description'] = nl2br($pageContent->find('h2', 0)->nextSibling()->innertext);
		
		return $s;
		
	}


	function featured_gateway($t,$c){
		// POPULAR
		$p['popular-1'] = "";
		$p['popular-2'] = "";
		$p['popular-3'] = "";
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
			$p['popular-heading'] = tidy($q->find('h3',0)->innertext);
			$i = 1;
			for($i = 1; $i <= 3; $i++){

				$p['popular-' . $i] = tidy($c->find('a', $i + 2)->innertext) . "|";
				$p['popular-' . $i] .= $c->find('table',$t)->find('img', $i -1)->src . "|";
				$p['popular-' . $i] .= $c->find('a', $i)->href . "|";
				$p['popular-' . $i] .= ($c->find('a',$i-1)->target == "_blank") ? "new" : "parent";
			}
		}	
	
		return $p;
	}

	function category_lists($t,$c){
		// FEATURED
		if($t == "NA"){
			//echo "na";
		}
		elseif(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'category lists' table");
		}
		elseif(strpos($c->find('table', $t)->innertext, "Featured") === FALSE){
			setFlash("danger", "Could not match 'category lists' table");
		}
		else{
			$q = $c->find('table',$t);
			$p['featured-heading'] = $q->find('h2', 0)->innertext;
			$count = count($q->find('img'));
			for($x = 0; $x < $count; $x ++){
				$p['featured'][$x]['image'] = $q->find('img',$x)->src;
				$p['featured'][$x]['heading'] = tidy(strip_tags($q->find('a',$x)->innertext),'<br>');
				$p['featured'][$x]['url'] = $q->find('a',$x)->href;
				$p['featured'][$x]['tab'] = ($q->find('a',$x)->target == "_blank") ? "new" : "parent";
				$p['featured'][$x]['description'] = tidy($q->find('p',$x)->innertext);
			}
		}

		return $p; 
	}

	function videos($t,$c){
		$p['videos'] = "";
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
			$p['videos'] = "[HEADING]" . $q->find('h2',0)->innertext . "[ITEMS]" . $q->find('iframe',0)->src . "|";
			if($q->find('iframe',1)){
				$p['videos'] .= $q->find('iframe',1)->src;
			}
		}
		return $p;
	}

	function embedded_promos($t,$c){
		// // EMBEDDED PROMOS
		$p['pod-right'] = "";
		$p['pod-left'] = "";
		if($t == "NA"){
			//echo "na";
		}
		elseif(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'embedded promos' table");
		}
		elseif(!count($c->find('table', $t)->img) == 2){
			setFlash("danger", "Could not match 'embedded promos' table");
		}
		else{
			$q = $c->find('table',$t);
			$x = 0;
			$tab_left = ($q->find('a',$x)->target == "_blank") ? "new" : "parent";
			$p['pod-left'] = $q->find('img',$x)->alt . "|" . $q->find('img',$x)->src . "|" . $q->find('a',$x)->href . "|" . $tab_left;
			$x = 1;
			$tab_right = ($q->find('a',$x)->target == "_blank") ? "new" : "parent";
			$p['pod-right'] = $q->find('img',$x)->alt . "|" . $q->find('img',$x)->src . "|" . $q->find('a',$x)->href . "|" . $tab_right;
		}
		
		return $p;
	}

	function resources($t,$c){
		$p['resources']['left'] = "";
		$p['resources']['right'] = "";
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
			$p['resources-left'] = "[HEADING]" . $q->find('h2',0)->innertext;
			$p['resources-left'] .= "[ITEMS]";
			foreach($q->find('ul',0)->find('li') as $li){
				$p['resources-left'] .= str_replace(" &rsaquo;","",$li->find('a',0)->innertext) . "|";
				$p['resources-left'] .= $li->find('a',0)->href . "|";
				$p['resources-left'] .= ($li->find('a',0)->target == "_blank") ? 'new' : 'parent';
				if(strpos($li->find('a',0)->href, '.pdf')){ 
					$p['resources-left'] .= "|PDF|" . $li->find('a',0)->href . "|icon-lt-pdf";
				}
				$p['resources-left'] .= "\n";
			}

			if($q->find('ul',1)){ // if is a second list...
				$p['resources-right'] = "[HEADING]" . $q->find('h2',1)->innertext;
				$p['resources-right'] .= "[ITEMS]";
				foreach($q->find('ul',1)->find('li') as $li){
					$p['resources-right'] .= str_replace(" &rsaquo;","",$li->find('a',0)->innertext) . "|";
					$p['resources-right'] .= $li->find('a',0)->href . "|";
					$p['resources-right'] .= ($li->find('a',0)->target == "_blank") ? 'new' : 'parent';
					if(strpos($li->find('a',0)->href, '.pdf')){ 
						$p['resources-right'] .= "|PDF|" . $li->find('a',0)->href . "|icon-lt-pdf";
					}
					$p['resources-right'] .= "\n";
				}
			}
		}
		
		return $p;
	}

	$p = array_merge($p,hdi($settings['hdi'],$c));
	$p = array_merge($p,featured_gateway($settings['featured-gateway'],$c));
	$p = array_merge($p,category_lists($settings['category-lists'],$c));
	$p = array_merge($p,videos($settings['videos'],$c));
	$p = array_merge($p, embedded_promos($settings['embedded-promos'],$c));
	$p = array_merge($p, resources($settings['resources'],$c));
	
	return $p;

}	

?>