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
        <? $qr_link = $_SERVER['SERVER_NAME'] .'/?page=order_qrcodes&id=' .$order_details['id']. '&open=received';
        echo '<td><img width="100px" src="'. $ex3->generate($qr_link,200,'ISO-8859-1') .'"></td>' ?>
      </tr>
    </table>	
  <? endforeach ?>
</div>
