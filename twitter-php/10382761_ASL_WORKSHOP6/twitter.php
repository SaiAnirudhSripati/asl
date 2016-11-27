<?php
#Sai Anirudh Sripati
#10382761
#Workshop 6
#The following program uses twitteroauth library which is zipped with the source file.

error_reporting(0);

$input="";
$cmnd=$argv[1];
$keyword=$argv[2];
$count=$argv[3];

if(strlen(trim($cmnd))==0 || strlen(trim($keyword))==0 || strlen(trim($count))==0){

echo "Please give a valid input\nUsage:php twitter.php show/search username/keyword number\n";

}
else{
if(strtolower(trim($cmnd))=="show"){
$input="Showing\n";
getOutput($cmnd,$keyword,$count);

}elseif(strtolower(trim($cmnd))=="search"){
getOutput($cmnd,$keyword,$count);

}else{

echo "Please give a valid input\nUsage:php twitter.php show/search username/keyword number\n";

}
}
function getOutput($cmnd,$keyword,$count){
session_start();
require_once("twitteroauth/twitteroauth/twitteroauth.php"); //Path to twitteroauth library
 

#API Key's and Access Tokens----------------------------------------------------------------
$apIkey = ""; 	#API Key
$apIsecretkey = "";	#Api Secret Key
$accesstoken = "";	#Access Token
$accesssTokenSecret = "";	#Acess Token Secret
#-------------------------------------------------------------------------------------------
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken($apIkey, $apIsecretkey, $apItoken, $accessTokensecret);
 

#Get recent tweets
if($cmnd=="show"){
$response= $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$keyword."&count=".$count);
$response=json_encode($response);
$response=json_decode($response,true);

if (strlen($response[0]['user']['name'])>1){
echo "Name: ".$response[0]['user']['name']."\n";
echo "Screen name: ".$response[0]['user']['screen_name']."\n";
}else{
echo "Username not found\n";
}

foreach($response as $tweets){

if (sizeof($tweets)>1){
echo  "--------------------------------------------------------\n";
     echo  "Tweet: ".$tweets['text']."\n";
     echo "Tweeted at: ".$tweets['user']['created_at']."\n";

}

}
}#Search Twitter 
else{
$response= $connection->get("https://api.twitter.com/1.1/search/tweets.json?q=%23".$keyword."&result_type=mixed&count=".$count);
$response=json_encode($response);
$response=json_decode($response,true);
$statuses=$response['statuses'];
foreach($statuses as $status){
echo  "--------------------------------------------------------\n";
echo "Tweet: ".$status['text']."\n";
echo "Tweeted at: ".$status['created_at']."\n";
echo "Tweeted by: ".$status['user']['name']."\n";

}





} 

}
?>