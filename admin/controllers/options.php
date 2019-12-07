<?php 

$options= new options;

if (!empty($_POST['site_name']) AND !empty($_POST['slogan'])) {

	$options_edit = $options->edit($_POST['site_name'], $_POST['slogan']);

} else {

	 echo '<div class="error">Tous les champs doivent etre remplies.</div>';
}

$options_form = $options->form();
$options_form = explode('|', $options_form);

/*echo '<pre>';
print_r($options_form);
echo '</pre>';*/
echo $options_edit;
