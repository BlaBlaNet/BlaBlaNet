/**
 * JavaScript for mod/chat
 */

$(document).ready(function() {
	$('#contact_allow, #contact_deny, #group_allow, #group_deny').change(function() {
		var selstr;
		$('#contact_allow option:selected, #contact_deny option:selected, #group_allow option:selected, #group_deny option:selected').each( function() {
			selstr = $(this).text();
			$('#jot-perms-icon').removeClass('fa-unlock').addClass('fa-lock');
			$('#jot-public').hide();
		});
		if(selstr === null) {
			$('#jot-perms-icon').removeClass('fa-lock').addClass('fa-unlock');
			$('#jot-public').show();
		}
	}).trigger('change');

	$('#chatText').bbco_autocomplete('bbcode');

});
