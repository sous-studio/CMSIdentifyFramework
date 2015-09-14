<?php

function header_fetch($url, $check_against)
{
	$data = get_url($url, true);
	$headers = http_parse_headers($data);

	foreach($headers as $key => $value):
		if($key == $check_against->header_option)
			echo $key.': '.$value;
	endforeach;
}

