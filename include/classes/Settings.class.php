<?php

/***
 *	Class Settings
 *  ----------------- 
 *  Description : encapsulates session properties
 *	Written by  : ApPHP
 *  Version     : 1.0.1
 *  Updated	    : 13.02.2012
 *	Usage       : Core Class (ALL)
 *
 *	Used rank code functions: www.lampdeveloper.co.uk
 *	
 *	PUBLIC				  	STATIC				 	PRIVATE
 * 	------------------	  	---------------     	---------------
 *	__construct			    SetTimeZone             CheckHash
 *	__destruct                                     	HashURL
 *	GetTemplate                                    	StrToNum  
 *	GetParameter
 *	UpdateFields
 *	SetTemplate
 *	GetDataTagged
 *	CheckAlexaRank
 *	CheckGoogleRank
 *	LoadData
 *	
 *  1.0.1
 *      - added SetTimeZone()
 *      - updated SetTimeZone()
 *      -
 *      -
 *      -       
 **/

class Settings {

	public $error;
	
	private $res;
	private $template;
	
	//==========================================================================
    // Class Constructor
	//==========================================================================
	function __construct()
	{
		$this->error = '';
		$this->template = '';
		
		$this->LoadData();
	}

	//==========================================================================
    // Class Destructor
	//==========================================================================
    function __destruct()
	{
		// echo 'this object has been destroyed';
    }

	/**
	 *	Loads parameters 
	 */
	public function LoadData()
	{
		$sql = 'SELECT * FROM '.TABLE_SETTINGS;
		$this->res = database_query($sql, DATA_ONLY, FIRST_ROW_ONLY);
		if($this->res){
			$this->template = $this->res['template'];
		}
	}

	/**
	 *	Returns template name
	 */
	public function GetTemplate()
	{
		return decode_text($this->template);
	}
	
	/**
	 *	Returns parameter value by name
	 *		@param $field_name	
	 */
	public function GetParameter($field_name = '')
	{
		if(isset($this->res[$field_name])){
			return decode_text($this->res[$field_name]);
		}else{
			return '';
		}
	}

	/**
	 *	Updates fields
	 *		@param $params - pairs: field - value 
	 */
	public function UpdateFields($params = array())
	{		
		// check if this is a DEMO
		if(strtolower(SITE_MODE) == 'demo'){ $this->error = _OPERATION_BLOCKED; return false; }
		
		if(count($params) > 0){
			// prepare UPDATE statement
			$sql = 'UPDATE '.TABLE_SETTINGS.' SET ';
			$count = 0;
			foreach($params as $key => $val){
				if($count++ > 0) $sql .= ', ';
				$sql .= $key.' = \''.encode_text($val).'\'';				
			}
			if(database_void_query($sql)){
				$this->LoadData();
				return true;
			}else{
				//echo $sql.mysql_error();
				$this->error = _TRY_LATER;
				return false;
			}				
		}else{
			return '';						
		}
	}	

	/**
	 *	Sets site template
	 *		@param $template - template name
	 */
	public function SetTemplate($template = '')
	{
		// check if this is a DEMO
		if(strtolower(SITE_MODE) == 'demo'){ $this->error = _OPERATION_BLOCKED; return false; }
		
		$sql = 'UPDATE '.TABLE_SETTINGS.' SET template = \''.encode_text($template).'\'';
		if (database_void_query($sql)){
			$this->template = $template;
			return true;
		} else {
			$this->error = _TRY_LATER;
			return false;
		}							
	}
	
	/**
	 *	Returns tagged string 
	 *		@param $str
	 */
	public function GetDataTagged($str)
	{
		$str = str_replace('&lt;', '<', $str); 
		$str = str_replace('&gt;', '>', $str); 
		return $str;		
	}	

	/**
	 * Returns Alexa Page Rank
	 * 		@param $url
	 */
	public function CheckAlexaRank($url)
	{
		$part = '';
		$remote_url = 'http://data.alexa.com/data?cli=10&dat=snbamz&url='.trim($url);
		$search_for = '<POPULARITY URL';
		if($handle = @fopen($remote_url, 'r')) {
			while(!feof($handle)){
				$part .= fread($handle, 100);
				$pos = strpos($part, $search_for);
				if($pos === false) continue;
				else break;
			}
			$part .= fread($handle, 100);
			fclose($handle);
		}
		$str = explode($search_for, $part);
		$str_1 = (isset($str[1])) ? $str[1] : '';
		$str = array_shift(explode('"/>', $str_1));
		$str = explode('TEXT="', $str);
		$str_2 = (isset($str[1])) ? $str[1] : '';
		return $str_2;
	}

	/**
	 * Returns Google Page Rank
	 * 		@param $url
	 */
	public function CheckGoogleRank($url)
	{
		$pagerank = '-1';
		$nl = "\r\n";
		$fp = fsockopen('toolbarqueries.google.com', 80, $errno, $errstr, 30);
		if(!$fp){
		   //echo '$errstr ($errno)<br />\n';
		}else{
			$out  = 'GET /tbr?client=navclient-auto&ch='.$this->CheckHash($this->HashURL($url)).'&features=Rank&q=info:'.$url.'&num=100&filter=0 HTTP/1.1'.$nl;
			$out .= 'Host: toolbarqueries.google.com'.$nl;
			$out .= 'User-Agent: Mozilla/4.0 (compatible; GoogleToolbar 2.0.114-big; Windows XP 5.1)'.$nl;
			$out .= 'Connection: Close'.$nl.$nl;		
		    fwrite($fp, $out);		   
		    while(!feof($fp)){
				$data = fgets($fp, 128);
				$pos = strpos($data, 'Rank_');
				if($pos === false){} else{
					$pagerank = substr($data, $pos + 9);
				}
		    }
		   fclose($fp);           
		}
		return $pagerank;    
	}
	
	/**
	 * Checks hash for url
	 * 		@param $hashnum
	 */
	private function CheckHash($hashnum)
	{
		$check_byte = 0;
		$flag = 0;
		$hash_str = sprintf('%u', $hashnum);
		$length = strlen($hash_str);
		for($i = $length - 1; $i >= 0; $i --){
			$re = $hash_str{$i};
			if (1 === ($flag % 2)){              
				$re += $re;     
				$re = (int)($re / 10) + ($re % 10);
			}
			$check_byte += $re;
			$flag ++;	
		}
		$check_byte %= 10;
		if(0 !== $check_byte){
			$check_byte = 10 - $check_byte;
			if (1 === ($flag % 2)){
				if(1 === ($check_byte % 2)) $check_byte += 9;
				$check_byte >>= 1;
			}
		}	
		return '7'.$check_byte.$hash_str;
	}

	/**
	 * Genearate hash for url
	 * 		@param $str
	 */
	private function HashURL($str)
	{
		$check1 = $this->StrToNum($str, 0x1505, 0x21);
		$check2 = $this->StrToNum($str, 0, 0x1003F);	
		$check1 >>= 2; 	
		$check1 = (($check1 >> 4) & 0x3FFFFC0 ) | ($check1 & 0x3F);
		$check1 = (($check1 >> 4) & 0x3FFC00 ) | ($check1 & 0x3FF);
		$check1 = (($check1 >> 4) & 0x3C000 ) | ($check1 & 0x3FFF);			
		$t1 = (((($check1 & 0x3C0) << 4) | ($check1 & 0x3C)) <<2 ) | ($check2 & 0xF0F);
		$t2 = (((($check1 & 0xFFFFC000) << 4) | ($check1 & 0x3C00)) << 0xA) | ($check2 & 0xF0F0000);		
		return ($t1 | $t2);
	}
	
	/**
	 * Converts string into 32-bit integer
	 * 		@param $str
	 * 		@param $check
	 * 		@param $magic
	 */
	private function StrToNum($str, $check, $magic)
	{
		$int_32_u = 4294967296;  // 2^32	
		$length = strlen($str);
		for ($i = 0; $i < $length; $i++) {
			$check *= $magic; 	
			//If the float is beyond the boundaries of integer (usually +/- 2.15e+9 = 2^31), 
			//  the result of converting to integer is undefined
			//  refer to http://www.php.net/manual/en/language.types.integer.php
			if ($check >= $int_32_u) {
				$check = ($check - $int_32_u * (int) ($check / $int_32_u));
				//if the check less than -2^31
				$check = ($check < -2147483648) ? ($check + $int_32_u) : $check;
			}
			$check += ord($str{$i}); 
		}
		return $check;
	}
	
	/**
	 * Set timezone for the site
	 */
	public static function SetTimeZone()
	{
		$sql = 'SELECT * FROM '.TABLE_SETTINGS;		
		$result = database_query($sql, DATA_AND_ROWS, FIRST_ROW_ONLY, FETCH_ASSOC);
		if($result[1] > 0){
			$time_zone = (isset($result[0]['time_zone'])) ? @get_timezone_by_offset($result[0]['time_zone']) : '';
			if($time_zone) @date_default_timezone_set($time_zone);
			else if(!@date_default_timezone_set(TIME_ZONE)) date_default_timezone_set('UTC'); 
		}                                                   
	}
	
}

?>