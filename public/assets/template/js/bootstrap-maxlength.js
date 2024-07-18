$(function() {
	'use strict';

	$('#shift_no').maxlength({
		threshold: 3,
		validate: true,
		warningClass: "badge mt-1 badge-success",
		limitReachedClass: "badge mt-1 badge-danger"
	});
});