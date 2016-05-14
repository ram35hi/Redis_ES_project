<?php  
require_once 'link.php';

if(isset($_GET['q'])) {
	$q = $_GET['q'];

    require 'vendor/autoload.php';
$es = new Elasticsearch\Client(['hosts' => ['localhost:9200'] ]);
	$query = $es->search([
		'body' => [
		'query' => [
		'bool'=> [
		'should'=> [
			'match' => ['key'=> $q]
		]
		]
		]
		]

	]);

	if($query['hits']['total'] >=1){
		$results = $query['hits']['hits'];
	}
	else{
		echo "<h2 style='text-align: center; color: #ff0000;'>Data not FOUND</h2>";
		echo " ";
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Search |ES</title>
</head>
<body>

<h1 style="text-align: center;">Sample Project | PHP-REDIS-ElasticSearch</h1>
 																<br>
 <nav style="background-color: #ff0000;    color: black;    border: 4px solid #4CAF50;"><li> <a href="index.php">HOME</a></li></nav><br>
 <div style="background-color:#ff0000; color:white; padding:20px;">
 <div style="padding-left: 200px">
<form action="search.php" method="get" autocomplete="off">

<label> search: 
<input type="text" name="q">
</label>

<input type="submit" value="search">
</form>

<?php 

if(isset($results)){
	foreach ($results as $r)
	 {
		?>
		<div class="result">
			key:<a href="#<?php echo $r['_id']; ?>"><?php echo $r['_source']['key']; ?></a>
			<br><div class="val"> value:<?php echo implode(', ',$r['_source']['val']); ?>
			</div>
		</div>

		<?php
	}
}
?>

</body>
</html>