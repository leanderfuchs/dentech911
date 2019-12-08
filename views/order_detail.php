<h1>
	Cas - <?php echo $order_patient_name; ?>
</h1>

<?php 
if (!empty($user_restricted_pages)) {
	exit;
}
?>

<div id="tabs-nav-div">
	<ul class="nav justify-content-end">
		<li class="nav-item"> <a class="nav-link" href="?page=message_board&id=<?php echo $order_id; ?>">Commentaires</a></li>
		<li class="nav-item"> <a class="nav-link" href="?page=order_certificat&id=<?php echo $order_id; ?>">Certificat de conformité</a></li>
		<li class="action-btn"> <a class="nav-link" href="?page=print_order_detail&id=<?php echo $order_id; ?>">Imprimer</a></li>
	</ul>
</div><!-- tabs-nav-div -->

<div id="tabs-wrapper">
	<div class="table">
		<div class="row">
			<div class="cell cell-33">
				<span class="title"><h3>Détails du Cas</h3></span>
				<div class="frame-content">
					<?php if ($page_access=="DenTech911" OR $page_access=="admin"): ?>
					<div>
						user : <b><?php echo $client_name; ?></b>
					</div>						
					<?php endif ?>
					
					<div>
						<?php
							$ex3 = new QRGenerator($_SERVER['SERVER_NAME'].'/commande/?page=order_detail&id='.$order_id.'&qr=true',150,'ISO-8859-1'); 
							echo "<img src=".$ex3->generate().">";
						?>
					</div>
					<div>
						Nom du patient : <b><?php echo $order_patient_name; ?></b>
					</div>
					<div>
						Envoyé à : <b><?php echo $supplier_email; ?></b>
					</div>
					<div>
						Numero de suivi : <b>[<?php echo $order_id; ?>]</b>
					</div>
					<div>
						Date de soumission : <b><?php echo $order_arrival_date; ?></b>
					</div>
					<div>
						Retour souhaité le : <b><?php echo $order_return_date; ?></b>
					</div>
					<div>
						Lot# : <b><?php echo $order_lot; ?></b>
					</div>
					<div>
						Ref# : <b><?php echo $order_ref; ?></b>
					</div>

					<?php if ($page_access=="DenTech911" OR $page_access=="admin" OR $page_access=="Fournisseur"): ?>
					<div>
						Tracking# : <a href="https://www.fedex.com/fedextrack/?tracknumbers=<?php echo $order_tracking; ?>" target="blanc"><b><?php echo $order_tracking; ?></b></a>
					</div>
					<?php endif ?>
					<div>
						Statut : <b><span id="case_status" class="link"><?php echo $order_status; ?></span></b>
					</div>

				</div>

				<?php if (isset($order_update_status)){echo $order_update_status;} ?>

				<?php if ($page_access=="DenTech911" OR $page_access=="admin" OR $page_access=="Fournisseur"): ?>

					<span class="title"><h3>Renseignement de production</h3></span>
					<div class="form">
						<div id="next_status_wrap">
							<form id="traceability" method="post">
								<label for="lot">lot#</label><br/>
								<input type="text" name="lot" id="lot" value="<?php echo $order_lot; ?>">
								<br/>
								<label for="ref">Ref#</label><br/>
								<input type="text" name="ref" id="ref" value="<?php echo $order_ref; ?>">
								<br/>
								<label for="tracking">Numéro de suivi transporteur</label><br/>
								<input type="text" name="tracking" id="tracking" value="<?php echo $order_tracking; ?>">
								<br/>
								<input type="submit" name="traceability" value="Renseigner">
							</form>
						</div>
					</div>

				<?php endif ?>

				<?php if (isset($order_update_prod)) { echo $order_update_prod; }?>

			</div><!-- cell -->
			<div class="cell cell-66">
				<span class="title"><h3>Paramètres</h3></span>
				<div id="general">
					<span>Travail demandé : </span> <?php echo $order_product_name; ?><br/>
					<span>Numéro(s) de dent : </span> <?php echo $order_teeth_nbr; ?><br/>
				</div>

				<div class='sep'></div>

				<div >
					<span class="title"><h3>Teinte</h3></span>				
					<span > <?php echo $order_vita_body . ' ' . $order_vita3d_body; ?> </span>

				</div>
					<div class='sep'></div>

				<div >
					<span class="title"><h3>Fichiers</h3></span>
					<?php
					foreach ($order_files as $value){
						echo '<a href="'.$value['file_url'].'">'.$value['file_url'].'</a></br></br>';
					?>
					<?php } ?>
				</div>
				<div class='sep'></div>

				<span class="title"><h3>Ajouter un fichier</h3></span>

				<div class="visual-form-builder-container">
					<form id="add_file" enctype="multipart/form-data" class="visual-form-builder" method="post" action="">
					<fieldset class="fieldset  commandexfset">
						<ul class="section section-1">
								<input type="file" name="file" id="file" value="" class="text large"></br></br>								
								<input type="submit" name="add_file" value="Ajouter" class="submit">
						</ul>
					</fieldset>
					</form>
				</div>

				<?php if (!empty($comment_first_comment)): ?>
					<div class='sep'></div>

					<span class="title"><h3>Commentaire</h3></span>
					<a href="?page=message_board&id=<?php echo $order_id; ?>">
						<p>
							<?php echo $comment_first_comment; ?>
						</p>
					</a>	
				<?php endif ?>

					<div class='sep'></div>

					<a href="?page=message_board&id=<?php echo $order_id; ?>" class="center">
						<button name="send_prod" type="submit" value="send_prod">Ajouter un message</button></a>
						<br/>
			</div><!-- cell -->
		</div><!-- row -->
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
	<?php if (isset($order_track)) {echo $order_track;} ?>
</table>

<?php if ($page_access=="DenTech911" OR $page_access=="admin"): ?>
	<br/>
	<br/>
	<br/>

	<div class="center">
	
		<form  method="post" action="" onsubmit="return confirm('Voulez vous vraiment supprimer cette commande ?');">				
			<!-- <button name="delete" id="delete" type="submit" value="delete" style="color:red; font-weight:bold;"
			>Supprimer</button>  -->
		</form>
	
	</div>

<?php endif ?>

