<br/>
<h1>
	Certificat de conformité
</h1>

<div id="tabs-nav-div">
	<ul class="tab-nav">
		<li class="tab-nav"> <a onclick="goBack()" id="back" href="?page=order_detail&id=<?php echo $_GET['id']; ?>" data-icon="arrow-l">Revenir à la page détails</a>
		</li>
		<li class="action-btn">|  <a href="javascript:window.print()">Imprimer</a> 
		</li>
	</ul>
</div><!-- tabs-nav-div -->

<br/>
<br/>

<?php 

if ($user_restricted_page == 1) {
	exit;
}

?>

<div class="frame-content">

	<div class="center">
	
		<span><h4>FICHE DE SUIVI</h4></span>

		<span><h3>DenTech911</h3></span>
		<p>Pour DHR (Device History Record)</p>
	
	</div>

		<div>
			<span><h3>Nom du patient : <b><?php echo $order_details['4']; ?></b></h3><span>
		</div>

		<div>
			<?php
				$ex3 = new QRGenerator($_SERVER['SERVER_NAME'].'/commande/?page=order_detail&id='.$order_id.'&qr=true',150,'ISO-8859-1'); 
				echo "<img src=".$ex3->generate().">";
			?>
		</div>

		<div>
			N° de commande : <b>[<?php echo $order_id; ?>]</b>
		</div>

		<div>
			Email destinataire : <b><?php echo $email_supplier; ?></b>
		</div>

		<div>
			Date de soumission : <b><?php echo $Convert_Dates->shortnames(date("l d F Y", strtotime($order_date))); ?></b>
		</div>
		<div>
			Date de retour enregistrée : <b><?php echo $Convert_Dates->shortnames(date("l d F Y", strtotime($order_return_date))); ?></b>
		</div>
		<div>
			Désignation : <b><?php echo $order_product_name; ?></b>
		</div>
		<div>
			Numéro(s) dent(s) usinée(s) : <b><?php echo $order_teeth_nbr; ?></b>
		</div>
		<div>
			Quantité : <b><?php echo $order_qty; ?></b>
		</div>
		<div>
			Teinte : <b><?php echo $order_vita . ' ' . $order_vita3d; ?></b>
		</div>
		<div>
			Numéro de lot : <b><?php echo $order_lot; ?></b>
		</div>
		<div>
			Numéro de référence : <b><?php echo $order_ref; ?></b>
		</div>
		
</div><!-- frame-content -->

<br>
<script type="text/javascript">

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
	
		<span class="title"><h3>DECLARATION DE DISPOSITIF MEDICAL SUR MESURE (CLASSE IIa)</h3></span>
	
	</div>
<p>Je soussignée, Mr. Fuchs Leander, gérant de Open Hongkong Co., Ltd., assure et déclare, sous ma seule responsabilité, que le dispositif médical sur mesure CAS No <?php echo $order_id; ?> , est mis sur le marché pour l'usage exclusif du patient identifié sous le numéro: <?php echo $order_patient_id; ?> suivant les caractéristiques spécifiques du produits indiquées par la prescription du user identifié par la référence <?php echo $order_ref; ?>.
</p>

<p>Je déclare que ce dispositif sur mesure est conforme aux exigences essentielles des articles R.5211-21 à R. 5211-24 et de l’arrêté du 15 mars 2010 fixant les conditions de mise en œuvre des exigences essentielles applicables aux dispositifs médicaux, pris en application de l'article R. 5211-24 du code de la santé publique.</p>
<p>Date, <?php echo $Convert_Dates->shortnames(date("l d F Y", strtotime($order_return_date))); ?></p>
<p>Leander FUCHS</p>

<p>Open Hongkong Co., Ltd., Company number: 1327759, Room 1701, 17/F, Henan Building, No.90, Jaffe Road, Wanchai, Hong Kong</p>

