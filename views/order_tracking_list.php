<div class="alert alert-info">
Afin de faciliter la mise à jour des différents numéros de lots et références produits, cette page permet de facilement éditer ces informations en masse.</br>
Remplir les cases rapidement en appuyant sur la touche ENTER ou TAB ou avec un <u>lecteur de code bar</u>.
</div>

<form method="post" action="">
  <div class='listing'>
  <table class="table-striped font-90 centered" border=0>
  <? foreach($tracking_caselist as $key=>$value){ ?>
  <tr>
    <td width=""><b>[<? echo $value['id']; ?>]</b></td>
    <td width="10%"><? echo $Convert_Dates->longnames(date("d m Y", strtotime($value['arrival_date']))); ?></td>
    <td width="30%"><? echo ucwords($value['patient_id']); ?></td>
    <td width="15%"><? echo $value['product_name']; ?></td>
    <? echo '<td width="150px">Lot #:<input type="text" size=12  name="lot-'.$value['id'].'" value="'.$value['lot'].'"></td> '; ?>
    <? echo '<td width="150px">ref #:<input type="text" size=12  name="ref-'.$value['id'].'" value="'.$value['ref'].'"></td> '; ?>
    <? echo '<td width="180px">Tracking #:<input type="text" size=12  name="track-'.$value['id'].'" value="'.$value['tracking'].'"></td> '; ?>
    <input type="hidden" name="order-id" value="<? echo $value['id']; ?>">
  </tr>
<?}?>
  </table>

  </div>
  <div class="container">
    <div class="btn-block pull-right m-2">
      <button class="btn btn-dark mx-auto" type="submit" value="valider">Envoyer</button>
      <!-- <input type="submit" value="valider" style="bottom:790px; left:430px; position:relative"> -->
    </div>
  </div>
</form>

<script type="text/javascript">

$(document).ready(function() {
 $('input:text:first').focus();
    
 $('input:text').bind("keydown", function(e) {
    var n = $("input:text").length;
    if (e.which == 13) 
    { //Enter key
      e.preventDefault(); //Skip default behavior of the enter key
      var nextIndex = $('input:text').index(this) + 1;
      if(nextIndex < n)
        $('input:text')[nextIndex].focus();
      else
      {
        $('input:text')[nextIndex-1].blur();
        $('#btnSubmit').click();
      }
    }
  });

  $('#btnSubmit').click(function() {
     alert('Form Submitted');
  });
});
</script>