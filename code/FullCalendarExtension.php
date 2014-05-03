<?php
/**
 * Adds a field to the default calendar which allows an admin to enable or
 * disable the fullcalendar view.
 *
 * @package silverstripe-fullcalendar
 */
class FullCalendarExtension extends DataExtension {

	static public $db = array(
		'UseFullCalendar' => 'Boolean'
	);
	
	static public $defaults = array(
		'UseFullCalendar' => 1
	);

	public function updateSettingsFields(FieldList $fields) {
		$fields->addFieldToTab('Root.Settings', CheckboxField::create('UseFullCalendar', _t('FullCalendarExtension.DISPLAYINFULLLAYOUT', 'Display in a full calendar layout?')));
	}

}
