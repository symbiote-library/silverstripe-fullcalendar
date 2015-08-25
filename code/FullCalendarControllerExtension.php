<?php
/**
 * Renders the calendar with the fullcalendar template, and returns the JSON
 * events data.
 *
 * @package silverstripe-fullcalendar
 */
class FullCalendarControllerExtension extends Extension {

  private static $allowed_actions = array(
    'full',
    'eventsdata'
  );


  public function onAfterInit(){
    $request = $this->owner->getRequest();

    if(!$request->param('Action') && $this->owner->data()->UseFullCalendar){
      return $this->owner->redirect($this->owner->Link('full'));
    }
  }

  /**
   * @return full calendar view
   */
  public function full() {

    Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');

    Requirements::javascript('fullcalendar/thirdparty/fullcalendar-2.3.1/lib/moment.min.js');
    Requirements::javascript('fullcalendar/thirdparty/fullcalendar-2.3.1/fullcalendar.min.js');

    Requirements::javascript('fullcalendar/javascript/FullCalendar.js');

    Requirements::css('fullcalendar/thirdparty/fullcalendar-2.3.1/fullcalendar.min.css');

    $basicAgenda = 'agenda';

    switch ($this->owner->data()->DefaultView) {
    case 'today':
      $view = $basicAgenda . 'Day';
    case 'week':
      $view = $basicAgenda . 'Week';
      break;
    default:
      $view = 'month';
      break;
    }
    return $this->owner->customise(array(
        'FullCalendarView' => $view
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

    // for testing
    if(!$end){
      $end = '2015-12-12';
    }

    $events = $this->owner->data()->getEventList(
      sfDate::getInstance($start)->date(),
      sfDate::getInstance($end)->date(),
      null,
      null
    );

    $result = array();

    if ($events) foreach ($events as $event) {
        $result[] = array(
          'id'        => $event->ID,
          'title'     => $event->Event()->Title,
/*
          'start'     => strtotime("$event->StartDate $event->StartTime"),
          'end'       => strtotime("$event->EndDate $event->EndTime"),
*/
          'start'     => $event->MicroformatStart(),
          'end'       => $event->MicroformatEnd(),
          'startTime' => $event->getFormattedStartTime(),
          'endTime'   => $event->getFormattedEndTime(),
          'allDay'    => (bool) $event->AllDay,
          'url'       => $event->Link(),
          //'className' => $event->Event()->Parent()->ElementName());
        );
      }

/*
    $this->owner->getRequest()->addHeader('Content-Type', 'application/json');
    return Convert::array2json($result);
*/

    $response = new SS_HTTPResponse(Convert::array2json($result));
    $response->addHeader('Content-Type', 'application/json');
    return $response;

  }

}
