<?php
/**
 * Adds a field to the default calendar which allows an admin to enable or
 * disable the fullcalendar view.
 *
 * @package silverstripe-fullcalendar
 */
class FullCalendarExtension extends DataObjectDecorator {

	public function extraStatics() {
		return array(
			'db'       => array('UseFullCalendar' => 'Boolean'),
			'defaults' => array('UseFullCalendar' => true)
		);
	}

	public function updateCMSFields($fields) {
		$check = new CheckboxField(
			'UseFullCalendar',
			_t('FullCalendar.DISPLAYINFULLLAYOUT', 'Display in a full calendar layout?')
		);
		$fields->addFieldToTab('Root.Behaviour', $check, 'ShowInMenus');
	}

}