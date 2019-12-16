<table class="table">
  <thead>
    <tr>
      <th scope="col">email</th>
      <th scope="col">Nom</th>
      <th scope="col">Entreprise</th>
      <th scope="col">envoyer des points</th>
      <th scope="col">envoyer un fichier</th>
    </tr>
  </thead>
  <tbody>
  <? foreach ($user_contacts as $contact) :?>
    <tr>
      <th scope="row"><? echo $contact['email'] ?></th>
      <td><? echo $contact['name'] ?></td>
      <td><? echo $contact['company'] ?></td>
      <td><a href="?page=send-points&to-user-id=<? echo $contact['id'] ?>">Envoyer des points</a></td>
      <td><a href="?page=order&email-order-to=<? echo $contact['email'] ?>">Nouvelle commande</a></td>
    </tr>
    <? endforeach ?>
  </tbody>
</table>