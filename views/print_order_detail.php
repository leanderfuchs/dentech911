<div id="pagetitle">
	<a href="?page=order_list"><img src="views/images/dentech911-logo-320px.svg" alt="dentech911 logo" style="width:150px; margin:30px"/></a><br/>
</div> <!-- pagetitle -->

	<div id="tabs-wrapper">
		<div class="table" style="width: 100%;">
				<div class="cell cell-33">
			<div class="row">
						<span class="title"><h3>Détails du Cas</h3></span>
						<div class="frame-content">
						<div>
							Nom du patient : <b><?php echo $order_patient_name; ?></b>
						</div>

						<div>
							<?php
								$ex3 = new QRGenerator($_SERVER['SERVER_NAME'].'/commande/?page=order_detail&id='.$order_id.'&qr=true',150,'ISO-8859-1'); 
								echo "<img src=".$ex3->generate().">";
							?>
						</div>

						<div>
							Numero de suivi : <b>[<?php echo $order_id; ?>]</b>
						</div>
						<div>
							Email du destinataire : <b><?php echo $supplier_email; ?></b>
						</div>

						<div>
							Date de soumission : <b><?php echo $Convert_Dates->shortnames(date("l d F Y", strtotime($order_arrival_date))); ?></b>
						</div>
						<div>
							Retour souhaité le : <b><?php echo $Convert_Dates->shortnames(date("l d F Y", strtotime($order_return_date))); ?></b>
						</div>
						<div>
							Lot# : <b><?php echo $order_lot; ?></b>
						</div>
						<div>
							Ref# : <b><?php echo $order_ref; ?></b>
						</div>
						<div>
							Tracking# : <b><?php echo $order_tracking; ?></b>
						</div>
					<div>
						Statut : <b><span id="case_status" class="link"><?php echo $order_status; ?></span></b>
					</div>
				</div>
				</div>
		</div><!-- cell -->

		<div class="cell cell-66">
				<span class="title"><h3>Paramètres</h3></span>
				<div id="general">

					<span class="label">Travail demandé : </span> <?php echo $order_product_name; ?><br/>
					<span class="label">Numéro(s) de dent : </span> <?php echo $order_teeth_nbr; ?><br/>
			</div>
			<div class='sep'></div>
			<div >
				<span class="title"><h3>Teinte</h3></span>
					<span class="label"></span> <?php echo $order_vita_body . ' ' . $order_vita3d_body; ?>

			</div>

			<div class='sep'></div>

			<div >
					<span class="title"><h3>Fichiers</h3></span>
					<?php
					foreach ($order_files as $value){
						echo $value['order_file_name'];
						echo '</br><hr></br>';
				 	} ?>
			</div>
		</div><!-- table -->
	</div><!-- tabs-wrapper -->
<br>
<table class="styled table-striped font-90 centered">
	<tr>
		<th>
			Utilisateur
		</th>			
		<th>
			Date
		</th>
		<th>
			Statut
		</th>
		<th>
			Localisation
		</th>
	</tr>
	<?php echo $order_track; ?>
</table>
<script 
type="text/javascript">print()

function goBack(){	

$("#back")
      .click(function() {
            history.back();
            return false;
      });

}
</script>
<hr>
<div class="center">

	<a onclick="goBack()" id="back" href="?page=order_detail&id=<?php echo $_GET['id']; ?>" class="btn btn-secondary">Revenir à la page détails</a>

</div>
