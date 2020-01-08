<script type='text/javascript'>

/* attach a submit handler to the form */
$(document).ready(function(){

	$("#form").submit(function(event){

		/* stop form from submitting normally */
		event.preventDefault();

		/* get some values from elements on the page: */
		var $form = $( this ),
		query = $form.find( 'input[name="query"]' ).val(),
		from = $form.find( 'input[name="from"]' ).val(),
		to = $form.find( 'input[name="to"]' ).val();
		user_id = $form.find( 'input[name="user_id"]' ).val();

		/* Send the data using post */

		$.post("views/js/db_search_results.php",{query:query, from:from, to:to, user_id:user_id},function(result){	
			$("#autoupdate").html(result);
    	});

	});
});

</script>
<div class="query">

	<form action="" name="form" id="form" method="post" class="visual-form-builder">

		<fieldset class="fieldset  commandexfset">
				<div class="center">
					<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">

					Requête:
						<input type="text" name="query" id="query" value="<?php if(isset($_POST['query']))echo $_POST['query']; ?>" style="height:20px;width:200px;">
	 				Entre le : 
	 					<input type="text" name="from" id="from" value="<?php if(isset($_POST['from']))echo $_POST['from']; ?>" style="height:20px;width:200px;">
	 				et le : 
	 					<input type="text" name="to" id="to" value="<?php if(isset($_POST['to']))echo $_POST['to']; ?>" 	style="height:20px;width:200px;">

					<br/><br/>

					<input type="submit" id="submit" name="submit" value="Chercher" class="submit">
				</div>
		</fieldset>
	</form>	

</div>

<div class='listing'>
	<div class="full_width_panel_short" name="autoupdate" id="autoupdate"> </div> 
</div>