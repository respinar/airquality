<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


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
