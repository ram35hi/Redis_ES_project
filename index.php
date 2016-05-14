<!DOCTYPE HTML>
<html>
 <head>
  <title>Redis_ES</title>
 </head>

 <body >
 <h1 style="text-align: center;">Sample Project | PHP-REDIS-ElasticSearch</h1>
 																<br>
 <nav style="background-color: #ff0000;    color: black;    border: 4px solid #4CAF50;"><li> <a href="search.php">SEARCH</a></li></nav><br>
 <div style="background-color:#ff0000; color:white; padding:20px;">
 <div style="padding-left: 200px">
 <form name="input" action="index.php" method="POST">

  		Key:  		<input type="text" name="key" value="">
  																<br>
 		Message  		<input type="text" name="val" value="">
  																<br>
		<input type="submit">

</form>


																<br>

</div>


<?php 

 	$keyerr = $valerr = "";
	$key = $val = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (empty($_POST["key"])) 
  {
    $keyerr = "Key is required";
  } else 
  {
   
   $key = $_POST["key"];
  }

if (empty($_POST["val"]))
 {
    $valerr = "Value is required";
  } 
  else 
  {
    $val = $_POST["val"];
  }
  			
}

require "predis/autoload.php";
Predis\Autoloader::register();


$vm = array(
    'host'     => '127.0.0.1',
    'port'     => 6379,
    'timeout' => 0.8 
);

$redis = new Predis\Client($vm);
try {
    $redis->ping();
} catch (Exception $e) {
    // LOG that redis is down : $e->getMessage();
}
if(isset($e)) 
{
	echo "no connection";
	 } 
    
    else
 { 
 	//echo "Connection to server sucessfully";
 	echo "<br>"; 
	/* Use Redis */
}

if ($redis->exists($key))	{ 

echo "<div>key exists </div>";	
}
else{
	$redis->set($key, $val );
	echo "Data inserted <br>";
}


require 'vendor/autoload.php';

require_once 'link.php';
if(!empty($_POST)){
	if(isset($_POST['key'],$_POST['val'])){
		$key =$_POST['key'];
		$val =explode(',', $_POST['val']);

		$indexed = $es->index(['index' => 'key',
			'type' => 'resid', 
			'body' => [
			'key'=> $key, 
			'val' => $val
			]
			]);

		//if($indexed){print_r($indexed);}
	}
}

?>
<div style="padding-left: 200px">
<form name="output" action="index.php" method="GET">

  			Key: <input type="text" name="key2" value="">  <br>
  
					<input type="submit">

</form>
</div>
<?php

 $key2err = $val2err = "";
 $key2 = $val2 = "";

if ($_SERVER["REQUEST_METHOD"] == "GET")
 {

	if (empty($_GET["key2"]))
  			 {
    				$key2err = "Key is required";
 			 } else 
 			 		{
   
   						$key2 = $_GET["key2"];
  					}
 }

			$val2 = $redis->get( "$key2" ); 

?>  
 															<br>


<div style="padding-left: 100px"> <?php echo "Message:";  echo $val2; ?></div>
														<br><br><br>
<div style="padding-left: 100px">
Required fields:										<br>

				* <?php echo $keyerr;?></span>
														<br>
				* <?php echo $valerr;?></span>
														<br>
				* <?php echo $key2err;?></span>
														<br></div>
 </body>
</html>

