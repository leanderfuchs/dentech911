<div class="container">
<? if (isset($_SESSION['balance']) && $_SESSION['balance']>0) {?>
    <div class="alert alert-primary" role="alert">
        Vous avez <b><? echo $_SESSION['balance'] ?></b> points correspondant à <b><? echo floor($_SESSION['balance']/$_SESSION['point_value']);?></b> fichiers.
    </div>
<?} elseif ((isset($_SESSION['balance']) && $_SESSION['balance']==0)) {?>
    <div class="alert alert-primary" role="alert">
        Vous avez devez avoir au moins un point pour envoyer ou recevoir un fichier.
    </div>
<?}?>

<h4><span class="badge badge-secondary">Aujourd'hui 1 point = <? echo $_SESSION['point_value'] ?>€</span></h4>
<form action="../controllers/charge.php" method="post" id="payment-form">
      <div class="form-row mt-5">
      <input type="text" name="point" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Combien de points avez-vous besoin ?">
       <input type="text" name="first_name" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Nom">
       <input type="text" name="last_name" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Prenom">
       <input type="email" name="email" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Email">
        <input type="hidden" name="user_id" value="<? echo $_SESSION['user_id']; ?>">
        <div id="card-element" class="form-control">
          <!-- a Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors -->
        <div id="card-errors" role="alert"></div>
      </div>
    <div class="row justify-content-md-center">
        <div class="col-lg-3">
            <button>Acheter</button>
        </div>
    </div>
    </form>
  </div>
<p class="p small text-center mt-5">Paiements sécurisés par <a href="https://stripe.com/fr">Stripe</a></p>
<div class="container-fluid mx-auto">
    <div class="row justify-content-md-center">
        <img src="../views/images/visa-logo-color.svg" class="col-lg-1" style="height:30px">
        <img src="../views/images/mastercard-logo-color.svg" class="col-lg-1" style="height:30px">
        <img src="../views/images/visa-electron-logo-color.svg" class="col-lg-1" style="height:30px">
        <img src="../views/images/amex-logo-color.svg" class="col-lg-1" style="height:30px">
        <img src="../views/images/bitcoin-logo-color.svg" class="col-lg-1" style="height:30px">
    </div>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="./views/js/charge.js"></script>

