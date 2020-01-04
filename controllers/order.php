<?php
$product = new product;
$ibdd = new db_connect;

$page_point_price = $ibdd->options_query('point_value');

$user_id = $_SESSION['user_id'];
$missing_patient = "";
$missing_product = "";

$product_list = $product->list();

//------------------------------------ Form error handeling
if (isset($_GET['missing_patient']) && $_GET['missing_patient']=='missingpatient') {
	echo '<div class="alert alert-danger" style="margin-top:35px">Vous devez renseigner le champ Patient ID</div>';
}

if (isset($_GET['missing_product']) && $_GET['missing_product']=='missingproduct') {
	echo '<div class="alert alert-danger">Vous devez renseigner le champ Produit</div>';
}

if (isset($_GET['missing_email']) && $_GET['missing_email']=='missingemail') {
	echo '<div class="alert alert-danger">Vous devez entrer l\'email du destinataire</div>';
}

//------------------------------------ Welcome messages
if (isset($_GET['welcome-back']) && $_GET['welcome-back']==TRUE){
	echo '<div class="alert alert-success">Bon retour sur DenTech911. Nous nous réjouissons de recevoir votre prochaine commande</div>';
}

if (isset($_GET['welcome']) && $_GET['welcome']==TRUE){
	echo '<div class="alert alert-success">Bienvenue sur DenTech911. Vous pouvez déjà envoyer votre première commande. C\'est gratuit...</div>';
}