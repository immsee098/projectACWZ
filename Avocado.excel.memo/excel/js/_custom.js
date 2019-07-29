$('#body td').on('click', function() {
	$('#body td').removeClass('on');
	$(this).addClass('on');
});

$(document).on("keydown", "textarea", function(e) {
	if ((e.keyCode == 10 || e.keyCode == 13) && e.ctrlKey) {
		$(this).parents('form').submit();
	}
});