;(function($) {
	$(document).ready(function(){

		var calendar = $("#full-calendar");
		
		calendar.fullCalendar({
			events: calendar.data("source"),
			defaultView: calendar.data('view')
		});

	});
	
})(jQuery);