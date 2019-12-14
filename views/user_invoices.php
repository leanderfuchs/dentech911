<ul class="nav nav-pills justify-content-end mb-5">
	<li class="nav-item"> <a class="nav-link " href="?page=user_profil">Mon profile</a></li>
	<li class="nav-item"> <a class="nav-link" href="?page=purchased_credit_table">Mes achats</a></li>
	<li class="nav-item"> <a class="nav-link active" href="?page=user_invoices">Mes factures</a></li>
</ul>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Facture #</th>
      <th scope="col">Date</th>
      <th scope="col">Montant</th>
      <th scope="col">Recevoir par email</th>
    </tr>
  </thead>
  <tbody>
    <? foreach ($transactions as $transaction) :?>
    <tr>
      <th scope="row"><? echo $transaction['invoice_nbr']; ?></th>
      <td><? echo $transaction['created_at']; ?></td>
      <td><? echo $transaction['amount']; ?></td>
      <td><? echo '<a href="sendinvoice.php?inv-nbr='. $transaction['invoice_nbr'] .'" target="blanc">email</a>'; ?></td>
    </tr>
    <? endforeach ?>
  </tbody>
</table>