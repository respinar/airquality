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

array_insert($GLOBALS['BE_MOD']['content'], 1, array
(
	'airquality' => array
	(
		'tables'     => array('tl_airquality_city','tl_airquality_station','tl_airquality_data'),
		'icon'       => 'system/modules/airquality/assets/icon.png',
		'stylesheet' => 'system/modules/airquality/assets/styles/airquality_be.css',
	)
));

/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['airquality']['mod_airquality_widget'] = 'Respinar\AirQuality\ModuleAirQualityWidget';
$GLOBALS['FE_MOD']['airquality']['mod_airquality_chart']  = 'Respinar\AirQuality\ModuleAirQualityChart';