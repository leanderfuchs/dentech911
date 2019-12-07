<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<link rel="stylesheet" type="text/css" href="views/css/style.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title> order.cfao.fr Admin </title>
</head>

<body>

	<?php 
		echo "<b>Session </b></br>";
		print "<pre>";
			print_r($_SESSION);
		print "</pre>";

		echo "<b>Cookies </b></br>";
		print "<pre>";
			print_r($_COOKIE);
		print "</pre>";
	?>	
	<div class="container">
		<div class="content">
			<?php if (!empty($loggedin) AND $loggedin==TRUE): ?>
				<nav>
					<?php echo $page_menu; ?> 
					<a href="/?logout=true" style="color:red;" target="blank"><?php echo $website_base_url;?></a>
					<a href="?page=connexion_admin&logout=true"><button>Déconnection</button></a>
				</nav>		
			<?php endif ?>		


			<div class="main_content">

				<?php affichage($page_controller_file, $page_view_file); ?>

			</div><!-- main_content -->

		</div><!-- content -->
	</div><!-- container -->

</body>

</html>
