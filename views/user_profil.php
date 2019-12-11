<ul class="nav nav-pills justify-content-end mb-5">
	<li class="nav-item"> <a class="nav-link active" href="?page=user_profil">Mon profile</a></li>
	<li class="nav-item"> <a class="nav-link" href="?page=purchased_credit_table">Mes achats</a></li>
	<li class="nav-item"> <a class="nav-link" href="?page=user_used_credit_table">Mes téléchargements</a></li>
	<li class="nav-item"> <a class="nav-link" href="?page=user_invoices">Mes factures</a></li>
</ul>

<p>
	<span class="asterisk">*</span> Champ requis.
</p>

<form id="update_profil" class="visual-form-builder" method="post" action="">

	<fieldset class="fieldset  commandexfset">

		<ul class="section section-1">

			<li class="item item-text">
				<label for="name" class="desc">Nom</label>
				<h3><?php echo $user_name; ?></h3>
			</li>

			<li class="item item-email">
				<label for="email" class="desc">E-mail<span >*</span></label>
				<input type="email" name="email" id="email" value="<?php echo $user_email; ?>" class="text small">
			</li>

			<li class="item item-text">
				<label for="tel" class="desc">N° de téléphone<span >*</span></label>
				<input type="tel" name="tel" id="tel" value="<?php echo $user_tel; ?>" class="text small">
			</li>

			<li class="item item-text">
				<label for="company" class="desc">Entreprise<span >*</span></label>
				<input type="company" name="company" id="company" value="<?php echo $user_company; ?>" class="text small">
			</li>

			<li class="item item-textarea">
				<label for="address" class="desc">Adresse <span>*</span></label> 
				<textarea name="address" id="address" value="" class="textarea small"><?php echo $user_address; ?></textarea>
			</li>

			<li class="item item-text">
				<label for="city" class="desc">Ville <span>*</span></label> <input type="text" name="city" id="city" value="<?php echo $user_city; ?>" class="text medium">
			</li>

			<li class="item item-text">
				<label for="zip" class="desc">Code postal <span>*</span></label> <input type="text" name="zip" id="zip" value="<?php echo $user_zip; ?>" class="text medium">
			</li>

			<li class="item item-submit">
				<input type="submit" name="update_profil" value="Mettre à jour" class="submit">
			</li>

		</ul>
	</fieldset>
</form>
