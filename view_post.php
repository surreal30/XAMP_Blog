<?php

require_once "lib/common.php";

if(isset($_GET['post_id']))
{
	$id = $_GET['post_id'];
}
else
{
	$id = 0;
}

$pdo = getPDO();

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

// Swap carriage return for paragraph breaks
$bodyText = htmlEscape($row['body']);
$paraText = str_replace("\n", "</p><p>", $bodyText);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		A blog Application | <?php echo htmlEscape($row['title']); ?> 
	</title>
</head>
<body>
    <?php require_once "templates/title.php"; ?>
	

	<h2>
		<?php echo htmlEscape($row['title']); ?>
	</h2>

	<div>
		<?php echo convertSqlDate($row['created_at']); ?>
	</div>

	<p>
		<?php echo $paraText; ?>
	</p>

</body>
</html>