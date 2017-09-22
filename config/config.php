<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @package   AirQuality
 * @author    Hamid Abbaszadeh
 * @license   GNU/LGPL
 * @copyright 2015-2017
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
 * Register models
 */
 $GLOBALS['TL_MODELS']['tl_airquality_city']    = 'Respinar\AirQuality\Model\AirQualityCityModel';
 $GLOBALS['TL_MODELS']['tl_airquality_data']    = 'Respinar\AirQuality\Model\AirQualityDataModel';
 $GLOBALS['TL_MODELS']['tl_airquality_station'] = 'Respinar\AirQuality\Model\AirQualityStationModel';


/**
 * Front end modules
 */
$GLOBALS['FE_MOD']['airquality']['mod_airquality_widget'] = 'Respinar\AirQuality\Frontend\Module\ModuleAirQualityWidget';
$GLOBALS['FE_MOD']['airquality']['mod_airquality_chart']  = 'Respinar\AirQuality\Frontend\Module\ModuleAirQualityChart';