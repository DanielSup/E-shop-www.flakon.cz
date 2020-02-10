$(document).ready(function() {
	console.log("ready");
	$('#searchcountries').on('input', function(){
		value = $("#searchcountries").val();
		$(".country").each(function() {
			heading = $(this).find("h3").first();
			country_title = heading.clone().children().remove().end().text();
			if (country_title.includes(value)) {
				$(this).show();
			} else {
				$(this).hide();
			}
		});
	});
});