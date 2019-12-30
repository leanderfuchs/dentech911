<div class="info">
  info: télécharger un lecteur de code QR sur votre smartphone et scanner les codes pour mettre à jour leurs statuts.
</div>

<div class='listing'>
  <pre>
    <?php //print_r($tracking_qrlist); ?>
  </pre>

  <?foreach ($tracking_qrlist as $order_details) : ?>
    <span class="day-header"><? echo $Convert_Dates->longnames(date("l d F Y", strtotime($order_details["arrival_date"]))); ?></span><br/>

    <table class="table-striped font-90 centered" border=0>
      <tr>
        <td width="55px">[<? echo $order_details['id'] ?>]</td>
        <td width="50%"><? echo ucwords($order_details['patient_id']) ?></td>
        <td width="50%"><? echo $order_details['status']; ?></td>
        <td><? $ex3 = new QRGenerator($_SERVER['SERVER_NAME'].'/?page=order_qrcodes&id='.$order_details['id'].'&qr=true',150,'ISO-8859-1'); 
							echo '<img style="width:150px" src='.$ex3->generate().'>' ;?></td>
      </tr>
    </table>	
  <? endforeach ?>
</div>
