<div class="alert alert-info" role="alert">
  Vous avez <b><? echo $_SESSION['balance']?> points</b> sur ce compte.
</div>

<?if (isset($not_enough_funds) && $not_enough_funds == TRUE):?>
  <div class="alert alert-danger">Pas assez de points</div>
<? endif ?>

<?if (isset($transfer_point_result) && $transfer_point_result == 1):?>
  <div class="alert alert-success">Vos points ont bien été envoyés et le bénéficiaire notifié par email</div>
<? endif ?>

<?if (isset($transfer_point_result) && $transfer_point_result == 0):?>
  <div class="alert alert-danger">Cette adresse email nous est inconnue . Nous avons donc envoyé un email de demande de création de compte de votre part et vos points serons crédités une fois que le destinataire aura créé son compte.</div>
<? endif ?>

<p>Afin de faciliter les échanges entre partenaires, nous facilitons l'envoi de points de téléchargement entre vous et celui qui enverra les commandes.</p>

<form method="post">
  <div class="form-row align-items-center">
    <div class="col-sm-3 my-1">
      <label class="sr-only" for="inlineFormInputName">Name</label>
      <input type="text" name="points" class="form-control" id="inlineFormInputName" placeholder="#points">
    </div>
    <div class="col-xl-6 my-1">
      <label class="sr-only" for="inlineFormInputGroupUsername">email du destinataire</label>
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">@</div>
        </div>
        <input type="email" name="to-email" class="form-control" id="inlineFormInputGroupUsername" placeholder="partenaire@email.com" value="<? echo $user_email; ?>">
      </div>
    </div>
    <div class="col-auto my-1">
      <button type="submit" class="btn btn-primary">Envoyer les points</button>
    </div>
  </div>
</form>