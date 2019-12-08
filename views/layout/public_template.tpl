<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="views/css/style.css"/>
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,300,400,600" rel="stylesheet" type="text/css" />
	<title><?php echo $page_title;?> - DenTech911</title>
 		<link rel="stylesheet" href="views/css/jquery-ui.css" />
 		<link rel="stylesheet" href="views/css/cupertino/jquery-ui-custom.css" />
 		<link rel="stylesheet" href="views/css/cupertino/jquery-ui-custom.css" />
		<script src="views/js/jquery.js"></script>
		<script src="views/js/jquery-ui.js"></script>
		<script src="views/js/datepicker.js"></script>


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
								<?php if (isset($_SESSION['Auth']) AND $_SESSION['Auth']==1) {
									echo ' | <a href="?logout=log_me_out">Déconnection</a>';
								}?>
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
						<div class="heading"><?php //echo $page_slogan; ?> </div><!-- slogan -->

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
				<?php affichage($page_controller_file, $page_view_file);?>
				<p><?php if(!empty($page_content)) echo $page_content;?></p>
			</div>
		</div>
	</div>

	<div class="footer"> 

		<div class="footer_container"> 
			<ul class="nav justify-content-center">
			<?php foreach($page_menu_footer as $value){?>
				<li class="nav item"><?echo '<a class="nav link" target="blanc" href="https://'.$value['link'].'">'.$value['title']?></a></li>
			<?}?>
			</ul>
		</div> <!-- footer_container -->

	</div> <!-- footer -->
	<? //if(isset($_SESSION)) print_r($_SESSION);?>
</body>

</html>
