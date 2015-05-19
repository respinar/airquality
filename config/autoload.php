<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package Airquality
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'AirQuality',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'AirQuality\AirQuality'             => 'system/modules/airquality/classes/AirQuality.php',

	// Models
	'AirQuality\AirQualityDataModel'    => 'system/modules/airquality/models/AirQualityDataModel.php',
	'AirQuality\AirQualityCityModel'    => 'system/modules/airquality/models/AirQualityCityModel.php',
	'AirQuality\AirQualityStationModel' => 'system/modules/airquality/models/AirQualityStationModel.php',

	// Modules
	'AirQuality\ModuleAirQualityWidget' => 'system/modules/airquality/modules/ModuleAirQualityWidget.php',
	'AirQuality\ModuleAirQualityFull'   => 'system/modules/airquality/modules/ModuleAirQualityFull.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_airquality_full'   => 'system/modules/airquality/templates/modules',
	'mod_airquality_widget' => 'system/modules/airquality/templates/modules',
	'mod_airquality_empty'  => 'system/modules/airquality/templates/modules',
	'chartempty'            => 'system/modules/airquality/templates/charts',
	'charts_bar'            => 'system/modules/airquality/templates/charts',
));
