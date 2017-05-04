<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Respinar\AirQuality',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Library
	'Respinar\AirQuality\AirQuality'             => 'system/modules/airquality/library/Respinar/AirQuality/AirQuality.php',
	'Respinar\AirQuality\AirQualityStationModel' => 'system/modules/airquality/library/Respinar/AirQuality/Models/AirQualityStationModel.php',
	'Respinar\AirQuality\AirQualityDataModel'    => 'system/modules/airquality/library/Respinar/AirQuality/Models/AirQualityDataModel.php',
	'Respinar\AirQuality\AirQualityCityModel'    => 'system/modules/airquality/library/Respinar/AirQuality/Models/AirQualityCityModel.php',
	'Respinar\AirQuality\ModuleAirQualityWidget' => 'system/modules/airquality/library/Respinar/AirQuality/Frontend/Modules/ModuleAirQualityWidget.php',
	'Respinar\AirQuality\ModuleAirQualityChart'  => 'system/modules/airquality/library/Respinar/AirQuality/Frontend/Modules/ModuleAirQualityChart.php',
	'Respinar\AirQuality\ModuleAirQuality'       => 'system/modules/airquality/library/Respinar/AirQuality/Frontend/ModuleAirQuality.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_airquality_widget' => 'system/modules/airquality/templates/modules',
	'mod_airquality_chart'  => 'system/modules/airquality/templates/modules',
	'airquality_chart'      => 'system/modules/airquality/templates/airquality',
	'airquality_bar'        => 'system/modules/airquality/templates/airquality',
));
