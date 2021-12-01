<?php
/**
 * Filename: xml.php
 * Date: 10/11/12
 */

class LB_XML{

	private $generated_array = array("error"=>"Not a valid XML");
	private $XML = "<xml><error>no valid xml has been passed</error></xml>";

	public function __construct($xmlp = "<xml><error>no valid xml has been passed</error></xml>")
	{
		$this->XML = $xmlp;
		$this->XMLtoArray($xmlp);
		return $this;
	}

	private function XMLtoArray($XML)
	{
		$xml_parser = xml_parser_create();
		xml_parse_into_struct($xml_parser, $XML, $vals);
		xml_parser_free($xml_parser);
		$_tmp='';
		foreach ($vals as $xml_elem) {
			$x_tag=$xml_elem['tag'];
			$x_level=$xml_elem['level'];
			$x_type=$xml_elem['type'];
			if ($x_level!=1 && $x_type == 'close') {
				if (isset($multi_key[$x_tag][$x_level]))
					$multi_key[$x_tag][$x_level]=1;
				else
					$multi_key[$x_tag][$x_level]=0;
			}
			if ($x_level!=1 && $x_type == 'complete') {
				if ($_tmp==$x_tag)
					$multi_key[$x_tag][$x_level]=1;
				$_tmp=$x_tag;
			}
		}
		// jedziemy po tablicy
		foreach ($vals as $xml_elem) {
			$x_tag=$xml_elem['tag'];
			$x_level=$xml_elem['level'];
			$x_type=$xml_elem['type'];
			if ($x_type == 'open')
				$level[$x_level] = $x_tag;
			$start_level = 1;
			$php_stmt = '$xml_array';
			if ($x_type=='close' && $x_level!=1)
				$multi_key[$x_tag][$x_level]++;
			while ($start_level < $x_level) {
				$php_stmt .= '[$level['.$start_level.']]';
				if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level])
					$php_stmt .= '['.($multi_key[$level[$start_level]][$start_level]-1).']';
				$start_level++;
			}
			$add='';

			$multi_key2[$x_tag][$x_level]=0;
			if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type=='open' || $x_type=='complete')) {
				if (!isset($multi_key2[$x_tag][$x_level]))
					$multi_key2[$x_tag][$x_level]=0;
				else
				{
					$multi_key2[$x_tag][$x_level]++;
					$add='['.$multi_key2[$x_tag][$x_level].']';
				}

			}
			if (isset($xml_elem['value']) && trim($xml_elem['value'])!='' && !array_key_exists('attributes', $xml_elem)) {
				if ($x_type == 'open')
					$php_stmt_main=$php_stmt.'[$x_type][][\'_text\'] = $xml_elem[\'value\'];';
				else
					$php_stmt_main=$php_stmt.'[$x_tag][][\'_text\'] = $xml_elem[\'value\'];';
					//$php_stmt_main=$php_stmt.'[$x_tag]'.$add.'[\'_text\'] = $xml_elem[\'value\'];';
				eval($php_stmt_main);
			}
			if (array_key_exists('attributes', $xml_elem)) {
				if (isset($xml_elem['value'])) {
					$php_stmt_main=$php_stmt.'[$x_tag]'.$add.'[\'_text\'] = $xml_elem[\'value\'];';
					eval($php_stmt_main);
				}
				foreach ($xml_elem['attributes'] as $key=>$value) {
					$php_stmt_att=$php_stmt.'[$x_tag]'.$add.'[\'_attr\'][$key] = $value;';
					eval($php_stmt_att);
				}
			}
		}
		$this->generated_array = $xml_array;
	}

	public function asArray(){
		return $this->generated_array;
	}

	public function parse_xml($xml)
	{
		$red = array();

		foreach($xml as $k=>$v)
		{
			if($v instanceof SimpleXMLElement)
			{
				foreach($v as $d=>$r)
				{
					$red[$k][$d] = is_object($r) ? array_values((array)$r) : $r;
				}
			}
			else
			{
				$red[$k][] = $v;
			}
		}
		return (array)($red);
	}


}