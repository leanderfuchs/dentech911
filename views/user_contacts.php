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

<hr>

<div class="container mt-5">
<? if (isset($notification_invite_email) AND  $notification_invite_email == TRUE) :?>
    <div class="alert alert-success">Votre email a bien été envoyé à <? echo $_POST['invite-email'] ?></div>
<? endif ?>
  <div class="row justify-content-center">
      <div class="col-4">
        <form action="#" method="post">
            <label for="invit-email" class="label mt-3">Envoyer une invitation à : </label>
                <input type="email" name="invite-email" placeholder="email">
                <input type="submit" class="btn btn-primary" value="inviter">
        </form>  
      </div>
  </div>
</div>