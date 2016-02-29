<?php
	class Paging{
		private $query;
		public $dbh;
		private $current_page;
		private $results_per_page;
		
		private $total_records;
		private $total_pages;
		
		function __construct($query,$results_per_page=15){
			$servername = 'localhost';
			$username = 'wahgunsc_shahzad';
			$password = 'itm1234';
			$dbname = 'wahgunsc_shahzad1';
			$this->dbh = new mysqli($servername, $username, $password, $dbname);
				if ($this->dbh->connect_error) {
	    		die("Connection failed: " . $this->dbh->connect_error);
			} 
			$this->query=$query;
//print_r($_REQUEST);
			$current_page=$_GET['page'];
			//die("c=".$current_page);
			$this->current_page= $current_page<1 ? 1 : $current_page;
			$this->results_per_page=$results_per_page;
			
			$result=$this->dbh->query($this->query);
			$this->total_records=mysqli_num_rows($result);
			$this->total_pages=ceil($this->total_records/$this->results_per_page);
		}
		function get_start(){
			$start=($this->current_page-1)*$this->results_per_page;
			return $start;
		}
		function get_total_records(){
			return $this->total_records;
		}
		function get_total_pages(){
			return $this->total_pages;
		}
		function render_pages($b=false){

			// $grace pages on the left and $grace pages on the right of current page
			$grace=3;						
			$range=$grace*2;

			$start  = ($this->current_page - $grace) > 0 ? ($this->current_page - $grace) : 1;
			$end=$start + $range;
			//make sure $end doesn't go beyond total pages
			if($end > $this->total_pages){
				$end=$this->total_pages;
				//if there is a change in $end, adjust $start again
				$start= ($end - $range) > 0 ? ($end - $range) : 1;
			}
			$qstring=$_SERVER['QUERY_STRING'];
			$regex='|&?page=\d+|';
			$qstring=preg_replace($regex,"",$qstring);
			$separator=$qstring=='' ? '?' : '?'.$qstring.'&';

if($b){	// SEO friendly paging with no question mark
			if($start>1){
				echo '<a href="page_1" class="pageNo">1</a>...';
			}
			for($i=$start;$i<=$end;$i++){
				if($i==$this->current_page){
					// Current page is not clickable and different from other pages
					echo "<span class=\"disabledPageNo\">$i</span>";	
				} else {
					echo "<a href=\"page_$i\" class=\"pageNo\">$i</a>";
				}
			}
			if($end < $this->total_pages){
				// If $end is away from total pages, add a link of the last page
				echo "... <a href=\"page_{$this->total_pages}\" class=\"pageNo\">{$this->total_pages}</a>";	
			}
}
else{	// Paging with question mark
			if($start>1){
				echo '<a href="'.$separator.'page=1" class="pageNo">1</a>...';
			}
			for($i=$start;$i<=$end;$i++){
				if($i==$this->current_page){
					// Current page is not clickable and different from other pages
					echo "<span class=\"disabledPageNo\">$i</span>";
				} else {
					echo "<a href=\"".$separator."page=$i\" class=\"pageNo\">$i</a>";
				}
			}
			if($end < $this->total_pages){
				// If $end is away from total pages, add a link of the last page
				echo "... <a href=\"".$separator."page={$this->total_pages}\" class=\"pageNo\">{$this->total_pages}</a>";
			}
}

		}
	}
?>