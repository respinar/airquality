<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
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
	'AirQuality\AirQualityCityModel'    => 'system/modules/airquality/models/AirQualityCityModel.php',
	'AirQuality\AirQualityDataModel'    => 'system/modules/airquality/models/AirQualityDataModel.php',
	'AirQuality\AirQualityStationModel' => 'system/modules/airquality/models/AirQualityStationModel.php',

	// Modules
	'AirQuality\ModuleAirQualityFull'   => 'system/modules/airquality/modules/ModuleAirQualityFull.php',
	'AirQuality\ModuleAirQualityWidget' => 'system/modules/airquality/modules/ModuleAirQualityWidget.php',
	'AirQuality\ModuleAirQuality'       => 'system/modules/airquality/modules/ModuleAirQuality.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    'charts_bar'            => 'system/modules/airquality/templates/charts',
	'charts_chart'          => 'system/modules/airquality/templates/charts',
	'mod_airquality_full'   => 'system/modules/airquality/templates/modules',
	'mod_airquality_widget' => 'system/modules/airquality/templates/modules',
));
