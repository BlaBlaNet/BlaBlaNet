$(document).ready(function() { 
	$("#poke-recip").name_autocomplete(baseurl + '/acl', 'a', false, function(data) {
		$("#poke-recip-complete").val(data.id);
	});
}); 
