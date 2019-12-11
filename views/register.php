<?php echo $user_register; ?>
<i><a href="?page=login" style="color:#7f7f7f;">Vous avez déjà un compte ?</a></i>
<div class="visual-form-builder-container">
	<form id="register" class="visual-form-builder" method="post" action="">
		<fieldset class="fieldset  commandexfset">
			<ul class="section section-1">
				<li class="item item-text left-half">
					<label for="company" class="desc">Société <span>*</span></label> <input type="text" name="company" id="company" value="<?php echo $_POST['company']; ?>" class="text medium">
				</li>
				<li class="item item-text right-half">
					<label for="name" class="desc">Nom, Prénom <span>*</span></label> <input type="text" name="name" id="name" value="<?php echo $_POST['name']; ?>" class="text medium">
				</li>
				
				<li class="item item-textarea">
					<label for="adresse" class="desc">Adresse <span>*</span></label> 
					<textarea name="adresse" id="adresse" value="" class="textarea small"><?php echo $_POST['adresse']; ?></textarea>
				</li>

				<li class="item item-text left-half">
					<label for="city" class="desc">Ville <span>*</span></label> <input type="text" name="city" id="city" value="<?php echo $_POST['city']; ?>" class="text medium">
				</li>

				<li class="item item-text right-half">
					<label for="zip" class="desc">Code postal <span>*</span></label> <input type="text" name="zip" id="zip" value="<?php echo $_POST['zip']; ?>" class="text medium">
				</li>

				<li class="item item-phone left-half">
					<label for="tel" class="desc">Téléphone<span>*</span></label></label> <input type="text" name="tel" id="tel" value="<?php echo $_POST['tel']; ?>" class="text medium">
				</li>

				<li class="item item-email left-half">
					<label for="email" class="desc">Votre Adresse e-mail <span>*</span></label> <input type="email" name="email" id="email" value="<?php echo $_POST['email']; ?>" class="text medium">
				</li>

				<li class="item item-password right-half">
					<label for="password" class="desc">Mot de passe <span>*</span></label> <input type="password" name="password" id="password" value="<?php echo $_POST['password']; ?>" class="text medium">
				</li>

				<li class="item item-submit">
					<input type="submit" name="inscription" value="Inscription" class="submit" id="sendmail">
				</li>
			</ul><br>
		</fieldset>
	</form>
</div>
		