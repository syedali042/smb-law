<?php
	class LB_TEMPLATE {
		private $headr;
		private $footer;
		private $content;
		
		public function __construct( $headrfile='', $footerfile='')
	   {
			if($headrfile!='')
				$this->loadheader($headrfile);
			if($footerfile!='')	
				$this->loadfooter($footerfile);
				
	   }
	   
	   public function loadheader($headrfile='', $rtrn=false){
			if($headrfile!=''){
				$filename =  _VIEW. $headrfile._EXT;
				if (!file_exists($filename)) {
					die("Error loading header template.<br />");
				} 
				if($rtrn){
					$output = file_get_contents($filename);
					return $output;
				}	
				else{
					$this->headr = $filename;
				}	
			}
	   }
	   
	   public function loadfooter($footerfile='', $rtrn=false){
			if($footerfile!=''){
				$filename =  _VIEW. $footerfile._EXT;
				if (!file_exists($filename)) {
					die("Error loading template.<br />");
				} 
				if($rtrn){
					$output = file_get_contents($filename);
					return $output;
				}	
				else {
					$this->footer = $filename;
				}	
			}
	   }
	   
	    public function loadcontent($contentfile='', $rtrn=false){
			if($contentfile!=''){
				$filename = _VIEW. $contentfile._EXT;
				if (!file_exists($filename)) {
					die("Error loading template.<br />");
				} 
				if($rtrn){
					$output = file_get_contents($filename);
					return $output;
				}	
				else {	
					$this->content = $filename;
				}	
			}
	   }
	   
	   public function loadview($data='', $rtrn = false, $end_script = true){
			if($rtrn){
				$output = file_get_contents($this->headr);
				$output .= file_get_contents($this->content);
				$output .= file_get_contents($this->footer);
				return $output;
			}	
			else {	
				if(is_array($data))
					extract($data);	
					
				include($this->headr);
				include($this->content);
				include($this->footer);
				
				if($end_script) die();
		   }	
	   }
	   
	}
?>