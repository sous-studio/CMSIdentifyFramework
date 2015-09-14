<?php

if(file_exists("cmsidentify_functions.php"))
	require("cmsidentify_functions.php");
else
	die("cmsidentify_functions.php missing\n");

$config_dir = './config';
$controllers_dir = './controller';

$configs = array_diff(scandir($config_dir), array('..', '.'));
$controllers = array_diff(scandir($controllers_dir), array('..', '.'));
$active_controllers = array();
$filters = array();
$controllers_counter = 0;
$versions = json_decode(file_get_contents('versions.json'));

if ($argc < 2) die('Usage: php '.$argv[0].' <site-base>'."\n");

$url = $argv[1];

echo 'Initializing controllers...';

foreach($controllers as $controller):
	$active_controllers[] = $controller;
	if(file_exists($controllers_dir.'/'.$controller))
		{
			$controllers_counter++;
			include($controllers_dir.'/'.$controller);
		}
endforeach;

echo 'Done.'."\n".'Initializing rules...';

foreach($configs as $config):
	$file = file_get_contents($config_dir.'/'.$config);
	$data = json_decode($file);

	if(is_object($data))
		if(in_array($data->controller.".php", $active_controllers))
			$filters[] = $data;
endforeach;

/*
 * Preload all required URLs
 *

echo 'Done'."\n".'Gathering URL list...';

foreach($active_controllers as $active_controller):
	$controller_name = preg_replace('/\\.[^.\\s]{3}$/', '', $active_controller);
	foreach($filters as $filter):
		if($filter['controller'] == $controller_name)
		{
			$controller_name($url, $filter);
			echo '.';
		}
	endforeach;
endforeach; */

echo 'Done'."\n".'Processing rules...'."\n\n";

foreach($active_controllers as $active_controller):
	$controller_name = preg_replace('/\\.[^.\\s]{3}$/', '', $active_controller);
	foreach($filters as $filter):
		if($filter->controller == $controller_name)
		{
			$controller_name($url, $filter);
			echo "\n";
		}
	endforeach;
endforeach;

echo "\n".'Done.'."\n";
