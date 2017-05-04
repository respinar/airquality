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
			'sql'					  => "varchar(10) NOT NULL default '0'"
		),
		'PM10' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['PM10'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('mandatory'=>true, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					  => "varchar(10) NOT NULL default '0'"
		),
		'CO' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['CO'],
			'inputType'               => 'text',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					  => "varchar(10) NOT NULL default '0'"
		),
		'PB' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['PB'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'			          => "varchar(10) NOT NULL default '0'"
		),
		'NO2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['NO2'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					  => "varchar(10) NOT NULL default '0'"
		),
		'O3' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['O3'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'search'                  => false,
			'eval'                    => array('multiple'=>true,'size'=>2, 'tl_class'=>'w50'),
			'sql'					  => "varchar(255) NOT NULL default 'a:2:{i:0;s:1:\"0\";i:1;s:1:\"0\";}'"
		),
		'SO2' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_airquality_data']['SO2'],
			'inputType'               => 'text',
			'exclude'                 => true,
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'maxlength'=>6, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'					  => "varchar(10) NOT NULL default '0'"
		),
		'AQI_PM25' => array
		(
			'sql'		                  => "varchar(10) NOT NULL default ''"
		),
		'AQI_PM10' => array
		(
			'sql'		                  => "varchar(10) NOT NULL default ''"
		),
		'AQI_CO' => array
		(
			'sql'		                  => "varchar(10) NOT NULL default ''"
		),
		'AQI_SO2' => array
		(
			'sql'		                  => "varchar(10) NOT NULL default ''"
		),
		'AQI_NO2' => array
		(
			'sql'		                  => "varchar(10) NOT NULL default ''"
		),
		'AQI_O3' => array
		(
			'sql'		                  => "varchar(10) NOT NULL default ''"
		),
		'AQI' => array
		(
			'sql'		                  => "varchar(10) NOT NULL default ''"
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

		$aqitext = '<span class="aqi max '.AirQuality::aqi_level($arrRow[AQI]).'">AQI '.$arrRow[AQI].'</span>';

		$aqitext = $aqitext . ' <span class="aqi '.AirQuality::aqi_level($arrRow[AQI_PM25]).'"> PM2.5 ('.$arrRow[AQI_PM25].')</span>';
		$aqitext = $aqitext . ' <span class="aqi '.AirQuality::aqi_level($arrRow[AQI_PM10]).'"> PM10 ('.$arrRow[AQI_PM10].')</span>';
		$aqitext = $aqitext . ' <span class="aqi '.AirQuality::aqi_level($arrRow[AQI_CO]).'"> CO ('.$arrRow[AQI_CO].')</span>';
		$aqitext = $aqitext . ' <span class="aqi '.AirQuality::aqi_level($arrRow[AQI_NO2]).'"> NO2 ('.$arrRow[AQI_NO2].')</span>';
		$aqitext = $aqitext . ' <span class="aqi '.AirQuality::aqi_level($arrRow[AQI_SO2]).'"> SO2 ('.$arrRow[AQI_SO2].')</span>';
		$aqitext = $aqitext . ' <span class="aqi '.AirQuality::aqi_level($arrRow[AQI_O3]).'"> O3 ('.$arrRow[AQI_O3].')</span>';

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

		$arrSet['AQI_PM25'] = $aqi->AQI_PM25;
		$arrSet['AQI_PM10'] = $aqi->AQI_PM10;
		$arrSet['AQI_CO']   = $aqi->AQI_CO;
		$arrSet['AQI_NO2']  = $aqi->AQI_NO2;
		$arrSet['AQI_SO2']  = $aqi->AQI_SO2;
		$arrSet['AQI_O3']   = $aqi->AQI_O3;
		$arrSet['AQI']      = $aqi->AQI;

		$this->Database->prepare("UPDATE tl_airquality_data %s WHERE id=?")->set($arrSet)->execute($dc->id);
	}

}
