<div class="container mt-4">
    <div class="lead">Félicitation</div>
    <hr>

    <div class="alert alert-success" role="alert">
        Vous avez maintenant <strong><? echo $_SESSION['balance'];?></strong> points dans votre compte
    </div>

    <p>L'identifiant de votre commande est : <strong><?php echo $tid; ?></strong></p>
    <p>Vous allez recevoir un email de confirmation dans quelques minutes</p>
</div>
