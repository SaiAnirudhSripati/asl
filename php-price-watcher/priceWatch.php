
<?php
//Name: Sai Anirudh Sripati
//ID:10382761
//ASL Major Assignment

error_reporting(0);
require 'simple_html_dom.php';
ini_set( 'default_socket_timeout', 120 );
set_time_limit( 120 );
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "priceWatch1";
$tot=0;
// Create connection

$conn = new mysqli($servername,$username,$password,$dbname);
// Check connection
if ($conn->connect_error) {
   // die("Connection failed: " . $conn->connect_error);
 
$conn = new mysqli($servername,$username,$password);

// Create database
$sql = "CREATE DATABASE priceWatch1";
if ($conn->query($sql) === TRUE) {
echo 'Detected first run, creating database'."\n";
} else {
   echo "Error creating database: ".$conn->error;
}
}
 
$conn = new mysqli($servername,$username,$password,$dbname);

$sql="CREATE TABLE IF NOT EXISTS games2(id INT(5)  ,name VARCHAR(250),price VARCHAR(50),site VARCHAR(75),date TIMESTAMP)";
if ($conn->query($sql) === TRUE) {
   // echo "Table created successfully";
} else {
   echo "Error creating table: " . $conn->error;
}
function insert_products($data){
global $conn;
global $tot;
$name=$data['name'];
$name=str_replace("'","\'",$name);
$price=$data['price'];
$site=$data['site'];
$date = date('Y-m-d H:i:s');
$id='';
$sql ="select id from games2 where name='$name';";
$result=$conn->query($sql);

if ($result->num_rows>0) {
   // echo "fetched id ";
	$row=$result->fetch_assoc();
	$id=$row['id'];
	$sql ="INSERT INTO games2(id,name,price,site,date) VALUES('$id','$name','$price','$site','$date')";

	if ($conn->query($sql) === TRUE) {
		//			echo "updated";
	} else {
					echo "cannot update data" . $conn->error;
	}
} else {
	$sql="SELECT * from games2";
	$result=$conn->query($sql);
	$count=$result->num_rows;
	$count=$count+1;
//	echo 'Name:'.$name.'<br>';
	
  	$sql ="INSERT INTO games2(id,name,price,site,date) VALUES('$count','$name','$price','$site','$date')";

	if ($conn->query($sql) === TRUE) {
	//				echo "inserted";
	} else {
		//			echo "cannot insert data" . $conn->error;
	}
}

$tot=$tot+1;

}
function search_products($keyword){
global $conn;
$sql ="select id as ID,name as Name,site as Store,price as Price from games2 WHERE name LIKE '%$keyword%';";
$id='';
$result=$conn->query($sql);
if ($result->num_rows>0) {
	echo '-------------------------------------------------------------------------------------------------------------------------------------------'."\n";
	echo '|#'."\t";echo '|Name'."\t\t\t\t\t\t\t\t\t\t\t";echo '|Store'."\t\t\t";echo '|Price           '."\n";
	echo '-------------------------------------------------------------------------------------------------------------------------------------------'."\n";
   while ($row = mysqli_fetch_assoc($result)) {
    echo $row["ID"]."\t";
    If(strlen($row["Name"])<80){

    echo str_pad($row["Name"],80," ");	
}else{
echo substr($row["Name"],0,80);
}
echo "\t";echo $row["Store"]."\t";echo $row["Price"]."\n";

	}
	} else {
    echo "No products found" . $conn->error;
}

}
function history_products($id){
global $conn;
$sql="SELECT name from games2 where id='$id' and site='www.ozgameshop.com';";

$result=$conn->query($sql);
$name='';
if ($result->num_rows>0) {
   while ($row = mysqli_fetch_assoc($result)) {
    $name= $row["name"];
	
	}
	echo 'Showing history for '.$name.' from www.ozgameshop.com'."\n";
	echo '-------------------------------------------------------------------------------------------------------------------------------------------'."\n";
	echo '|Date'."\t\t\t";echo '|Time'."\t\t";echo '|Price           '."\n";
	echo '-------------------------------------------------------------------------------------------------------------------------------------------'."\n";
	$sql="SELECT date as Date,price as Price from games2 where id='$id' and site='www.ozgameshop.com';";
$result=$conn->query($sql);
$name='';
if ($result->num_rows>0) {
   while ($row = mysqli_fetch_assoc($result)) {
    $splitDate= explode(" ",$row["Date"]);
	
	echo $splitDate[0]."\t\t";echo $splitDate[1]."\t";echo $row['Price']."\n";
	
	}
	}
	} else {
    echo 'No products found under www.ozgameshop.com'."\n" . $conn->error;
}
$sql="SELECT name from games2 where id='$id' and site='www.ebgames.com.au';";
$result=$conn->query($sql);
$name='';
if ($result->num_rows>0) {
   while ($row = mysqli_fetch_assoc($result)) {
    $name= $row["name"];
	
	}
	echo 'Showing history for '.$name.' from www.ebgames.com'."\n";
	echo '-------------------------------------------------------------------------------------------------------------------------------------------'."\n";
	echo '|Date'."\t\t\t";echo '|Time'."\t\t";echo '|Price           '."\n";
	echo '-------------------------------------------------------------------------------------------------------------------------------------------'."\n";
	$sql="SELECT date as Date,price as Price from games2 where id='$id' and site='www.ebgames.com.au';";
$result=$conn->query($sql);
$name='';
if ($result->num_rows>0) {
   while ($row = mysqli_fetch_assoc($result)) {
    $splitDate= explode(" ",$row["Date"]);
		echo $splitDate[0]."\t\t";echo $splitDate[1]."\t";echo $row['Price']."\n";
	}
	}
	} else {
    echo 'No products found under www.ebgames.com'."\n" ;//. $conn->error;
}

}
$pages=0;
$pages2=0;
$keyWord=trim(preg_replace('/\s+/','+', 'call    of duty'));
$keyWord2=trim(preg_replace('/\s+/','%20','call of duty'));
////echo $keyWord2;
function scrapeNextpage($page){

$data=array("date"=>"", "time"=>"", "site"=>"www.ozgameshop.com", "name"=>"","price"=>"" );

global $keyWord;
//echo 'Scraping page'.$page.'<br>';
$max=0;
$html='';
if($page==1){
$html = file_get_html('http://www.ozgameshop.com/ps4-games/sort-most-popular/100-per-page');
}
else
{
$html = file_get_html('http://www.ozgameshop.com/ps4-games/sort-most-popular/100-per-page/page-'.$page);
}
foreach($html->find('span') as $page){
	   
	   if($page->plaintext>$max){
			global $pages;
				$max=$page->plaintext;
				//if($max=0){
				$pages=$max;
				
				
		}
//		//echo $pages.'<br>';
	   }
	 
	   
	   
foreach($html->find('div') as $element){ 

		if($element->class=="productcount"){
			//echo $element->plaintext.'<br>';
	   
		}
		if ($element->class=='product4text'){
		
		//	echo 'Name-'.$element->plaintext.'<br>';
			$data["name"]=$element->plaintext;
			$productFound=true;
		}

		if ($element->class=='product_price'){
			
			//echo 'price-'.$element->plaintext.'<br>';
			$data["price"]=$element->plaintext;
		//	echo $data["name"].'<br>';
		//	echo $data["price"].'<br>';
			insert_products($data);
				
		}else if ($element->class=='product_price now_price'){
			
			//echo 'price-'.$element->plaintext.'<br>';
			$data["price"]=str_replace("Now","",$element->plaintext);
			//echo $data["name"].'<br>';
			//echo $data["price"].'<br>';
			insert_products($data);
				
		}
			

		
	   
}

}
function scrapeNextpageSite2($page){

$data=array("date"=>"", "time"=>"", "site"=>"www.ebgames.com.au", "name"=>"","price"=>"" );
global $keyWord2;
//echo 'Scraping page'.$page.'<br>';
$max=0;
$html='';
if($page==1){
$html = file_get_html('https://ebgames.com.au/ps4/any/any/any/any?availability=onlinestock');
}
else
{
$html = file_get_html('https://ebgames.com.au/ps4/any?availability=onlinestock&page='.$page);
}

foreach($html->find('div') as $element){ 
if($element->class=='title'){
////echo $element->plaintext.'<br>';
$data["name"]=$element->plaintext;

}
if($element->class=='price'){
// $element->plaintext.'<br>';
$data["price"]=$element->plaintext;
//echo $data["name"].'<br>';
//echo $data["price"].'<br>';
insert_products($data);
				
}
if($element->class=='three-col auto cf'){
global $pages2;
foreach($element->find('a') as $element){
if($element->plaintext>$pages2){

$pages2=intval($element->plaintext);

}
}
////echo 'max pages'.$pages2.'<br>';
}

}

}

$cmnd=$argv[1];
$param=$argv[2];
if ($cmnd=="search" && $param!=''){
search_products($param );
}else if ($cmnd=="history" && $param!=''){
$param=(int)$param;
if(is_int($param)){
history_products($param);
}else if($param<=0){
echo 'ID should be greater than 0'."\n";
}else{
echo "ID must be integer"."\n";

}
}else if($cmnd=="update"){
echo ' Updating prices from Site A: www.ozgameshop.com'."\n";
echo '******Note:This script scrapes all the games from all the pages,the default timeout is set to 120 secs***********'."\n";
scrapeNextpage(1);

if($pages>1){

$page=1;
for ($i=1+$page;$i<=$pages;$i++){
////echo 'fetching next page';
scrapeNextpage($i);
$page=$page+1;
}
echo 'Site A:www.ozgameshop.com update complete , '.$tot .' prices inserted';
$tot=0;
}
//echo 'Scraping site 2:'.'<br>';
echo ' Updating prices from Site B: www.ebgames.com'."\n";
echo '******Note:This script scrapes all the games from all the pages,the default timeout is set to 120 secs***********'."\n";
scrapeNextpageSite2(1);

//echo 'Number of pages to be scraped:'.$pages2.'<br>';
if($pages2>1){

$page=1;
for ($i=1+$page;$i<=$pages2;$i++){
////echo 'fetching next page'.$i.'<br>';
scrapeNextpageSite2($i);
$page=$page+1;
}
echo 'Site B:www.ebgames.com update complete , '.$tot .' prices inserted';
$tot=0;
}

}else{
echo "Invalid command"."\n";

}
?>
