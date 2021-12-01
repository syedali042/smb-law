<?php


/**************************
*	All right Reserved.   *
*	Digital Monks, Inc.   *
*	Author: Hammad Asif   *
*	hammad@digimonks.com  *
***************************
*/

/*
*@Getting the file path and setting it
**/

ini_set("session.use_trans_sid","1");
$file_info_array = pathinfo(__FILE__);
$main_path = str_replace("\\","/",$file_info_array['dirname'].'/');
define('_MAP',$main_path);
define('_VIEW', _MAP . "views/");

$get_url_str = isset($_GET['path_gen'])?$_GET['path_gen']:NULL;
//$get_url_str = isset($_GET['path_gen'])?str_replace('-', '_', $_GET['path_gen']):NULL;

require_once(_MAP."libraries/common_functions.php");//adding the custom function library :)
require_once(_MAP."config/config.php");
require_once(_MAP.'libraries/recaptchalib.php');

$controller = DEFAULT_CONTROLLER;
$func = 'index';
$arg = 0;

if(substr($get_url_str, -1) === "/")
{	$url_generated = substr($get_url_str,0,-1);	}
else
{	$url_generated = $get_url_str;	}


function parse_incoming_path($a)
{

	if(substr($a, 0,1)==="/")
	{
		err("Path has not been given correctly");
	}
	else
	{
		return explode("/", $a);
	}
}
function __autoload($class_name) {
    $class_name = strtolower($class_name);
	$filename = substr($class_name, 3);
    switch(substr($class_name, 0, 2)) {
		case "md":
			$file = _MAP.'models'._PS. $filename._EXT;
			break;
		case "lb":
			$file = _MAP.'libraries'._PS. $filename._EXT;
			break;
		default:	
			$file = _MAP.'controllers'._PS. $filename._EXT;
	}
    if (is_file($file)) //throw new Exception("Given Path Was Not Found");
    include $file;

	//echo $file."<br>\n";
}

//include(_MAP."libraries"._PS."header"._EXT);

//parse and redirect the user to the desired location
if($get_url_str!=NULL && !empty($get_url_str))
{
	$parsed_request = parse_incoming_path($url_generated);

	if(in_array($parsed_request[0], $hidden_controller))
	{
		if(isset($parsed_request[0]))
		{
			$parsed_request[0] = str_replace('-', '_', $parsed_request[0]);
			$controller = $parsed_request[0];

		}

		if(isset($parsed_request[1]))
		{
			$parsed_request[1] = str_replace('-', '_', $parsed_request[1]);
			$func = $parsed_request[1];
		}

		if(isset($parsed_request[2]))
			$arg = $parsed_request[2];

		unset($parsed_request[0]);
		unset($parsed_request[1]);
		unset($parsed_request[2]);
		unset($_GET['path_gen']);
	}
	else
	{
		if(isset($parsed_request[0]))
		{
			$parsed_request[0] = str_replace('-', '_', $parsed_request[0]);
			$func = $parsed_request[0];
		}

		if(isset($parsed_request[1]))
		{
			$arg = $parsed_request[1];
		}

		unset($parsed_request[0]);
		unset($parsed_request[1]);
		unset($_GET['path_gen']);
	}
}

	$class  = "CL_".strtoupper($controller);
	try {
		$cont = new $class;

		if(in_array($func, get_class_methods($cont)))
		{

			$cont->$func($arg);

		}
		else
		{
			if(in_array("error", get_class_methods($cont)))
			{
				$cont->error(404);
			}
			else
			{
				die("App not configured properly");
			}
		}
	} catch(Exception $e){
		err($e->getMessage());
		exit;
	}

?>