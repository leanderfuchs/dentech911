<div class="center">

	<div class="info">

		Nombre de clients inscrit: <?php echo $nb_user ?>

	</div>

</div>

<?php 

//------------------------------------ editer les infos utilisateur

if ($_GET['edit_user']==1) { 

	$user_form = $user->form($_GET['user_id']);
	$user_info = explode("|", $user_form);

	/*echo "<pre>";
	echo print_r($user_info);
	echo "<pre>";*/

?>
<div class="center">

	<div class="forms">

		<form name="edit"action="" method="post">

		<label for ="type">Type :</label>
		<select name="type" id="type">
			<option value="<?php echo $user_info[9]; ?>"><?php echo $user_info[9]; ?></option>
			<? if ($user_info[9]=='user') echo '<option value="Fournisseur">Fournisseur</option>'; ?>
			<? if ($user_info[9]=='Fournisseur') echo '<option value="user">user</option>'; ?>
		</select>					
		<label for ="company">Entreprise :</label>
		<input type="text" id="company"  name="company" value="<?php echo $user_info[10]; ?>">
		
		<label for ="name">Nom :</label>
		<input type="text" id="name" name="name" value="<?php echo $user_info[1]; ?>">
		<br/>
		<label for ="address">Adresse :</label>
		<input type="text" id="address" name="address" value="<?php echo $user_info[2]; ?>">
		
		<label for ="city">Ville :</label>
		<input type="text" id="city" name="city" value="<?php echo $user_info[12]; ?>">
		
		<label for ="zip">CP :</label>
		<input type="text" id="zip" name="zip" value="<?php echo $user_info[11]; ?>">

		<label for ="tel">Tel :</label>
		<input type="text" id="tel" name="tel" value="<?php echo $user_info[3]; ?>">

		<label for ="website">Site Web :</label>
		<input type="text" id="website" name="website" value="<?php echo $user_info[5]; ?>">
		<hr>
		<label for ="comment" class="clear">Commentaire :</label> <br/>
		<textarea id="comment" name="comment"><?php echo $user_info[6]; ?></textarea>
		<br/>
		<input type="submit" name="edit" value="Metre a jour" class="button">
		</form>


	</div> <!-- form div -->

</div>
	
<? } ?>

<div class="tables" >

	 <table cellspacing="0">
	    <tr>
	        <th>ID</th>
	        <th>Type</th>
	        <th>Entreprise</th>
	        <th>Nom</th>
	        <th>Adresse</th>
	        <th>Ville</th>
	        <th>CP</th>
	        <th>Tel</th>
	        <th>Email</th>
	        <th>Site web</th>
	        <th>Commentaire</th>
	        <th>Date d'enregistrement</th>
	        <th>IP</th>
	        <th>Editer</th>
	        <th>Supprimer</th>
		</tr>

			<?php echo $member_list ?>

	</table>
</div> <!-- div table -->
















