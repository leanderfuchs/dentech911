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

    <h4><span class="badge badge-secondary mb-4">Aujourd'hui 1 point = <? echo $_SESSION['point_value'] ?>€ | <span style="color:gold">*Achat minimum: <? echo $_SESSION['min_point'] ?> points</span></span></h4>

    <form action="../charge.php" method="post" id="payment-form" name="stripe-form">
        <div class="form-row mt-1">

            <!-- inputs -->
            <input type="text" id="qty" name="qty" class="form-control mt-3 StripeElement StripeElement--empty" placeholder="Combien de points avez-vous besoin* ?" onkeyup="calculate_total()">
            <div class="small ml-1" style="color:red" id="low_point"><? echo $point_error_message?></div>

            <input type="text" name="first_name" id="first_name" class="form-control mt-3 StripeElement StripeElement--empty" placeholder="Nom">
            <div class="small ml-1" style="color:red" id="missing_first_name"><? echo $missing_first_name?></div>

           <input type="text" name="last_name" id="last_name" class="form-control mt-3 StripeElement StripeElement--empty" placeholder="Prenom">
           <div class="small ml-1" style="color:red" id="missing_last_name"><? echo $missing_last_name?></div>

            <input type="email" name="email" id="email" class="form-control mt-3 StripeElement StripeElement--empty" placeholder="Email">
            <div class="small ml-1" style="color:red" id="missing_email"><? echo $missing_email?></div>

            <input class="hidden" name="user_id" type="text" value="<? echo $_SESSION['user_id']; ?>">
            <input class="hidden" id="point_val" type="text" value="<? echo $_SESSION['point_value']; ?>">
            <input class="hidden" id="min-point" type="text" value="<? echo $_SESSION['min_point']; ?>">
            <input class="hidden" name="amount" type="text" id="amount">

            <!-- total -->
            <div class="container-fluid text-center">
                <h4> Le total de votre commande est de <b><span id="show_total">0.00€</span></b></h4>
            </div>
            <!-- Stripe -->
            <div id="card-element" class="form-control">
                <!-- a Stripe Element will be inserted here. -->
            </div>

                <!-- Used to display form errors -->
            <div id="card-errors" role="alert"></div>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-lg-3">
                <button onclick="validateForm()">Acheter</button>
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

  <script>
    function calculate_total(){
        var qty = document.getElementById("qty").value;
        var min_point = document.getElementById("min-point").value;
        var point_val = document.getElementById("point_val").value;
        var total_amount = qty*point_val;
        var show_amount = document.getElementById("show_total").innerHTML = total_amount.toFixed(2)+'€';
        var stripe_total_amount = total_amount*100;
        //alert(stripe_total_amount);
        document.getElementById("amount").value = stripe_total_amount.toFixed(0);
    }

    function validateForm() {
       // nbr of points
        var point = document.getElementById("qty").value; 
        if (isNaN(point) || point < 5) {
            document.getElementById("low_point").innerHTML = "Le nombre de points n'est pas suffisant";
            return false;
        } else {
            document.getElementById("low_point").innerHTML = "";
        }
       // nom
        var first_name = document.getElementById("first_name").value; 
        if (isNaN(first_name) || first_name == "") {
            document.getElementById("missing_first_name").innerHTML = "Vous devez entrer votre nom";
            return false;
        } else {
            document.getElementById("missing_first_name").innerHTML = " ";
        }
       // prénom
        var last_name = document.getElementById("last_name").value; 
        if (isNaN(last_name) || last_name == "") {
            document.getElementById("missing_last_name").innerHTML = "Vous devez entrer votre prénom";
            return false;
        } else {
            document.getElementById("missing_last_name").innerHTML = "";
        }
       // email
        var email = document.getElementById("email").value; 
        if (isNaN(email) || email == "") {
            document.getElementById("email").innerHTML = "Vous devez entrer votre email";
            return false;
        } else {
            document.getElementById("email").innerHTML = "";
        }
    } 
</script>