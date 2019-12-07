<?php

$user = new user;

$user_form = $user->form($_COOKIE['username']);

//------------------------------------ mettre les donnees de la DB dans la variable form_entries
$form_entries = explode(",",$user_form);

echo $user_update;


