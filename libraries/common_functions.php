<?php

/*
 *
 *This script contains the basic functions that are written by Hammad Asif
 *mrhammadasif@gmail.com
 *
**/
function array_upper($input)
{
	foreach ($input as $key => $value) {
		if(is_array($value))
			$input[$key] =  array_upper($value);
		else
			$input[$key] =  strtoupper($value);
	}
	return $input;
}

function rand_password($length = 14)
{
	$password = "";
	$possible = "otokYWjca1ClK9INYQzkpNFUhPiKeCgFtjJxRo8y2mg9iosRqdGfYuZIuLxxtQArvRmeXH0cMpingCbA";
	$maxlength = strlen($possible);
	if ($length > $maxlength)
	{
	  $length = $maxlength;
	}
	$i = 0;
	while ($i < $length)
	{
	  $char = substr($possible, mt_rand(0, $maxlength-1), 1);
	  if (!strstr($password, $char))
	  {
		  $password .= $char;
		  $i++;
	  }
	}
	return $password;
}

function err($message, $redirect = array(), $title = "") {
	include _VIEW.'error.php';
	if(is_array($redirect) && isset($redirect[0]) && $redirect[0]== "redirect")
	echo '<h2>You are being redirected to "'.$redirect[1].'" in 5 seconds </h2><meta http-equiv="refresh" content="5;URL='.BASEURL.$redirect[1].'">';
}

function summary($str, $n = 200, $end_char = '&#8230;')
{
	$str = strip_tags($str);
	if (strlen($str) < $n)
	{
		return $str;
	}

	$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

	if (strlen($str) <= $n)
	{
		return $str;
	}

	$out = "";
	foreach (explode(' ', trim($str)) as $val)
	{
		$out .= $val.' ';

		if (strlen($out) >= $n)
		{
			$out = trim($out);
			return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
		}
	}
	return false;
}

function menu($active)
{
	include(_MAP."views/admin/menu.php");
}

function bread($path)
{
	$red = '
	<div class="breadcrumbs">
			<ul>
		<li class="home"><a href="'.BASEURL.'admin">Admin Dashboard</a></li>';
	$p = explode("/",$path);
	foreach($p as $u)
	{
				$red .= "<li>".ucwords($u)."</li>";
	}

	$red.='</ul>
		</div>';
	echo $red;
}

//function for redirecting the page
function redirect($link) {
	header("location:".BASEURL . trim($link));
	die();
}

function redirect_url($link) {
	header("location:".trim($link));
	die();
}

function show404()
{
	err("The Requested Page was not found!", false, "Page Not Found!");
	die();
}
/*
 *Function for escaping any thing passed
*/
function escape_ev($arr) {
	if(is_array($arr))
	{
		$return = array();
		foreach($arr as $k=>$v):
			$return[$k] = escape_ev($v);
		endforeach;
	}
	else if(is_string($arr))
	{
		$return = addslashes($arr);
	}
	else
	{
		$return = $arr;
	}
	return $return;
}

function unescape_ev($arr)
{
	if(is_array($arr))
	{
		$return = array();
		foreach($arr as $k=>$v):
			$return[$k] = unescape_ev($v);
		endforeach;
	}
	else if(is_string($arr))
	{
		$return = stripslashes($arr);
	}
	else
	{
		$return = $arr;
	}
	return $return;
}

function error_off()
{
	error_reporting(0);
}

function error_on()
{
	error_reporting(E_ALL);
}


function parse_signed_request($signed_request, $secret) 
{
		list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
		// decode the data
		$sig = base64_url_decode($encoded_sig);
		$data = json_decode(base64_url_decode($payload), true);
		if (strtoupper($data['algorithm']) !== 'HMAC-SHA256')
		{
			err('Unknown algorithm. Expected HMAC-SHA256');
			return null;
		}
		// check sig
		$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		if ($sig !== $expected_sig) 
		{
			err('Bad Signed JSON signature!');
			return null;
	    }
	 return $data;
	}
	
function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
}
function array_sort($array, $on, $order=SORT_ASC)
{
	$new_array = array();
	$sortable_array = array();

	if (count($array) > 0) {
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k2 => $v2) {
					if ($k2 == $on) {
						$sortable_array[$k] = $v2;
					}
				}
			} else {
				$sortable_array[$k] = $v;
			}
		}

		switch ($order) {
			case SORT_ASC:
				asort($sortable_array);
				break;
			case SORT_DESC:
				arsort($sortable_array);
				break;
		}

		foreach ($sortable_array as $k => $v) {
			$new_array[$k] = $array[$k];
		}
	}

	return $new_array;
}

function get_package_details($red = 0)
{
	if(intval($red) === 1)
	{
		return array("detail"=>"Simplified Divorce", "total"=>"129","amount"=>129);
	}
	else if(intval($red) === 2)
	{
		return array("detail"=>"No Kids", "total"=>"129", "amount"=>129);
	}
	else if(intval($red) === 3)
	{
		return array("detail"=>"Kids", "total"=>"129", "amount"=>129);
	}
	else if(intval($red) === 4)
	{
		return array("detail"=>"Child Support", "total"=>"49", "amount"=>49);
	}
	else
		return false;
}

?>