<?php
	set_time_limit(0);
	class Crawler {

		public $url;
		public $startUrl;
		public $links;
		public $obsoleteLinks; // array // urls etc that might be obsolote
		public $baseURL;


		// search depth (recursive)
		
		function __construct($url){
			$this->startURL = $url;
			$this->url = $url;

			include_once('../__vendor/simple_html_dom.php');

			// Should I really have this as a class extending another class?
			$this->html = new simple_html_dom();
			$this->html->load_file($this->url);
		}


		// function setUrl($new_url){
		// 	$this->url = $new_url;
		// }

		function isInternalLink($link){
			$domain = parse_url($this->startURL);
			if(substr($link,0,4) == "http" && strpos($link, "http://" . $domain['host'] . "/") === FALSE){
				return FALSE;
			}
			else{
				return TRUE;
			}
			
			

			// return true or false
		}

		// function getUrl(){
		// 	return $this->url;
		// }

		function crawlUrl(){
			//$links = array('internal' => array(), 'external' => array());
			$links = array();
			
			foreach($this->html->find('a') as $link){
				$text = strip_tags($link->innertext);
				$links[] = array(
							'text' => $text,
							'url' => $link->href,
							'internal' => $this->isInternalLink($link->href),
							'obsolete' => $this->badLinks($link->href),
							'target' => $link->target,
							'http_status' => $this->http_status($link->href)

				);
			}
			return $links;

		}

		function http_status($url){
			if(substr($url,0,4) != "http"){
				$domain = parse_url($this->startURL);
				$url = "http://" . $domain['host'] . $url;
			}
			$handle = curl_init($url);
			curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

			/* Get the HTML or whatever is linked in $url. */
			$response = curl_exec($handle);

			/* Check for 404 (file not found). */
			return curl_getinfo($handle, CURLINFO_HTTP_CODE);
		}

		function badLinks($link){
			$val = FALSE;
			//$pattern = "#^https?://([a-z0-9-]+\.)*" . addslashes($link) . "(/.*)?$#";	
			
			foreach($this->obsoleteLinks as $l){
				$pattern = "#^https?:\/\/(www\.)?" . $l . "(.*)#";
				if(preg_match($pattern, $link)){
					$val = TRUE;
				}
			}
			
			return($val);
			//$links = explode(",",$this->obsoleteLinks);

			//if(in_array($url, haystack))
			// find unwanted urls
			// eg: *thermoscientific.com*
		}

		// create xml sitemap



		function basicSEOcheck(){
			$status = TRUE;
			$arr = array();

			if(!$this->html->find('meta[name=description]',0)){
				$status = FALSE;
				$arr['description'] = "";
			}
			else{
				$arr['description'] = $this->html->find('meta[name=description]',0)->content;
			}

			if(!$this->html->find('meta[name=keywords]',0)){
				$status = FALSE;
				$arr['keywords'] = "";
			}
			else{
				$arr['keywords'] = $this->html->find('meta[namekeywords]',0)->content;
			}

			if(!$this->html->find('h1')){
				$status = FALSE;
				$arr['h1'] = "";
			}
			else{
				$arr['h1'] = $this->html->find('h1',0)->innertext;
			}

			$title = $this->html->find('title',0);
			if(!$title){
				$status = FALSE;
				$arr['title'] = "";
			}
			else{
				$arr['title'] = trim($title->plaintext);
			}

			$seo = array('status' => $status, 'message' => $arr);
			return $seo;

		}


		
		

		
		
		

	}
?>