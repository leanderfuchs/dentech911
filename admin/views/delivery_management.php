<?php 

//------------------------------------ editer les infos utilisateur

if ($_GET['edit_delivery']==1) { 

	/*echo "<pre>";
	echo print_r($delivery_info);
	echo "</pre>";*/

?>
<div class="center">

	<div class="forms">

		<form name="edit" action="" method="post">
		<?php echo 'Commande ['.$delivery_info[1].'] - '; ?>
	
		<label for ="track_supplier">No de suivi fournisseur :</label>
		<input type="text" id="track_supplier"  name="track_supplier" value="<?php echo $delivery_info[2]; ?>">
		
		<label for ="track_open">No de suivi transporteur Open CFAO :</label>
		<input type="text" id="track_open" name="track_open" value="<?php echo $delivery_info[3]; ?>">
		
		<input type="submit" name="edit" value="Metre a jour" class="button">
		</form>


	</div> <!-- forms div -->

</div> <!-- forms div -->
	
<? } ?>

<div class="tables" >

	 <table cellspacing="0">
	    <tr>
	        <th>ID de la commande</th>
	        <th>Numero de suivi fournisseur</th>
	        <th>Numero de suivi Transporteur Open CFAO</th>
	        <th>Editer</th>
		</tr>

			<?php echo $delivery_list ?>

	</table>
</div> <!-- div table -->
















