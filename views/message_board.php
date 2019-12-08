<br/>
<h1>
	Commentaires - <?php echo $order_patient_name; ?>
</h1>

<div id="tabs-nav-div">
	<ul class="nav justify-content-end">
		<li class="nav item"> <a class="nav link" id="followup2" href="?page=order_detail&id=<?php echo $order_id; ?>">Retour à la page détails</a>
	</ul>
</div><!-- tabs-nav-div -->
<div id="tabs-wrapper">
	<div class="table">
		<div class="row">
			<div class="cell cell-33">
				<span class="title"><h3>Détails du Cas</h3></span>
					<div class="frame-content">
						<div>
							Nom du patient : <b><?php echo $order_patient_name; ?></b>
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
							Lot : <b><?php echo $order_lot; ?></b>
						</div>
						<div>
							Ref# : <b><?php echo $order_ref; ?></b>
						</div>
						
						<?php if ($page_access=="DenTech911" OR $page_access=="admin" OR $page_access=="Fournisseur"): ?>
						<div>
							Tracking# : <b><?php echo $order_tracking; ?></b>
						</div>
							<?php endif ?>
						<div>
							Statut : <b><span id="case_status" class="link"><?php echo $order_status; ?></span></b>
						</div>
						<div>
							Status du paiement : <b><?php if ($order_paiment_status==0) {echo 'impayé';} else {echo'payé';}?></b>
						</div>
					</div>
				</div> <!-- cell -->
			<div class="cell cell-66">

				<!-- Last message on top with a different style -->
					<?php 
					foreach ($comment_list as $key => $value) {?>
						</br>Message de <? echo $user->user_query($comment_list[$key]['user_ref_id'],'name'); ?></br> 
						envoyé le <? echo $comment_list[$key]['date']; ?></br>
						<b><? echo $comment_list[$key]['comment']; ?></b></br>
						</br><hr>
					<?php } ?>

					<span class="label"><b>Envoyez un messages ou répondre</b></span>
					<form id="comment" action="" method="post">  
						<textarea name="comment" rows="5"> </textarea>
						<input type="submit" name="submit_comment" value="Envoyer">  
					</form>
					<br/>
					<br/>
				</div> <!-- comment-frame-ro -->

			</div> <!-- cell -->
		</div> <!-- row -->
	</div> <!-- table -->

</div> <!-- tabs-wrapper -->