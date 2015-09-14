<?php

function get_url($url, $nobody = FALSE)
{
	$ch = curl_init();
	$options = array(
		CURLOPT_URL => $url,
		CURLOPT_HEADER => false,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13'
	);
	if($nobody == TRUE){
		$options[CURLOPT_NOBODY] = TRUE;
		$options[CURLOPT_HEADER] = true;
	}
	curl_setopt_array($ch, $options);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

if( !function_exists( 'http_parse_headers' ) ) {
	function http_parse_headers($header)
	{
    	$retVal = array();
	    $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
    	foreach( $fields as $field ) {
        	if( preg_match('/([^:]+): (.+)/m', $field, $match) ) {
            	$match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower(trim($match[1])));
	            if( isset($retVal[$match[1]]) ) {
    	            $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
        	    } else {
            	    $retVal[$match[1]] = trim($match[2]);
	            }
    	    }
    	}
    	return $retVal;
	}   
}