<?php
/**
 * Adds a field to the default calendar which allows an admin to enable or
 * disable the fullcalendar view.
 *
 * @package silverstripe-fullcalendar
 */
class FullCalendarExtension extends DataExtension {

	public static $db = array(
		'UseFullCalendar' => 'Boolean'
	);
	
	public static $defaults = array(
		'UseFullCalendar' => 1
	);

	public function updateSettingsFields(FieldList $fields) {
		$fields->addFieldToTab('Root.Settings', CheckboxField::create('UseFullCalendar', _t('FullCalendarExtension.DisplayInFullLayout', 'Display in a full calendar layout?')));
	}

}
