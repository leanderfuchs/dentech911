
<?php

echo $add_product;
echo $edit_product;

 ?>
<div class="center">

	<div class="forms">

		<form action="" method="post">


		<label for ="name">Nom :</label>
		<input id="name" type="text" name="name">

		<label for ="price">Prix :</label>
		<input id="price" type="text" name="price">

		<label for ="processing_time">Délais de production :</label>
		<input id="processing_time" type="text" name="processing_time">

		<input type="submit" name="add" value="Ajouter" class="button">
		</form>


	</div> <!-- form div -->

</div>


<?php  if ($_GET['editform']==1) {
	
	$form_product = $product->form($_GET['product_id']);
	$form = explode(",",$form_product);

?>
<div class="center">

		<div class="forms">

		<form name="edit" action="" method="post">


		<label for ="name">Nom :</label>
		<input id="name" type="text" name="name" value="<?php echo $form['1']; ?>">

		<label for ="price">Prix :</label>
		<input id="price" type="text" name="price" value="<?php echo $form['3']; ?>">

		<label for ="processing_time">Délais de production :</label>
		<input id="processing_time" type="text" name="processing_time" value="<?php echo $form['2']; ?>">

		<input type="submit" name="edit" value="Mettre a jour" class="button">
		</form>


	</div> <!-- form div -->

</div>

<?php } ?>
	
<?
	$product_watch = $product->watch();
	$product_watch = $convertMonthName->longnames($product_watch);
?>

	<div class="tables">
		 <table cellspacing="0">
		    <tr>
		        <th>Id</th>
		        <th>Nom</th>
		        <th>Temp de fabrication</th>
		        <th>Prix</th>
		        <th>Editer</th>
		        <th>Supprimer</th>
			</tr>

				<?php echo $product_watch;?>

		</table>
	</div> <!-- div table -->
















