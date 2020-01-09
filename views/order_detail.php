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
							$ex3 = new QRGenerator($_SERVER['SERVER_NAME'].'/?page=order_detail&id='.$order_id,150,'ISO-8859-1'); 
							echo "<img src=".$ex3->generate().">";
						?>
					</div>
					<div> Nom du patient : <b><?php echo $order_patient_name; ?></b></div>
					<div> Envoyé à : <b><?php echo $supplier_email; ?></b></div>
					<div> Numero de suivi : <b>[<?php echo $order_id; ?>]</b></div>
					<div> Date de soumission : <b><?php echo $order_arrival_date; ?></b></div>
					<div> Retour souhaité le : <b><?php echo $order_return_date; ?></b></div>
					<div> Lot # : <b><?php echo $order_lot; ?></b></div>
					<div> Ref # : <b><?php echo $order_ref; ?></b></div>
					<div> Suivi transporteur # : <b><?php echo $order_tracking; ?></b></div>
				</div>
				<hr>
				<span class="title"><h3>Renseignement de production</h3></span>
				<div class="form">
					<div id="next_status_wrap">
						<form id="traceability" method="post" action="?page=order_detail&id=<?php echo $order_id; ?>">
							<label for="lot">lot#</label><br/>
							<input type="text" name="lot" id="lot" value="n° de lot du produit">
							<br/>
							<label for="ref">Ref#</label><br/>
							<input type="text" name="ref" id="ref" value="n° de référence du produit">
							<br/>
							<label for="tracking">Numéro de suivi transporteur</label><br/>
							<input type="text" name="tracking" id="tracking" value="chronopost 123456789">
							<br/>
							<input type="submit" class="btn btn-secondary mt-2" name="traceability" value="Renseigner">
						</form>
					</div>
				</div>
				<hr>
				<div class="title"><h3>Changer de statut</h3></div>
				<div> Statut actuel: <b><span id="case_status" class="link"><?php echo $order_status; ?></span></b></div>
				
				<form id="status" method="post" action="?page=order_detail&id=<?php echo $order_id; ?>">
				<select name="status" class="mt-2 mb-2">
					<option value="">Mettre à jour</option>
					<? $status_list = array('Envoyé', 'Reçu par le destinataire', 'En cours de fabrication', 'Livraison', 'Reçu par le client');?>
					<? foreach ($status_list as $key => $value) : ?>
						<option value="<? echo $status_list[$key] ?>"> <? echo $status_list[$key] ?></option>
					<? endforeach ?>
				</select>
				</br>
				<input class="btn btn-secondary mt-2" type="submit" name="submit" value="mettre à jour le statut"></form>

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
					<?php foreach ($order_files as $value){
						$button_stye = 'alert-info';
						if($value['unlocked']==1){$button_stye = 'alert-secondary';}
						echo '<a class="btn '. $button_stye .'" href="?page=order_detail&id='.$order_id.'&file_hash='.$value['file_hash'].'">'.$value['order_file_name'].'</a></br></br>';
					} ?>
				</div>

				<? if (isset($_GET['file_hash'])) {
					if ($_SESSION['balance']>0 || (isset($file_lock) && $file_lock == 1)){
						echo '<a class="btn btn-success" href="'. $file_url .'" target="blanc">Téléchager :'. $file_name .'</a>';
					} elseif( $insuficient_credit == TRUE ) {
						echo '<div class="alert alert-danger">Vous n\'avez pas assez de crédits pour télécharger ce fichier.</div>';
					}
				}?>

				<div class='sep'></div>
				<span class="title"><h3>Ajouter un fichier</h3></span>
				<div class="visual-form-builder-container">
					<form id="add_file" enctype="multipart/form-data" class="visual-form-builder" method="post" action="">
					<fieldset class="fieldset  commandexfset">
						<ul class="section section-1">
								<input type="file" name="file" id="file" value="" class="text large" accept=".zip,.zipx.tar.gz,.tgz,.tar.Z,.tar.bz2,
.tbz2,.tar.lzma,.tlz..tar.xz,.txz,.rar,.7z,.rar,.bz2,.gz,.tar,.doc,.docx,.pdf,.stl,.jpeg,.jpg,.png,.ply,.obj"></br></br>								
								<input type="submit" name="add_file" value="Ajouter" class="btn btn-secondary">
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
						<button name="send_prod" type="submit" class="btn btn-secondary" value="send_prod">Ajouter un message</button></a>
					<br/>
			</div><!-- cell -->
		</div><!-- row -->
	</div><!-- table -->
</div><!-- tabs-wrapper -->
<br>
<table class="styled table-striped font-90 centered">
	<tr>		
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
	<?php if (isset($order_track)) : ?>
		<? foreach ($order_track as $track_detail) : ?>
			<tr>
			<td><? echo $Convert_Dates->shortnames(date("l d F Y H:i", strtotime($track_detail['time']))) ;?></td>
			<td><? echo $track_detail['status'] ;?></td>
			<td><? echo $track_detail['localization'] ;?></td>
			</tr>
		<? endforeach ?>
		<? endif ?>
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

