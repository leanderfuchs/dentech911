<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
  	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="views/css/style.css"/>
	<link rel="stylesheet" href="views/css/jquery-ui.css" />
	<link rel="stylesheet" href="views/css/cupertino/jquery-ui-custom.css" />
	<link rel="stylesheet" href="views/css/cupertino/jquery-ui-custom.css" />
	<script src="views/js/jquery.js"></script>
	<script src="views/js/jquery-ui.js"></script>
	<script src="views/js/datepicker.js"></script>

	<link href="views/css/horizontal_selector.css" rel="stylesheet">
	<script src="views/js/horizontal_selector.js"></script>


	<title><?php echo $page_title;?> - DenTech911</title>
</head>
<body>
	<div class="alert alert-info" role="alert">
		Site en cours de développement. Il est utilisable mais des mises à jour régulières sont faites
	</div>
	<div id="wrap">
		<div id="main">
			<div class="framed frame-main">
			<!-- Si la page est pas pour imprimer, montrer le contenu du hearder. sinon le masquer. -->
			<?php if (isset($_GET['page']) && $_GET['page']!='print_order_detail'): ?>
			<!-- HEADER -->
			<header>
				<div class="header">
					<div class="header_container">
						<div id="misc-top">
							<div id="sess-status">
								<span class="badge badge-pill badge-dark"><?if ($_SESSION){?>Fichiers transferable: <?echo $_SESSION['balance'];}?></span>
							<button type="button" class="btn">
								<?php if (isset($_SESSION['Auth']) AND $_SESSION['Auth']==1) {
									echo '<a href="?page=user_profil">Mon Compte</a>';
								}?>
							</button>
							<button type="button" class="btn">
								<?php if (isset($_SESSION['Auth']) AND $_SESSION['Auth']==1) {
									echo '<a href="?page=user_contacts">Mes contacts</a>';
								}?>
							</button>
							<button type="button" class="btn">
								<?php if (isset($_SESSION['Auth']) AND $_SESSION['Auth']==1) {
									echo '<a href="?logout=log_me_out">Déconnection</a>';
								}?>
							</button>
							</div> <!-- sess-status -->
						</div> <!-- misc-top -->

						<? if(!isset($_SESSION['Auth'])){ ?>
							<div id="pagetitle">
								<a href="?page=login"><img class="logo" src="views/images/dentech911-logo-320px.svg" alt="" /></a><br/>
							</div> <!-- pagelogo -->
						<?}?>

						<? if(isset($_SESSION['Auth'])){ ?>
							<div id="pagetitle">
								<a href="?page=order_list"><img class="logo" src="views/images/dentech911-logo-320px.svg" alt="" /></a><br/>
							</div> <!-- pagelogo -->
						<?}?>

						<!-- SLOGAN -->
						<div class="container p-4">
							<div class="lead"><?php echo $page_slogan; ?> </div><!-- slogan -->
						</div>

						<!-- NAVBAR -->
						<?if (isset($_SESSION['user_id'])){?>
						<ul class="nav nav-pills nav-fill">
							<?php foreach($page_menu_header as $value){
								$active='';
								if($value['link'] == $_GET['page']) $active='active';
							?>
								<?echo '<li class="nav-item"> 
									<a class="nav-link '.$active.'" href="?page='.$value['link'].'">'.$value['title']?></a>
								</li>
							<?}?>
						</ul>
						<?}?>

					</div> <!-- header_container -->
				</div> <!-- header -->
			</header>
			<?php endif ?> <!-- if print page -->
				<h1 class="mt-3"><? if (!empty($page_title)) echo $page_title;?></h1>
				<?php affichage($page_controller_file, $page_view_file);?>
				<p><?php if(!empty($page_content)) echo $page_content;?></p>
			</div>
		</div>
	</div>

	<div class="footer"> 

		<div class="footer_container"> 
			<ul class="nav justify-content-center">
			<?php foreach($page_menu_footer as $value){?>
				<li class="nav-item"><?echo '<a class="nav-link" target="blanc" href="'.$value['link'].'"> '.$value['title']?> </a></li>
			<?}?>
			</ul>
		</div> <!-- footer_container -->

	</div> <!-- footer -->
	<? //if(isset($_SESSION)) print_r($_SESSION);?>
</body>

</html>
