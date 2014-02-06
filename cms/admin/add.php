<?php
	session_start();
	include_once('../includes/connection.php');

	if(isset($_SESSION['logged_in']))
	{
		// Display Add Page

		if(isset($_POST['tittle'], $_POST['content']))
		{
			$tittle = $_POST['tittle'];
			$content = nl2br($_POST['content']);

			if(empty($tittle) or empty($content))
			{
				$error = 'Favor llenar todos los campos';
			}
			else
			{
				$query = $pdo -> prepare('INSERT INTO articles(article_tittle, article_content, article_timestamp) VALUES (?, ?, ?)');

				$query -> bindValue(1, $tittle);
				$query -> bindValue(2, $content);
				$query -> bindValue(3, time());

				$query -> execute();

				header('Location: index.php');
			}
		}

		?>

		<html lang = "es"> 
			<head>
				<title>TallerUno</title>
				<link rel="stylesheet" href="../assests/style.css"/>
			</head>

			<body>
				<div class= "container">
					<a href="index.php" id="logo">CMS</a>
					<br />

					<h4>Agregar Articulo</h4>

					<?php if(isset($error))
					{ ?>
						<small style = "color: #aa0000;"><?php echo $error; ?></small>
						<br /><br />
					<?php } ?>

					<form action = "add.php" method = "post" autocomplete = "off">
						<input type = "text" name = "tittle" placeholder = "Titulo"/><br /><br />
						<textarea rows = "15" cols = "50" placeholder = "Contenido" name = "content"></textarea><br /><br />
						<input type = "submit" value = "Agregar Articulo"/>
					</form>

				</div>
			</body>
		</html>

		<?php
	}
	else
	{
		header('Location: index.php');
	}
?>