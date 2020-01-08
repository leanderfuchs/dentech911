<ul class="nav nav-pills justify-content-end mb-5">
	<li class="nav-item"> <a class="nav-link " href="?page=user_profil">Mon profil</a></li>
	<li class="nav-item"> <a class="nav-link active" href="?page=purchased_credit_table">Mes achats</a></li>
	<li class="nav-item"> <a class="nav-link" href="?page=user_invoices">Mes factures</a></li>
</ul>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID de transaction</th>
      <th scope="col">Date</th>
      <th scope="col">Produit</th>
      <th scope="col">Quantité</th>
      <th scope="col">Status Stripe</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <?foreach ($all_transactions as $txn_detail) :?>
      <th scope="row"><? echo $txn_detail['txn_id']; ?> </th>
      <td><? echo $txn_detail['created_at']; ?></td>
      <td><? echo $txn_detail['product']; ?></td>
      <td><? echo $txn_detail['qty']; ?></td>
      <td><? echo $txn_detail['payment_status']; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
