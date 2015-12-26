<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package   AirQuality
 * @author    Hamid Abbaszadeh
 * @license   GNU/LGPL
 * @copyright 2015
 */


/**
 * Table tl_airquality_data
 */
$GLOBALS['TL_DCA']['tl_airquality_data'] = array
(

	// Config
	'config' => array
	(

		'dataContainer'			=> 'Table',
		'ptable'			=> 'tl_airquality_station',
		'enableVersioning'		=> true,
		'onsubmit_callback' => array
		(
			array('tl_airquality_data', 'evaluateAQI')
		),
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid'=> 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('date DESC'),
			'headerFields'            => array('title'),
			'panelLayout'             => 'search,limit',
			'child_record_callback'   => array('tl_airquality_data', 'generateRow')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_airquality_data']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_airquality_data']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_airquality_data']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                   => '{date_legend},date;{pm_legend},PM25,PM10,total;{other_legend:hode},CO,NO2,SO2,O3'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'date' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['date'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'sorting'                 => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true,'rgxp'=>'date', 'doNotCopy'=>true, 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'PM25' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['PM25'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					            => "varchar(10) NOT NULL default '0'"
		),
		'PM10' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['PM10'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					            => "varchar(10) NOT NULL default '0'"
		),
		'CO' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['CO'],
			'inputType'               => 'text',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					            => "varchar(10) NOT NULL default '0'"
		),
		'PB' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['PB'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'			          		  => "varchar(10) NOT NULL default '0'"
		),
		'NO2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['NO2'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					            => "varchar(10) NOT NULL default '0'"
		),
		'O3' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['O3'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('multiple'=>true,'size'=>2, 'tl_class'=>'w50'),
			'sql'					            => "varchar(255) NOT NULL default '0'"
		),
		'SO2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['SO2'],
			'inputType'               => 'text',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					            => "varchar(10) NOT NULL default '0'"
		),
		'AQI_MAX' => array
		(
			'sql'		                  => "varchar(255) NOT NULL default ''"
		),
		'AQI_ALL' => array
		(
			'sql'		                  => "blob NULL"
		)
	)
);

/**
 * Provide miscellaneous methods that are used by the data configuration array
 */
class tl_airquality_data extends Backend
{

	/**
	 * Generate a row and return it as HTML string
	 * @param array
	 * @return string
	 */
	public function generateRow($arrRow)
	{

		//$aqi = new \AirQuality($arrRow);

		$aqitext = '';

		$AirQualityIndexes = deserialize($arrRow['AQI_ALL']);
		$AirQualityIndex = deserialize($arrRow['AQI_MAX']);

		foreach ($AirQualityIndexes as $aqiv)
		{
			if ($AirQualityIndex[parameter] == $aqiv[parameter]) $max = 'max '; else $max = '';
			$aqitext = $aqitext . ' <span class="aqi '.$max.$aqiv[level].'">'.$aqiv[parameter].' ('.$aqiv[value].')</span>';
		}

		return '<div><span style="color:#b3b3b3;padding-right:3px">[' . Date::parse(Config::get('dateFormat'), $arrRow['date']) . ']</span> '. $aqitext.'</div>';
	}


	/**
	 * Adjust start end end time of the event based on date, span, startTime and endTime
	 * @param \DataContainer
	 */
	public function evaluateAQI(DataContainer $dc)
	{
		// Return if there is no active record (override all)
		if (!$dc->activeRecord)
		{
			return;
		}

		$aqi = new \AirQuality($dc->activeRecord);

		$arrSet['AQI_MAX'] = $aqi->AirQualityIndex;
		$arrSet['AQI_ALL'] = $aqi->AirQualityIndexes;

		$this->Database->prepare("UPDATE tl_airquality_data %s WHERE id=?")->set($arrSet)->execute($dc->id);
	}

}
