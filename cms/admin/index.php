<?php
	session_start();
	include_once('../includes/connection.php');

	if(isset($_SESSION['logged_in']))
	{
		// Display index

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

						<ol>
							<li><a href = "add.php">Agregar Articulo</a></li>
							<li><a href="delete.php">Eliminar Articulo</a></li>
							<li><a href="logout.php">Logout</a></li>
						</ol>

					</div>
				</body>
			</html>

		<?php
	}
	else
	{
		// Display Loggin

		if(isset($_POST['username'], $_POST['password']))
		{
			$username = $_POST['username'];
			$password = md5($_POST['password']);

			if(empty($username) or empty($password))
			{
				$error = 'Favor llenar todos los campos';
			}
			else
			{
				$query = $pdo -> prepare("SELECT * FROM users WHERE user_name = ? AND user_password = ?");

				$query -> bindValue(1, $username);
				$query -> bindValue(2, $password);

				$query -> execute();

				$num = $query -> rowCount();

				if($num == 1)
				{
					// User entered correct details

					$_SESSION['logged_in'] = true;
					header('Location: index.php');
					exit();
				}
				else
				{
					// User entered false details

					$error = 'Nombre de Usuario o Password Incorrecto';
				}
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

					<br /><br />

					<?php if(isset($error))
					{ ?>
						<small style = "color: #aa0000;"><?php echo $error; ?></small>
						<br /><br />
				<?php } ?>

				<form action = "index.php" method = "post" autocomplete = "off">
					<input type = "text" name = "username" placeholder = "Username"/>
					<input type = "password" name = "password" placeholder = "Password"/>
					<input type = "submit" value = "Login"/>
				</form>
				</div>
			</body>
		</html>
		<?php
	}
?>