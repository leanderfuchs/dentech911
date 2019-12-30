<pre>
	<?php //print_r($order_caselist);?>
</pre>

<div class='listing'>
	<? 	$count_dates = count($order_caselist);
	for ($c = 0; $c < $count_dates; $c++) : ?>
	<div class="day-header"><? echo $order_caselist[$c]['arrival_date']; ?></div><br/>
	<table class="table-striped font-90 centered" border=0 >
		<tr>
			<? $count_cases = count($order_caselist[$c][1]);

			for($i = 0; $i < $count_cases; $i++) :

				switch ($order_caselist[$c][1][$i]['status']) {
				case "Commande envoyée":
					$color = 'style="color:#0b7215;"';
					break;
				case "Reçu chez DenTech911":
					$color = 'style="color:#1cb236;"';
					break;
				case "Envoyée en production":
					$color = 'style="color:#1eec41;"';
					break;
				case "En cours de production":
					$color = 'style="color:#f6bb1c;"';
					break;
				case "En retour de production":
					$color = 'style="color:#fc852a;"';
					break;
				case "Prète à être livrée":
					$color = 'style="color:#fb0015;"';
					break;
				case "En cours de livraison":
					$color = 'style="color:#98000d;"';
					break;
				case "Livrée":
					$color = 'style="color:#7f7f7f;"';
					break;
				}?>

				<td width="50px"><b>[<? echo $order_caselist[$c][1][$i]['id']; ?>]</b></td>
				<td width="150px"><? echo ucwords($order_caselist[$c][1][$i]['patient_id']); ?></td>
				<td width="100px"><? echo $order_caselist[$c][1][$i]['teeth_nbr']; ?></td>
				<td width="200px"><? echo $order_caselist[$c][1][$i]['product_name']; ?></td>
				<td width="50px"><? echo $order_caselist[$c][1][$i]['vita_body']. $order_caselist[$c][1][$i]['vita3d_body']; ?></td>
				<td width="130px" <? echo $color; ?> > <b><? echo $order_caselist[$c][1][$i]['status']; ?></b></td>
				<td width="120px"><? echo $order_caselist[$c][1][$i]['tracking']; ?></td>
				<td width="24px"><a href="?page=order_detail&id=<? echo $order_caselist[$c][1][$i]['id']; ?>">Voir</a></td>
		</tr>
		<? endfor ?>
	</table>
<? endfor ?>
</div>