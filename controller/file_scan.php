<?php

function file_scan($url, $check_against)
{
	global $versions;
	$data = get_url($url."/".$check_against->file_name);
	switch($check_against->type)
	{
		case "xpath";
			$body = new DOMDocument();
			@$body->loadHTML($data);
			$xpath = new DOMXPath($body);
			//libxml_use_internal_errors(true);

			$found = trim($xpath->evaluate("string(".$check_against->value.")"));

			if(!empty($found)){
				echo $check_against->message.$found;
				if( isset($versions->{$check_against->software}) || property_exists($versions, $check_against->software) )
					echo ' Latest: '.$versions->{$check_against->software};
			}
			break;
		case "regex":
			if(preg_match_all($check_against->value, $data, $matches))
				echo $check_against->message;
			break;
		case "query":
			break;
		case "xml":
			$body = new DOMDocument();
			@$body->loadXML($data);
			$xpath = new DOMXPath($body);
			//libxml_use_internal_errors(true);

			$found = trim($xpath->evaluate("string(".$check_against->value.")"));

			if(!empty($found)){
				echo $check_against->message.$found;
				if( isset($versions->{$check_against->software}) || property_exists($versions, $check_against->software) )
					echo ' Latest: '.$versions->{$check_against->software};
			}
			break;
		default:
			break;
	}
}