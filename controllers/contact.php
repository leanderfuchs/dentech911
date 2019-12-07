<?php 
//------------------------------------ affichage des messages du formulaire
echo $_COOKIE['message'];

//------------------------------------ si l'utilisateur n'est pas membre...

echo '<div class="inputform">
<form action="" method="post">';

if (!$_COOKIE['username']) {
	echo '		
		<label for ="contact_email"> email* 
		<input id="contact_email" type="text" name="contact_email" style="width:250px;"></label>
		<br>
		<br>
	';
}