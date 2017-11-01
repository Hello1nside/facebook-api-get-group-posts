<?php

$appID = '1946341178968517';
$appSecret = '15a35e4252ff93df42fe1d2a2c55b09d';
 
$accessToken = $appID . '|' . $appSecret;
 
//The ID of the Facebook page in question.
$id = 'kyiv.group';
 
$url = "https://graph.facebook.com/$id/feed?access_token=$accessToken&limit=100&fields=attachments";
 
//Make the API call
$result = file_get_contents($url);

//Decode the JSON result.
$decoded = json_decode($result, true);

//Dump it out onto the page so that we can take a look at the structure of the data.
//var_dump($decoded);
?>
<!-- ******************** HTML ******************* -->
<!DOCTYPE html>
<html>
<head>
	<title>Facebook - feed</title>
	<style type="text/css">
		body {
			background-color: #ccc;
		}
		#block-post {
			border: 2px solid gray;
			padding: 0 10px;
			width: 50%;
			margin-bottom: 10px;
			background-color: #fff;
		}
		#post-date {
			background-color: #000;
			border-radius: 5px;
			color: #fff;
			padding: 1px 5px;
			width: 28%;
		}
		#block-msg {
			padding: 5px;
			border: 1px solid silver;
		}
	</style>
</head>
<body>

<?php
	$msg = '';
	/*
	for($i=0; $i<2; $i++) {
		
		echo "
		<div id='block-post'>
			<p id='post-date'>".$decoded['data'][$i]['created_time']."</p>";
					
			if(!empty($decoded['data'][$i]['message']))
				$msg = $decoded['data'][$i]['message'];
			else 
				$msg = $decoded['data'][$i]['story'];

			//$url_object = "https://graph.facebook.com/".$decoded['data'][$i]['id']."?fields=object_id";
			//$result_object = file_get_contents($url_object);
		//	$decoded_object = json_decode($result_object, true);
			//var_dump($result_object);
			//$object_id = 0;

		echo "<p id='block-msg'>".to_link($msg)."</p>
			<p><a href='https://facebook.com/".$decoded['data'][$i]['id']."'>View in Facebook</a></p>
		</div>";
	}
	*/
	
	for ($i = 0; $i < 100; $i++) { 
		//echo $decoded['data'][$i]['attachments']['data']['0']['description'];
		///echo "<img src=".$decoded['data'][$i]['attachments']['data']['0']['media']['image']['src']."/>";	
		echo '<img src="'.$decoded['data'][$i]['attachments']['data'][0]['media']['image']['src'].'"><br>';
		if(!empty($decoded['data'][$i]['attachments']['data'][0]['description'])){
			echo $decoded['data'][$i]['attachments']['data'][0]['description'].'<br><hr>';	
		} else {
			echo '<hr>';
		}
	}


	

	echo '<pre>';
	//var_dump($decoded);
	echo '</pre>';

//	var_dump($decoded);
	

# empty hashtag to hashtag facebook
function hashtag($text) {
	$text= preg_replace("/\#(\w+)/", '<a href="https://facebook.com/search?q=$1" target="_blank">#$1</a>',$text);
	return $text;
}

# urls in text to link 
function to_link($text){
	$text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" target='_blank'>$3</a>", $text);
	$text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" target='_blank'>$3</a>", $text);
	$text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\" target='_blank'>$2@$3</a>", $text);

	return($text);
}

?>

</body>
</html>


