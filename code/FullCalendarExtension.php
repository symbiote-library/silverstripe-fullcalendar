<?php
/**
 * Adds a field to the default calendar which allows an admin to enable or
 * disable the fullcalendar view.
 *
 * @package silverstripe-fullcalendar
 */
class FullCalendarExtension extends DataExtension {

	private static $db = array(
		'UseFullCalendar' => 'Boolean'
	);

	private static $defaults = array(
		'UseFullCalendar' => 1
	);

	
	public function updateSettingsFields(FieldList $fields) {
		$check = new CheckboxField(
			'UseFullCalendar',
			_t('FullCalendar.DISPLAYINFULLLAYOUT', 'Display in a full calendar layout?')
		);
		$fields->addFieldToTab('Root.Settings', $check, 'ShowInMenus');
	}

}