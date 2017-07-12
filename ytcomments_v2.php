<!DOCTYPE html>
<html>
<head>
	<title>grab youtube comments from videos</title>
</head>
<body>


<form id = "commet" action="" method="POST">

<input type="text" name="url"> ENTER URL<br>
<input type="text" name="apikey">Enter ypur api key
<input type="text" name="Page">NO. Of Pages

<input type="submit" name="button">
</form>

<br>



<?php
    set_time_limit(0);
    $vid_url = $_POST["url"];
    $Apikey = $_POST["apikey"];
    $pages = $_POST["Page"];
    $comment = [];
    $com = array($comment);
    $i = 0;

    $inti ="v=";
    $end_pos =strlen($vid_url);
    $nextPage = "";
    $int_pos = strpos($vid_url ,$inti);
    $int_pos= $int_pos+2;
    //$end_pos = strpos($vid_url ,$end_token);
    $vid_id =substr($vid_url, $int_pos);
echo $vid_id ;
echo "<br>";


    $apiurl = "https://www.googleapis.com/youtube/v3/commentThreads?part=snippet&videoId=$vid_id&key=$Apikey";

 
     echo $apiurl;
 
$json = file_get_contents($apiurl );
$obj = json_decode($json);
//echo $obj ->pageInfo->totalResults ;
$pagetoken = $obj->nextPageToken;
echo $pagetoken;
echo   '<br>';
//var_dump($obj);
echo $json;
//echo $obj ->pageInfo->totalResults;


foreach ($obj->items as $key => $value) {
	
	 $q = $value->snippet->topLevelComment->snippet->textDisplay;
	 $w = $value->snippet->topLevelComment->snippet->authorDisplayName;
	//echo $x;
	
	echo $w."::::". $q;
	echo "<br>";
		$comment = array_push_assoc($comment,$w,$q);


	}

$pagetoken = $obj->nextPageToken;


       

       	while($i < $pages){
          if(!(is_null($pagetoken))){

	      $i++;

		  $apiurl = "https://www.googleapis.com/youtube/v3/commentThreads?pageToken=$pagetoken&part=snippet&videoId=$vid_id&key=$Apikey";


		   $json = file_get_contents($apiurl);

		   $obj = json_decode($json);

		   //echo $obj ->pageInfo->totalResults ;

		   echo   '<br>';
		  
	

	       foreach ($obj->items as $key => $value) {
		
			$q = $value->snippet->topLevelComment->snippet->
			textDisplay;
			//echo $x;

			$w = $value->snippet->topLevelComment->snippet->authorDisplayName;
			 echo $w."::::". $q;
			echo "<br>";
			$comment = array_push_assoc($comment,$w,$q);
		     }


             $pagetoken = $obj->nextPageToken;}
         else{
               break;
   
             }
     }

function array_push_assoc($array, $k, $v){
//$array[''] = $v;
$array[] = ['username' => $k, 'comm' => $v];
return $array;
}

$j = json_encode($comment);
//$file_out =file_get_contents($j);
print_r($j);
file_put_contents("\youtubecomment.json", $j);
//$json_out =fopen("C:\wamp64\www\youtube comments grabber\shm.json", "x");
//fwrite($json_out, $j);
//fclose($json_out);

?>
<a href="<?php echo $j ?>"><button>output comments assoc array</button> </a>

</body>
</html>














































<!--
 {
   "kind": "youtube#commentThread",
   "etag": "\"m2yskBQFythfE4irbTIeOgYYfBU/OaUP12b0JqpQ1-8eDbRb4mq-b5k\"",
   "id": "z12wsj4ynquuip0sb22ae5fbst3sxlbco",
   "snippet": {
    "videoId": "1atPm3Vp92M",
    "topLevelComment": {
     "kind": "youtube#comment",
     "etag": "\"m2yskBQFythfE4irbTIeOgYYfBU/WndI2vkQRNs5oqnAhE-kWrhDTQ0\"",
     "id": "z12wsj4ynquuip0sb22ae5fbst3sxlbco",
     "snippet": {
      "authorDisplayName": "kèhbab",
      "authorProfileImageUrl": "https://yt3.ggpht.com/-8lZsIKk8Omw/AAAAAAAAAAI/AAAAAAAAAAA/jjUCvcvWzMA/s28-c-k-no-mo-rj-c0xffffff/photo.jpg",
      "authorChannelUrl": "http://www.youtube.com/channel/UCwKpbYliPVzoS8wuPi2tVrw",
      "authorChannelId": {
       "value": "UCwKpbYliPVzoS8wuPi2tVrw"
      },
      "videoId": "1atPm3Vp92M",
      "textDisplay": "duuuuude this is not the original song?",
      "textOriginal": "duuuuude this is not the original song?",
      "canRate": false,
      "viewerRating": "none",
      "likeCount": 0,
      "publishedAt": "2017-07-01T21:33:48.000Z",
      "updatedAt": "2017-07-01T21:33:48.000Z"
     }
    },
    "canReply": false,
    "totalReplyCount": 0,
    "isPublic": true
   }
  }


