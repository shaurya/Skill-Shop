<?php
	session_start();
?>
<html>
<head>
	<?php include 'head.php'?>
</head>
<body>
<?php
	include 'header.php';
?>

<script type="text/javascript">
$(function(){	
	$("#login").click(function() {
		var action = $("#login_form").attr("action");
		var form_data = {
			email: $("#email").val(),
			password: $("#password").val(),
			is_ajax: 1
		};
		$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				success: function(response) {
					if( response == "success")
					{
						window.location.href = 'home.php';
					}
					else
					{
						window.location.href = 'index.php';
					}
				}
			});
		$(this).popup('close');
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
</script>

<br><br>
<div id="content">
	<form action="search.php" method="post">
		<div data-role="fieldcontain">
			<input type="search" name="skill_search" id="skill_search" value="" placeholder="Search..." />
			<br/>
		</div>
	</form>

	<div data-role="collapsible-set" data-theme="a" data-content-theme="d">
		<div data-role="collapsible">
			<h2>Sports</h2>
			<ul data-role="listview" data-filter="true" data-filter-theme="f" data-divider-theme="d">
				<li><a href="search.php?target=basketball">Basketball</a></li>
				<li><a href="search.php?target=tennis">Tennis</a></li>
				<li><a href="search.php?target=swimming">Swimming</a></li>
				<li><a href="search.php?target=raquetball">Raquetball</a></li>
				<li><a href="search.php?target=basketball">Football</a></li>
			</ul>
		</div>
			
		<div data-role="collapsible">
			<h2>Music</h2>
			<ul data-role="listview" data-filter="true" data-filter-theme="c" data-divider-theme="d">
				<li><a href="search.php?target=piano">Piano</a></li>
				<li><a href="search.php?target=guitar">Guitar</a></li>
				<li><a href="search.php?target=percussion">Percussion</a></li>
				<li><a href="search.php?target=theory">Theory</a></li>
				<li><a href="search.php?target=singing">Singing</a></li>
			</ul>
		</div>
		
		<div data-role="collapsible">
			<h2>Art</h2>
			<ul data-role="listview" data-filter="true" data-filter-theme="c" data-divider-theme="d">
				<li><a href="search.php?target=pencil%20drawing">Pencil Drawing</a></li>
				<li><a href="search.php?target=sculpture"> Sculpture</a></li>
				<li><a href="search.php?target=painting">Painting</a></li>
				<li><a href="search.php?target=graphic%20art">Graphic Art</a></li>
				<li><a href="search.php?target=jewerly">Jewelry</a></li>
			</ul>
		</div>
		<div data-role="collapsible">
			<h2>Academics</h2>
			<ul data-role="listview" data-filter="true" data-filter-theme="c" data-divider-theme="d">
				<li><a href="search.php?target=physics">Physics</a></li>
				<li><a href="search.php?target=chemistry">Chemistry</a></li>
				<li><a href="search.php?target=calculus">Calculus</a></li>
				<li><a href="search.php?target=biology">Biology</a></li>
				<li><a href="search.php?target=english">English</a></li>
			</ul>
		</div>
		
		<div data-role="collapsible">
			<h2>Crafts</h2>
			<ul data-role="listview" data-filter="true" data-filter-theme="c" data-divider-theme="d">
				<li><a href="search.php?target=weaving">Weaving</a></li>
				<li><a href="search.php?target=quilt%20knitting">Quilt Knitting</a></li>
				<li><a href="search.php?target=crochet">Crocheting</a></li>
				<li><a href="search.php?target=bracelets">Bracelets</a></li>
				<li><a href="search.php?target=model%20cars">Model Cars</a></li>
			</ul>
		</div>
		
		<div data-role="collapsible">
		<h2>Miscellaneous</h2>
			<ul data-role="listview" data-filter="true" data-filter-theme="c" data-divider-theme="d">
				<li><a href="search.php?target=juggling">Juggling</a></li>
				<li><a href="search.php?target=balancing">Balancing</a></li>
				<li><a href="search.php?target=magic">Magic</a></li>
				<li><a href="search.php?target=changing%20oil">Changing Oil</a></li>
				<li><a href="search.php?target=archery">Archery</a></li>
			</ul>
		</div>
	</div>
</div>

</body>
</html>