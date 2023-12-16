<?php

$root = __DIR__;
$database = $root . '/data/data.sqlite';
$dsn = 'sqlite:' . $database;

if(isset($_GET['post_id']))
{
	$id = $_GET['post_id'];
}
else
{
	$id = 0;
}

$pdo = new PDO($dsn);

$sql = "SELECT 
  title, 
  created_at, 
  body 
FROM 
  post 
WHERE 
  id = ?
";

$query = $pdo->prepare($sql);
if($query === false)
{
	throw new Exception("Error while preparing the query");
}

$result = $query->execute([$id]);
if($result === false)
{
	throw new Exception("Error while executing the query");
}

$row = $query->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		A blog Application | <?php echo htmlspecialchars($row['title'], ENT_HTML5, "UTF-8"); ?>
	</title>
</head>
<body>
    <?php require_once "templates/title.php"; ?>
	

	<h2>
		<?php echo htmlspecialchars($row['title'], ENT_HTML5, "UTF-8"); ?>
	</h2>

	<div>
		<?php echo $row['created_at']; ?>
	</div>

	<p>
		<?php echo $row['body']; ?>
	</p>

</body>
</html>