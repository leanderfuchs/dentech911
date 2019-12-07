
$(function() {

	$.datepicker.setDefaults( $.datepicker.regional['fr'] );

	$('#datepicker').datepicker({ 
		dateFormat: 'yy-mm-dd',
		minDate: 0,
		maxDate: 20
	});

	$('#from').datepicker({ 
		dateFormat: 'yy-mm-dd'
	});

	$('#to').datepicker({ 
		dateFormat: 'yy-mm-dd'

	});

});