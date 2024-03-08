$(document).ready(function() {
    $( "#addTaskForm" ).validate({
		rules: {
			name: {
				required: true,
				noSpace: true, 
				rangelength:[3,50],
			},
			image:{
				extension: "jpg,jpeg",
                filesize: 2,
			}
		},
		messages:
		{
			name: {
				required: "Name is required",
				rangelength: "Please enter a name between 3 and 50 characters long.",
			},
			image:{
				extension: "Please upload valid file.",
			}
		},
        submitHandler: function (form) {
            $('#addTaskForm button[type="submit"]').attr(
                "disabled",
                true
            );
            form.submit();
        }
	});

    $( "#editTaskForm" ).validate({
		rules: {
			name: {
				required: true,
				noSpace: true,
				rangelength:[3,50],
			},
			image:{
				extension: "jpg,jpeg",
                filesize: 2,
			},
		},
		messages:
		{
			name: {
				required: "Name is required",
				rangelength: "Please enter a name between 3 and 50 characters long.",
			},
			image:{
				extension: "Please upload valid file.",
			},
		},
        submitHandler: function (form) {
            $('#editTaskForm button[type="submit"]').attr(
                "disabled",
                true
            );
            form.submit();
        }
	});

    $.validator.addMethod("noSpace", function(value, element) {
        return value.trim() !== "";
    }, "Spaces are not allowed");

	$.validator.addMethod('filesize', function (value, element, param) {
		return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than 2 MB');
});