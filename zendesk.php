<?php
define("ZDAPIKEY", "");//API Key
define("ZDUSER", "");//email@yourdomain.com
define("ZDURL", "");//https://yourdomain.zendesk.com/api/v2

function curlWrap($url, $json)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
	curl_setopt($ch, CURLOPT_URL, ZDURL.$url);
	curl_setopt($ch, CURLOPT_USERPWD, ZDUSER."/token:".ZDAPIKEY);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$output = curl_exec($ch);
	curl_close($ch);
	$decoded = json_decode($output);
	return $decoded;
}

if(isset($_POST))
{
	foreach($_POST as $key => $value)
	{
		if(preg_match('/^z_/i',$key))
		{
			$arr[strip_tags($key)] = strip_tags($value);
		}
	}

	//Don't Remove the following two Line Breaks, it adds line breaks to the textarea.
	$arr['z_description'] .= '


	Submitted From: ' . $_POST['z_page'];
	//Finish Don't Remove

	$create = json_encode(
		array(
			'ticket' => array(
				'subject' => substr($arr['z_description'], 0, 50),
				'comment' => array(
					"body" => $arr['z_description']
				), 
				'requester' => array(
					'name' => $arr['z_name'], 
					'email' => $arr['z_requester']
				),
				'tags' => json_encode(array($arr['z_tag']))
			),  
		), 
	JSON_FORCE_OBJECT);
	$return = curlWrap("/tickets.json", $create);
}
?>