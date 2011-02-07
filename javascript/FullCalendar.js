;(function($) {
	$("#full-calendar").fullCalendar({
		events: $("#full-calendar").attr("href")
	});
})(jQuery);