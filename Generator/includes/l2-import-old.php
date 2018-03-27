<?php
function import_page($url,$settings){
	//error_reporting(0);
	include_once('../__vendor/simple_html_dom.php');

	$s = array(
			'mondrian-f' => array('t' => 1, 's' => 0),
			'hdi' => array('t' => 2, 's' => 1),
			'featured-gateway' => array('t' => 4, 's' => 2),
			'category-lists' => array('t' => 5, 's' => 3),
			'embedded-promos' => array('t' => 5, 's' => 4),
			'resources' => array('t' => 6, 's' => 5)
		);
	$t_mod = 0;

	function tidy($text){
		$new_text = preg_replace('/\s+/', ' ',$text);
		$new_text = str_replace("&rsaquo;", "",$new_text);
		$new_text = str_replace("™", "&trade;",$new_text);	
		//$new_text = htmlentities($new_text);
		$new_text = trim($new_text);

		return $new_text;
	}

	function tidy_links($url){
		if(substr($url, 0, 7) == "/Content"){
			$new_url = "/show.aspx?page=" . $url;
		}
		else{
			$new_url = $url;
		}

		return($new_url);
	}


	$data = array();
	$html = new simple_html_dom();
	$html->load_file($url);

	$c = $html->find('#PageContent',0);

	// mondrian-f
	$m = $s['mondrian-f']['s'];
	$data['sections'][$m]['type'] = "mondrian-f";
	$q = $c->find('table',$s['mondrian-f']['t']);
	
	$data['sections'][$m]['content']['main-image'] = $q->find('img',0)->src;

	for($x = 1; $x <= 5; $x++){
		$data['sections'][$m]['content']['navigation'][$x]['url'] = tidy_links($q->find('a',$x-1)->href);
		$data['sections'][$m]['content']['navigation'][$x]['text'] = tidy(strip_tags($q->find('a',$x-1)->innertext));
		$data['sections'][$m]['content']['navigation'][$x]['tab'] = ($q->find('a',$x-1)->target == "_blank") ? "new" : "parent";
	}

	// hdi
	$m = $s['hdi']['s'];
	$data['sections'][$m]['type'] = "hdi";
	$q = $c->find('table',$s['hdi']['t']);
	$data['sections'][$m]['content']['heading'] = tidy($q->find('h2',0)->innertext);
	$data['sections'][$m]['content']['copy'] = tidy($q->find('p',0)->innertext);

	// featured-gateway
	$m = $s['featured-gateway']['s'];
	$data['sections'][$m]['type'] = "featured-gateway";
	if($c->find('table',$s['featured-gateway']['t']) && (strpos($c->find('table',$s['featured-gateway']['t'])->innertext, "Popular") != false)){
		$q = $c->find('table',$s['featured-gateway']['t']);
		$data['sections'][$m]['content']['heading'] = $q->find('h3',0)->innertext;


		for($x = 0; $x <=2; $x++){
			$data['sections'][$m]['content']['items'][$x]['image'] = $q->find('img',$x)->src;
			$data['sections'][$m]['content']['items'][$x]['url'] = $q->find('a',$x)->href;
			$data['sections'][$m]['content']['items'][$x]['text'] = tidy(strip_tags($q->find('a',$x + 3)->innertext, '<br>'));
			$data['sections'][$m]['content']['items'][$x]['tab'] = ($q->find('a',$x + 3)->target == "_blank") ? "new" : "parent";
		}
	}
	else{
		$t_mod = -1;
	}

	// CATEGORY LISTS 
	$m = $s['category-lists']['s'];
	$data['sections'][$m]['type'] = "category-lists";
	$q = $c->find('table',$s['category-lists']['t'] + $t_mod);

	$data['sections'][$m]['content']['heading'] = $q->find('h2',0)->innertext;
	for($x = 1; $x <= count($q->find('h3')); $x++){
		$data['sections'][$m]['content']['items'][$x]['heading'] = strip_tags($q->find('h3',$x - 1)->innertext,'<br>');
		$data['sections'][$m]['content']['items'][$x]['url'] = $q->find('a',$x - 1)->href;
		$data['sections'][$m]['content']['items'][$x]['tab'] = ($q->find('a',$x -1)->target == "_blank") ? "new" : "parent";
		$data['sections'][$m]['content']['items'][$x]['copy'] = $q->find('p',$x - 1)->innertext;
	}


	// EMBEDDED PROMOS 
	$m = $s['embedded-promos']['s'];
	$data['sections'][$m]['type'] = "embedded-promos";
	$q = $c->find('table',$s['embedded-promos']['t'] + $t_mod);

	// this one is tricky, is the actually last tr of the previous table
	$count_tr = count($q->find('tr'));  
	$q = $q->find('tr',$count_tr - 2);
	for($x = 1; $x <= 2; $x++){
		$data['sections'][$m]['content'][$x]['url'] = $q->find('a',$x - 1)->href;
		$data['sections'][$m]['content'][$x]['tab'] = ($q->find('a',$x -1)->target == "_blank") ? "new" : "parent";
		$data['sections'][$m]['content'][$x]['image'] = $q->find('img',$x - 1)->src;
		$data['sections'][$m]['content'][$x]['name'] = $q->find('img',$x - 1)->getAttribute('alt');

	}


	// RESOURCES
	$m = $s['resources']['s'];
	$data['sections'][$m]['type'] = "resources";
	if($c->find('table',$s['resources']['t'])){
		$q = $c->find('table',$s['resources']['t'] + $t_mod);
	}
	

	return $data;

}	

?>