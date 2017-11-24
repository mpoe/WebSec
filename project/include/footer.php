<div class="footer">
	<div class="footer_logo">AvatarConnect 2017</div>
</div>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script> <!-- jquery from external source might want to download! -->
<script src="js/scrips.js"></script>

<script>
	$("#nav-search").keyup(function()
	{
		if($("#search-results").is(':empty') || $("#nav-search").val() == 0 )
		{
			console.log("Here");
			$("#search-results").empty();
			$("#search-results").hide();
		}
		searchString = $("#nav-search").val();
		$.get("api/search.php" , function(data){

			
		});
		if($("#nav-search").val().length>0){
			$("#search-results").append('<a class="dropdown-item" href="/components/forms/">Forms</a>');
		}
		if(!$("#search-results").is(':empty'))
		{
			$("#search-results").show();
		}
	})
</script>