<?php 
	if (!empty ($msg)){echo $msg;}
?>
<div class="visual-form-builder-container">
	<form id="login" class="visual-form-builder" method="post" action="?page=order&welcome-back=true">

		<fieldset class="fieldset  commandexfset">
			<ul class="section section-1">
				<div class="center">

					<li class="item item-text">
						<label for="login-email" class="desc">email</label>
						<input type="email" name="login-email" id="login-email" value="<?php if(!empty($_POST['login-email'])){echo $_POST['login-email'];} ?>" class="text small">
					</li>

					<li class="item item-text">
						<label for="login-password" class="desc">Mot de passe</label>
						<input type="password" name="login-password" id="login-password" value="" class="text small">
					</li>

	 				<li class="item item-checkbox">
						Se souvenir de moi
						<input type="checkbox" name="remember" id="remember" value="remember" >
					</li>

				</div>

				<li class="item item-submit">
					<input type="submit" name="login" value="Connexion" class="submit">
				</li>

			</ul>
		</fieldset>

	</form>

	<div class="center">

		Mot de passe perdu ? <a href="?page=lost_password">cliquez ici</a>

	</div>
	<br/>
	<div class="sep"></div>
	<div class="center">

		<h3>Pas encore enregistré ?</h3>
		
		<div class="visual-form-builder-container">
	<form id="register" class="visual-form-builder" method="post" action="?page=order&welcome=true">
		<fieldset class="fieldset  commandexfset">
			<ul class="section section-1">
				<li class="item item-text left-half">
					<label for="company" class="desc">Société <span>*</span></label> <input type="text" name="company" id="company" value="<?php if(!empty($_POST['company'])){echo $_POST['company']; }?>" class="text medium">
				</li>
				<li class="item item-text right-half">
					<label for="name" class="desc">Nom, Prénom <span>*</span></label> <input type="text" name="name" id="name" value="<?php if(!empty($_POST['name'])){echo $_POST['name']; }?>" class="text medium">
				</li>
				
				<li class="item item-textarea">
					<label for="adresse" class="desc">Adresse <span>*</span></label> 
					<textarea name="adresse" id="adresse" value="" class="textarea small"><?php if(!empty($_POST['adresse'])){echo $_POST['adresse']; }?></textarea>
				</li>

				<li class="item item-text left-half">
					<label for="city" class="desc">Ville <span>*</span></label> <input type="text" name="city" id="city" value="<?php if(!empty($_POST['city'])){echo $_POST['city']; }?>" class="text medium">
				</li>

				<li class="item item-text right-half">
					<label for="zip" class="desc">Code postal <span>*</span></label> <input type="text" name="zip" id="zip" value="<?php if(!empty($_POST['zip'])){echo $_POST['zip']; }?>" class="text medium">
				</li>

				<li class="item item-phone left-half">
					<label for="tel" class="desc">Téléphone<span>*</span></label></label> <input type="text" name="tel" id="tel" value="<?php if(!empty($_POST['tel'])){echo $_POST['tel']; }?>" class="text medium">
				</li>

				<li class="item item-email left-half">
					<label for="email" class="desc">Votre Adresse e-mail <span>*</span></label> <input type="email" name="email" id="email" value="<?php if(!empty($_POST['email'])){echo $_POST['email']; }?>" class="text medium">
				</li>

				<li class="item item-password right-half">
					<label for="password" class="desc">Mot de passe <span>*</span></label> <input type="password" name="password" id="password" value="<?php if(!empty($_POST['password'])){echo $_POST['password']; }?>" class="text medium">
				</li>

				<li class="item item-submit">
					<input type="submit" name="inscription" value="Inscription" class="submit" id="sendmail">
				</li>
			</ul><br>
		</fieldset>
	</form>
</div>
