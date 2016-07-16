<?php

	class Pagination{

		private $conn;
		private $limit;
		private $page;
		private $query;
		public $total;

		public $maxLinks = 15; // if # links > 15, 
		public $showLinks = 5; // only show +/- links

		public function __construct($conn, $query){
			$this->conn = $conn;
			$this->query = $query;

			$r = $this->conn->query($this->query);
			$this->total = $r->num_rows;

		}

		public function getData($limit = 50, $page = 1){

			$this->limit = $limit;
			$this->page = $page;

			if($this->limit == "all"){
				$query = $this->query;
			}
			else{
				//$query = $this->query . " LIMIT " . (($this->page - 1) * $this->limit) . ", " . $this->limit;
				$offset = ($this->page - 1) * $this->limit;
				$query = $this->query . " LIMIT " . $this->limit . " OFFSET " . $offset;
			}

			$r = $this->conn->query($query);

			while ($row = $r->fetch_assoc()){
				//print_r($row); echo "<br>";
				$results[] = $row;
			}

			$result = new stdClass();
			$result->page = $this->page;
			$result->limit = $this->limit;
			$result->total = $this->total;
			$result->data = $results;
			
			return $result;

		}

		public function buildLinks(){

			$thisURI = $_SERVER['REQUEST_URI'];

			$totalPages = ceil($this->total / $this->limit);


			$links = 	"<ul class='pagination'>";

			// if page= not in the url (ie: first page), add it
			if(!preg_match('~(page=\d+&?|page=\d+)~i', $thisURI)){
				if(strpos('?', $thisURI) == false){
					$thisURI = $_SERVER['REQUEST_URI'] . '&page=' . $this->page;
				}
				else{
					$thisURI = $_SERVER['REQUEST_URI'] . '?page=' . $this->page;
				}
			}

			// previous page
			if($this->page == 1){
				$links .= "<li class='disabled'><a href='#' title='First Page'>&laquo;</a></li>";
				$links .= "<li class='disabled'><a href='#' title='Previous Page'>&lsaquo;</a></li>";
			}
			else{
				$links .= "<li><a href='" . preg_replace('~(page=\d+&?|page=\d+)~i', 'page=1', $thisURI) . "' title='First Page'>&laquo;</a></li>";
				$prevpage = "page=" . (($this->page)*1 - 1);
				$links .= "<li><a href='" . preg_replace('~(page=\d+&?|page=\d+)~i', $prevpage , $thisURI) . "' title='Previous Page'>&lsaquo;</a></li>";
			}
			
			if($totalPages > $this->maxLinks && $this->page > $this->showLinks + 1){
				$links .= "<li class='disabled'><a href='#' title='&hellip;'>&hellip;</a></li>";
			}

			for($i = 1; $i <= $totalPages; $i++){
				
				if($totalPages > $this->maxLinks){
					
					if($this->page == $i){
						$links .= "<li class='active'><a href='#'>" . $i . "</a></li>";
					}
					elseif($i >= ($this->page - $this->showLinks)  && $i <= ($this->page + $this->showLinks)){
						$thepage = "page=" . $i;
						$links .= "<li><a href='" . preg_replace('~(page=\d+&?|page=\d+)~i', $thepage, $thisURI) . "'>" . $i . "</a></li>";			
					}

				}
				else{

					if($this->page == $i){
						$links .= "<li class='active'><a href='#'>" . $i . "</a></li>";
					}
					//elseif($this->page == $totalPages){
					//	$thepage = "page=" . $i;
					//	$links .= "<li><a href='" . preg_replace('~(page=\d+&?|page=\d+)~i', $thepage, $thisURI) . "'>" . $i . "</a></li>";	
					//}
					else{
							$thepage = "page=" . $i;
							$links .= "<li><a href='" . preg_replace('~(page=\d+&?|page=\d+)~i', $thepage, $thisURI) . "'>" . $i . "</a></li>";	
						
					}

				}

				
				
			}


			// after pages
			if($totalPages > $this->maxLinks && $this->page < ($totalPages - $this->showLinks)){
				$links .= "<li class='disabled'><a href='#' title='&hellip;'>&hellip;</a></li>";
			}
			if($this->page == $totalPages){
				$links .= "<li class='disabled'><a href='#' title='Next Page'>&rsaquo;</a></li>";
				$links .= "<li class='disabled'><a href='#' title='Last Page'>&raquo;</a></li>";
			}
			else{
				$nextpage = "page=" . (($this->page)*1 + 1);
				$lastpage = "page=" . $totalPages;
				$links .= "<li><a href='" . preg_replace('~(page=\d+&?|page=\d+)~i', $nextpage , $thisURI) . "' title='Next Page'>&rsaquo;</a></li>";
				$links .= "<li><a href='" . preg_replace('~(page=\d+&?|page=\d+)~i', $lastpage, $thisURI) . "' title='Last Page'>&raquo;</a></li>";
				
			}

			$links .=	"</ul>";

			return $links;

		}


	}


?>