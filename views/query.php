<?php 
if (isset($_GET['query'])) {

	$product_find = $product->find($_GET['date_month'], $_GET['date_year'], $_GET['query']);

}