$(function(){	
	$("#login").click(function() {
		var action = $("#login_form").attr("action");
		var form_data = {
			email : $("#email").val(),
			password : $("#password").val(),
			is_ajax: 1
		};
		$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				success: function(response) {
					if( response == "success")
					{
						$("#message").html("<p class='success'> You have logged in successfully! </p>");
					}
					else
					{
						$("#message").html("<p class='error'>Invalid username and/or password. </p>");
					}
				}
			});
			return false;
	});
	$("#logout").click(function() {
		var action = $("#logout_button").attr("action");
		$.ajax({
				type: "POST",
				url: action,
				data: 0,
				success: function(response){
					$("$message").html("<p class='success'> You have logged out successfully! </p>");
				}
				});
			return false;
	});
});