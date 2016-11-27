<?php
//Sai Anirudh Sripati
//10382761
//workshop 5

$output = shell_exec('ps -Ao comm,pmem --sort=-pmem | head -n 6| tail -n 5');

$lines=explode("\n", $output);
$name=array();
$mem=array();
foreach($lines as $line){

$cols=preg_split('/\s+/',$line);
if(sizeof($cols)>1){

array_push($name,$cols[0]);
array_push($mem,$cols[1]);
}
}

$a_name=$name[0];
$b_name=$name[1];
$c_name=$name[2];
$d_name=$name[3];
$e_name=$name[4];

$max=$mem[0]+$mem[1]+$mem[2]+$mem[3]+$mem[4];
$values_deg = array("a"=>$mem[0], "b"=>$mem[1], "c"=>$mem[2],"d"=>$mem[3],"e"=>$mem[4]);
$max=$values_deg["a"]+$values_deg["b"]+$values_deg["c"]+$values_deg["d"]+$values_deg["e"];
$values_deg["a"]=($values_deg["a"]*360)/$max;
$values_deg["b"]=($values_deg["b"]*360)/$max;
$values_deg["c"]=($values_deg["c"]*360)/$max;
$values_deg["d"]=($values_deg["d"]*360)/$max;
$values_deg["e"]=($values_deg["e"]*360)/$max;

$image = imagecreatetruecolor(800, 960);
$trans = imagecolorallocate($image, 0, 0, 0);
imagecolortransparent($image, $trans);

//Allocating colours
$gray     = imagecolorallocate($image, 0xC0, 0xC0, 0xC0);
$navy     = imagecolorallocate($image, 0x00, 0x00, 0x80);
$red      = imagecolorallocate($image, 0xFF, 0x00, 0x00);
$yellow      = imagecolorallocate($image, 255,255, 0);
$green      = imagecolorallocate($image, 51, 255, 51);
$orange      = imagecolorallocate($image, 102, 255,255);
//Border
imagerectangle($image, 50, 50, 750, 700, $red);
//Title
imagestring ( $image , 10 , 350 , 95 , "RAM USAGE", $red );
//Indicators
imagefilledrectangle($image, 500, 215, 525, 240, $red);
imagestring ( $image , 10 , 535 , 217 , $a_name."(".$mem[0].")", $red );
imagefilledrectangle($image, 500, 285, 525, 310, $navy);
imagestring ( $image , 10 , 535 , 295 , $b_name."(".$mem[1].")", $red );
imagefilledrectangle($image, 500, 345, 525, 370, $gray);
imagestring ( $image , 10 , 535 , 355 , $c_name."(".$mem[2].")", $red );
imagefilledrectangle($image, 500, 415, 525, 440, $yellow);
imagestring ( $image , 10 , 535 , 425 , $d_name."(".$mem[3].")", $red );
imagefilledrectangle($image, 500, 485, 525, 510, $green);
imagestring ( $image , 10 , 535 , 495 , $e_name."(".$mem[4].")", $red );

//Generating Pie chart
imagefilledarc($image, 250, 350, 350, 350, 0, $values_deg["e"], $green, IMG_ARC_PIE);
imagefilledarc($image, 250, 350, 350, 350, $values_deg["e"],$values_deg["e"]+$values_deg["d"] , $yellow, IMG_ARC_PIE);
imagefilledarc($image, 250, 350, 350, 350, $values_deg["e"]+$values_deg["d"], $values_deg["e"]+$values_deg["d"]+$values_deg["c"], $gray, IMG_ARC_PIE);
imagefilledarc($image, 250, 350, 350, 350,$values_deg["e"]+$values_deg["d"]+$values_deg["c"], $values_deg["e"]+$values_deg["d"]+$values_deg["c"]+$values_deg["b"], $navy, IMG_ARC_PIE);
imagefilledarc($image, 250, 350, 350, 350, $values_deg["e"]+$values_deg["d"]+$values_deg["c"]+$values_deg["b"], $values_deg["e"]+$values_deg["d"]+$values_deg["c"]+$values_deg["b"]+$values_deg["a"], $red, IMG_ARC_PIE);

// flush image
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
