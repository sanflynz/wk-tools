<?php 

class TableBuilder{

	public $items;
	public $classes;
	
	public $sURL = "/search.aspx?search=";
	public $gURL = "/godirect/main/productdetails.aspx?id=";


	

	private $column_widths = array();
	private $column_alignments = array();
	private $columns = array("item_code" => "", "description" => "");


	public function __construct($items,$classes){
		$this->items = $items;

		foreach($classes as $class){
			$this->classes .= " $class";
		}
		$this->classes = ltrim($this->classes, " ");

		
		
	}


	private function isGroupHeader($row){
		if(preg_match('[GROUP]', $row)){
			return true;
		}
		else{
			return false;
		}
	}

	private function startTable(){
		return "<table class=\"$this->classes\">\n";
	}

	private function endTable(){
		return "\t</tbody>\n</table>\n";
	}

	private function setColumnWidth($cell){
		if(preg_match('/[0-9]+%/',$cell,$w)){
			$this->column_widths[] = $w[0];
			// remove the reference
			$cell = preg_replace('/\[([0-9]+%)\]/','',$cell);
		}
		else{
			$this->column_widths[] = "";
		}
		return $cell;
	}

	private function setColumnAlign($cell){
		// Price
		if(preg_match('/price/i', $cell)){
			$this->column_alignments[] = "padding-right: 20px; text-align: right;";						
		}
		// Units and Size | [center]
		else if(preg_match('/Unit/i', $cell) || preg_match('/Size/i', $cell)){
			$this->column_alignments[] = "text-align: center;";
		}
		elseif(preg_match('/\[center\]/i', $cell)){
			$this->column_alignments[] = "text-align: center;";
			$cell = preg_replace('/\[center\]/i','',$cell);
		}
		elseif(preg_match('/\[left\]/i', $cell)){
			$this->column_alignments[] = "text-align: left;";
			$cell = preg_replace('/\[left\]/i','',$cell);
		}
		elseif(preg_match('/\[right\]/i', $cell)){
			$this->column_alignments[] = "text-align: right;";
			$cell = preg_replace('/\[right\]/i','',$cell);
		}
		
		// Other
		else{
			$this->column_alignments[] = "";
		}

		return $cell;
	}

	private function tableHead($cells){
		$output = "\t<thead>\n";
		$output .= "\t\t<tr>\n";
		$i = 0;
		foreach($cells as $c){
			$style = "";
			
			$c = $this->setColumnAlign($c);
			$c = $this->setColumnWidth($c);

			if($c == "Item Code"){	
				$this->columns['item_code'] = $i;
			}
			if($c == "Description"){	
				$this->columns['description'] = $i;
			}

			// For styling child rows later, what is the header called?
			//$h[$i] = $c;
					

			if($this->column_widths[$i]) {
				$style .= "width: " . $this->column_widths[$i] . "; ";
			}	
			if($this->column_alignments[$i]) {
				$style .= $this->column_alignments[$i];
			}			

			$output .= "\t\t\t<th style=\"". $style . "\">" . trim($c) . "</th>\n";

			$i++;
		}
		$output .= "\t\t</tr>\n";
		$output .= "\t</thead>\n";
		$output .= "\t<tbody>\n";

		return $output;
	}

	private function tableRow($cells){
		$i = 0;
		$output = "\t\t<tr>\n";
		foreach($cells as $c){
			$style = "";
			if($this->column_widths[$i]) {
				$style .= "width: " . $this->column_widths[$i] . "; ";
			}	
			if($this->column_alignments[$i]) {
				$style .= $this->column_alignments[$i];
			}	

			// Make Item Code into link
			if($i == $this->columns['item_code']){
				$c = "<a href=\"" . $this->sURL . $cells[$this->columns['item_code']] . "#gsc.tab=0&gsc.q=" . trim($c) . "\" onClick=\"_gaq.push(['_trackEvent', 'Product Search Link', 'Item Code', '" . $c . "']);\">" . trim($cells[$this->columns['item_code']]) . "</a>";
			}

			// Make Description into link where Item Code exists
			if((!empty($this->columns['item_code']) || $this->columns['item_code'] == "0") && $i == $this->columns['description']){
				$c = "<a href=\"" . $this->sURL . $cells[0] . "#gsc.tab=0&gsc.q=" . $cells[0] . "\"  onClick=\"_gaq.push(['_trackEvent', 'Product Search Link', 'Item Code', '" . trim($cells[0]) . "']);\">" . trim($c) . "</a>";
			}

			// 
			//if(trim($c) == "[BUY]"){
			if(preg_match('/\[BUY\]/', $c) || preg_match('/BUY./', $c)){
				$c = "<a href=\"" . $this->gURL . $cells[$this->columns['item_code']] . "\" class=\"btn btn-commerce btn-mini\" target=\"_blank\" onClick=\"_gaq.push(['_trackEvent', 'Product Buy Link', 'Item Code', '" . trim($this->gURL . $cells[$this->columns['item_code']]) . "']);\">Login to buy</a>";
				$style .= "text-align: center;";
				
			}

			$output .= "\t\t\t<td style=\"$style\">\n";

			$output .= $c;

			$output .= "\t\t\t</td>\n";

			$i++;
		}
		$output .= "\t\t</tr>\n";

		return $output;
	}
	
	public function build(){

		$output = "";

		$rows = explode("\n", $this->items);
		$t = 0;
		$r = 1;

		foreach($rows as $row){
			if($this->isGroupHeader($row) === true){
				$cells = explode("\t", $row);
				if($t > 0){
					// this should be the end of the previous table				
					$output .= $this->endTable();
					//$r = 1;
					unset($this->column_alignments);
					unset($this->column_widths);
					unset($this->columns);

				}
				if(preg_match('[HEADING]', $row)){
					$output .= "<h3>" . trim(str_replace("[GROUP][HEADING]", "", $row)) . "</h3>\n";
				}	
				$t++;	
				$r = 1;	

			}
			else{
				$cells = explode("\t", $row);
				if($r == 1){ 
					$output .= $this->startTable();
					$output .= $this->tableHead($cells);
					
				}
				else{
					$output .= $this->tableRow($cells);
				}
				$r++;
			}
			

		}
		
		$output .= $this->endTable();

		return $output;


	}

}

 ?>