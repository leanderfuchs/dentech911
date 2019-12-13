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
	echo '<div class="error" style="margin-top:35px">Vous devez renseigner le champ Patient ID</div>';
}

if (isset($_GET['missing_product']) && $_GET['missing_product']=='missingproduct') {
	echo '<div class="error">Vous devez renseigner le champ Produit</div>';
}

if (isset($_GET['missing_email']) && $_GET['missing_email']=='missingemail') {
	echo '<div class="error">Vous devez entrer l\'email du destinataire</div>';
}