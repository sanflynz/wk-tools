<?php
function import_page($url,$settings){
	//error_reporting(0);
	include_once('../__vendor/simple_html_dom.php');

	// print '<pre>'; 
	// print_r($settings);
	// print '</pre>';

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
		if(substr($url, 0, 8) == "/Content"){
			$new_url = "/show.aspx?page=" . $url;
		}
		else{
			$new_url = $url;
		}

		return($new_url);
		//return substr($url, 0, 7);
	}

	$data = array();
	$html = new simple_html_dom();
	$html->load_file($url);

	$c = $html->find('#PageContent',0);

	//setFlash("info", "importing stuff!");

	function mondrian_a($t,$c){
		$data['type'] = "mondrian-a";
		if(!$c->find('table', $t)){
			setFlash("danger", "Could not locate 'Mondrian a' table");
		}
		else{
			$q = $c->find('table', $t);
			

			$data['content']['feature']['image'] = $q->find('img',0)->src;
			$data['content']['feature']['name'] = $q->find('img',0)->alt;
			$data['content']['feature']['url'] = tidy_links($q->find('a',0)->href);
			$data['content']['feature']['tab'] = ($q->find('a',0)->target == "_blank") ? "new" : "parent";

			$data['content']['centre']['image'] = $q->find('img',1)->src;
			$data['content']['centre']['name'] = $q->find('img',1)->alt;
			$data['content']['centre']['url'] = tidy_links($q->find('a',1)->href);
			$data['content']['centre']['tab'] = ($q->find('a',1)->target == "_blank") ? "new" : "parent";

			$data['content']['landscape']['image'] = $q->find('img',2)->src;
			$data['content']['landscape']['name'] = $q->find('img',2)->alt;
			$data['content']['landscape']['url'] = tidy_links($q->find('a',7)->href);
			$data['content']['landscape']['tab'] = ($q->find('a',7)->target == "_blank") ? "new" : "parent";

			for($x = 1; $x <= 5; $x++){ // Navigation
				$data['content']['navigation'][$x]['text'] = tidy(strip_tags($q->find('a',$x+1)->innertext));
				$data['content']['navigation'][$x]['url'] = tidy_links($q->find('a',$x+1)->href);
				$data['content']['navigation'][$x]['tab'] = ($q->find('a',$x+1)->target == "_blank") ? "new" : "parent";
			}

			// landscape panel
		}
		

		return $data;
	}

	function hdi($t,$c){
		// HDI
		$data['type'] = "hdi";
		$data['settings']['type'] = "storefront-default";
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


	function category_lists($ts,$c){
		// FEATURED
		$data['type'] = "category-lists";
		$data['settings']['columns'] = 4;
		$i = 1;
		foreach($ts as $t){
			if(!$c->find('table', $t)){
				setFlash("danger", "Could not locate 'category lists' table");
			}
			else{
				$q = $c->find('table',$t);

				if($q->find('h2',0)){
					$data['content']['heading'] = $q->find('h2', 0)->innertext;
				}
				$count = count($q->find('a'));
				for($x = 1; $x <= $count; $x ++){
					$data['content']['items'][$i]['heading'] = tidy(strip_tags($q->find('a',$x-1)->innertext),'<br>');
					$data['content']['items'][$i]['url'] = tidy_links($q->find('a',$x-1)->href);
					$data['content']['items'][$i]['tab'] = ($q->find('a',$x-1)->target == "_blank") ? "new" : "parent";
					$data['content']['items'][$i]['copy'] = tidy($q->find('p',$x-1)->innertext);
					$i++;
				}
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



	$data['sections'][] = mondrian_a($settings['mondrian-a'],$c);
	$data['sections'][] = hdi($settings['hdi'],$c);
	$data['sections'][] = category_lists($settings['category-lists'],$c);
	$data['sections'][] = embedded_promos($settings['embedded-promos'],$c);
	// print '<pre>'; 
	// print_r($data);
	// print '</pre>';

	return $data;
}
?>