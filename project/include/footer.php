<div class="footer">
	<div class="footer_logo">AvatarConnect 2017</div>
</div>

<script src="dist/jquery-3.2.1.min.js"></script>
<script src="js/scrips.js"></script>

<script>
	$("#nav-search").keyup(function()
	{
		
			$.ajax({
				url: "api/search.php",
				"method":"get",
				"cache":false,
				dataType: "json",
				data : { searchString : $("#nav-search").val()},
				success: function(jUserData) {
						$("#search-results").empty();
						for(var i = 0; i<jUserData.length;i++)
						{
							var sLinkBlueprint = '<a class="dropdown-item" href="user.php?id={{userid}}">{{avatarname}}</a>';

							var sLinkTemplate = sLinkBlueprint;

							sLinkTemplate = sLinkTemplate.replace("{{userid}}",jUserData[i].id);
							sLinkTemplate = sLinkTemplate.replace("{{avatarname}}",jUserData[i].avatarname);

							$("#search-results").append(sLinkTemplate);
						}
					}
		});

		if($("#search-results").is(':empty') && $("#nav-search").val().length == 0 )
		{
			//Not working selector
		}
		
		if(!$("#search-results").is(':empty'))
		{
			$("#search-results").show();
		}
		if($("#search-results").is(':empty'))
		{
			$("#search-results").append("<p>No results</p>");
			$("#search-results").show();
		}
	})

</script>