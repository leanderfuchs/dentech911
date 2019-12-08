<?php 
//------------------------------------ detailles  de la commande


	$order_info = explode("|", $order_details);
	$supplier_info = explode("|", $supplier_details);

	if (isset($_GET['edit_order']) AND $_GET['edit_order']==1) { 

	if ($order_info['6']==1) {
		$order_info['6'] = 'Payée';
	} else {
		$order_info['6'] = 'Impayée';
	}

?>

<div class="center">

	<div class="forms">

		<form name="edit" action="" method="post">
			<label for ="patient_id">Patient :</label>
			<input id="patient_id" type="text" name="patient_id" value="<?php echo $order_info['4']; ?>">

			<label for ="supplier">Fournisseur :</label>
				<select name="supplier" id="supplier">
	 				<?php echo $supplier_list ?>
			 	</select>			

			<label for ="status">status :</label>
			<select name="status" id="status">
				<option value="Commande envoyée" <?php if($order_info['5']=="Commande envoyée") echo "selected"; ?>>Commande envoyée</option>
				<option value="Reçu chez DenTech911" <?php if($order_info['5']=="Reçu chez DenTech911") echo "selected"; ?>>Reçu chez DenTech911</option>
				<option value="Envoyée en production" <?php if($order_info['5']=="Envoyée en production") echo "selected"; ?>>Envoyée en production</option>
				<option value="En cours de production" <?php if($order_info['5']=="En cours de production") echo "selected"; ?>>En cours de production</option>
				<option value="En retour de production" <?php if($order_info['5']=="En retour de production") echo "selected"; ?>>En retour de production</option>
				<option value="Prète à être livrée" <?php if($order_info['5']=="Prète à être livrée") echo "selected"; ?>>Prète à être livrée</option>
				<option value="En cours de livraison" <?php if($order_info['5']=="En cours de livraison") echo "selected"; ?>>En cours de livraison</option>
				<option value="Livrée" <?php if($order_info['5']=="Livrée") echo "selected"; ?>>Livrée</option>
			</select> 

			<label for ="paiment_status">Status du paiement :</label>
			<select name="paiment_status" id="paiment_status">
				<option value="Payée"<?php if($order_info['6']=="Payée") echo "selected"; ?>>Payée</option>
				<option value="Impayée" <?php if($order_info['6']=="Impayée") echo "selected"; ?>>Impayée</option>
			</select> 
			<br/>
			<label for ="teeth_nbr">Dents :</label>	
			<input id="teeth_nbr" type="text" name="teeth_nbr" value="<?php echo $order_info['8']; ?>">

			<label for ="product_name">Nom du produit :</label>
			<select name="product_name" id="product_name">	
				<option value="<?php echo $order_info['9']; ?>"><?php echo $order_info['9']; ?></option>
				<?php echo $product_listing;?>
			</select>

			<label for ="quantity">Quantité :</label>	
			<input id="quantity" type="text" name="quantity" value="<?php echo $order_info['10']; ?>">

			<label for="vita" class="desc">Teinte Vita</label>
		 					<select name="vita" id="vita">
		 						<option value="A1" <?php if($order_info['14']=="A1") echo "selected"; ?>>
		 							A1
		 						</option>
		 						<option value="A2" <?php if($order_info['14']=="A2") echo "selected"; ?>>
		 							A2
		 						</option>
		 						<option value="A3" <?php if($order_info['14']=="A3") echo "selected"; ?>>
		 							A3
		 						</option>
		 						<option value="A3.5" <?php if($order_info['14']=="A3.5") echo "selected"; ?>>
		 							A3.5
		 						</option>
		 						<option value="A4" <?php if($order_info['14']=="A4") echo "selected"; ?>>
		 							A4
		 						</option>
		 						<option value="B1" <?php if($order_info['14']=="B1") echo "selected"; ?>>
		 							B1
		 						</option>
		 						<option value="B2" <?php if($order_info['14']=="B2") echo "selected"; ?>>
		 							B2
		 						</option>
		 						<option value="B3" <?php if($order_info['14']=="B3") echo "selected"; ?>>
		 							B3
		 						</option>
		 						<option value="B4" <?php if($order_info['14']=="B4") echo "selected"; ?>>
		 							B4
		 						</option>
		 						<option value="C1" <?php if($order_info['14']=="C1") echo "selected"; ?>>
		 							C1
		 						</option>
		 						<option value="C2" <?php if($order_info['14']=="C2") echo "selected"; ?>>
		 							C2
		 						</option>
		 						<option value="C3" <?php if($order_info['14']=="C3") echo "selected"; ?>>
		 							C3
		 						</option>
		 						 <option value="C4" <?php if($order_info['14']=="C4") echo "selected"; ?>>
		 							C4
		 						</option>
		 						<option value="D2" <?php if($order_info['14']=="D2") echo "selected"; ?>>
		 							D2
		 						</option>
		 						<option value="D3" <?php if($order_info['14']=="D3") echo "selected"; ?>>
		 							D3
		 						</option>
		 						<option value="D4" <?php if($order_info['14']=="D4") echo "selected"; ?>>
		 							D4
		 						</option>
		 					</select>
			
			<label for ="vita3d">Teinte VITA 3D :</label>
			<select name="vita3d" id="vita3d">

		 					<option value="1M1" <?php if($order_info['15']=="1M1") echo "selected"; ?>>
		 						1M1
		 					</option>
		 					<option value="1M2" <?php if($order_info['15']=="1M2") echo "selected"; ?>>
		 						1M2
		 					</option>
		 					<option value="2L1.5" <?php if($order_info['15']=="2L1.5") echo "selected"; ?>>
		 						2L1.5
		 					</option>
		 					<option value="2L2.5" <?php if($order_info['15']=="2L2.5") echo "selected"; ?>>
		 						2L2.5
		 					</option>
		 					<option value="2M1" <?php if($order_info['15']=="2M1") echo "selected"; ?>>
		 						2M1
		 					</option>
		 					<option value="2M2" <?php if($order_info['15']=="2M2") echo "selected"; ?>>
		 						2M2
		 					</option>
		 					<option value="2M3" <?php if($order_info['15']=="2M3") echo "selected"; ?>>
		 						2M3
		 					</option>
		 					<option value="2R1.5" <?php if($order_info['15']=="2R1.5") echo "selected"; ?>>
		 						2R1.5
		 					</option>
		 					<option value="2R2.5" <?php if($order_info['15']=="2R2.5") echo "selected"; ?>>
		 						2R2.5
		 					</option>
		 					<option value="3L1.5" <?php if($order_info['15']=="3L1.5") echo "selected"; ?>>
		 						3L1.5
		 					</option>
		 					<option value="3L2.5" <?php if($order_info['15']=="3L2.5") echo "selected"; ?>>
		 						3L2.5
		 					</option>
		 					<option value="3M1" <?php if($order_info['15']=="3M1") echo "selected"; ?>>
		 						3M1
		 					</option>
		 					<option value="3M2" <?php if($order_info['15']=="3M2") echo "selected"; ?>>
		 						3M2
		 					</option>
		 					<option value="3M2" <?php if($order_info['15']=="3M2") echo "selected"; ?>>
		 						3M3
		 					</option>
		 					<option value="3R1.5" <?php if($order_info['15']=="3R1.5") echo "selected"; ?>>
		 						3R1.5
		 					</option>
		 					<option value="3R2.5" <?php if($order_info['15']=="3R2.5") echo "selected"; ?>>
		 						3R2.5
		 					</option>
		 					<option value="4L1.5" <?php if($order_info['15']=="4L1.5") echo "selected"; ?>>
		 						4L1.5
		 					</option>
		 					<option value="4L2.5" <?php if($order_info['15']=="4L2.5") echo "selected"; ?>>
		 						4L2.5
		 					</option>
		 					<option value="4M1" <?php if($order_info['15']=="4M1") echo "selected"; ?>>
		 						4M1
		 					</option>
		 					<option value="4M2" <?php if($order_info['15']=="4M2") echo "selected"; ?>>
		 						4M2
		 					</option>
		 					<option value="4M3" <?php if($order_info['15']=="4M3") echo "selected"; ?>>
		 						4M3
		 					</option>
		 					<option value="4R1.5" <?php if($order_info['15']=="4R1.5") echo "selected"; ?>>
		 						4R1.5
		 					</option>
		 					<option value="4R2.5" <?php if($order_info['15']=="4R2.5") echo "selected"; ?>>
		 						4R2.5
		 					</option>
		 					<option value="5M1" <?php if($order_info['15']=="5M1") echo "selected"; ?>>
		 						5M1
		 					</option>
		 					<option value="5M2" <?php if($order_info['15']=="5M2") echo "selected"; ?>>
		 						5M2
		 					</option>
		 					<option value="5M3" <?php if($order_info['15']=="5M3") echo "selected"; ?>>
		 						5M3
		 					</option>
		 				</select>
		 				<br/>
		 				 <input type="submit" id="edit" name="edit" value="Changer" class="button">

		</form>

	</div>

</div>

<? } ?>

<div class="tables">
	 <table  cellspacing='0'>
	    <tr style="background-color:#bfbfbf">
	        <th>Id</th>
	        <th>Fournisseur</th>
	        <th>Date et heure</th>
	        <th>Utilisateur</th>
	        <th>Nom du patient</th>
	        <th>Status</th>
	        <th>Paiement</th>
	        <th>Dents</th>
	        <th>Produit</th>
	        <th>Quantité</th>
	        <th>Teinte</th>
	        <th>Edit</th>
	        <th>Delete</th>

		</tr>

			<?php echo $order_view;?>

	</table>
</div> <!-- div table -->
















