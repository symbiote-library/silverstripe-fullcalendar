<?php
/**
 * Renders the calendar with the fullcalendar template, and returns the JSON
 * events data.
 *
 * @package silverstripe-fullcalendar
 */
class FullCalendarControllerExtension extends Extension {

	public static $allowed_actions = array(
		'eventsdata'
	);

	/**
	 * @return string|array
	 */
	public function index() {
		if (!$this->owner->UseFullCalendar) return array();

		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript('fullcalendar/thirdparty/jquery-fullcalendar/fullcalendar.js');
		Requirements::javascript('fullcalendar/javascript/FullCalendar.js');
		Requirements::css('fullcalendar/thirdparty/jquery-fullcalendar/fullcalendar.css');

		return $this->owner->renderWith(array(
			'FullCalendar', 'CalendarPage', 'Page', 'ContentController'
		));
	}

	/**
	 * Handles returning the JSON events data for a time range.
	 *
	 * @param  SS_HTTPRequest $request
	 * @return SS_HTTPResponse
	 */
	public function eventsdata($request) {
		$start = $request->getVar('start');
		$end   = $request->getVar('end');

		$events = $this->owner->data()->Events(null, $start, $end);
		$result = array();

		if ($events) foreach ($events as $event) {
			$result[] = array(
				'id'        => $event->ID,
				'title'     => $event->EventTitle(),
				'start'     => $event->getStartTimestamp(),
				'end'       => $event->getEndTimestamp(),
				'allDay'    => (bool) $event->is_all_day,
				'url'       => $event->Link(),
				'className' => $event->Event()->Parent()->ElementName());
		}

		$response = new SS_HTTPResponse(Convert::array2json($result));
		$response->addHeader('Content-Type', 'application/json');
		return $response;
	}

}