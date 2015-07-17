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
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['mod_airquality_widget'] = '{title_legend},name,type,headline;
                                                                        {airquality_legend},airquality_city;
                                                                        {parameters_legend},airquality_parameters;
                                                                        {chart_legend:hide},chartTemplate,chartSize;
                                                                        {protected_legend:hide},protected;
                                                                        {expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['mod_airquality_full']   = '{title_legend},name,type,headline;
                                                                        {parameters_legend},airquality_parameters;
                                                                        {chart_legend:hide},chartTemplate,chartSize;
                                                                        {protected_legend:hide},protected;
                                                                        {expert_legend:hide},guests,cssID,space';


/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['airquality_city'] = array
(
	'label'                => &$GLOBALS['TL_LANG']['tl_module']['airquality_city'],
	'exclude'              => true,
	'inputType'            => 'radio',
	'foreignKey'           => 'tl_airquality_city.title',
	'eval'                 => array('multiple'=>true, 'mandatory'=>true),
	'sql'				   => "int(10) unsigned NOT NULL default '0'",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['chartTemplate'] = array
(
	'label'                => &$GLOBALS['TL_LANG']['tl_module']['chartTemplate'],
	'exclude'              => true,
	'inputType'            => 'select',
	'options_callback'     => array('tl_airquality_template', 'getChartTemplates'),
	'eval'				   => array('tl_class'=>'w50'),
	'sql'				   => "varchar(64) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['airquality_parameters'] = array
(
	'label'                => &$GLOBALS['TL_LANG']['tl_module']['airquality_parameters'],
	'exclude'              => true,
	'inputType'            => 'checkbox',
	'options'              => array
								(
									'PM2'   => &$GLOBALS['TL_LANG']['tl_module']['pm2'],
									'PM10'  => &$GLOBALS['TL_LANG']['tl_module']['pm10'],
									'CO'    => &$GLOBALS['TL_LANG']['tl_module']['co'],
									'NO2'   => &$GLOBALS['TL_LANG']['tl_module']['no2'],
									'SO2'   => &$GLOBALS['TL_LANG']['tl_module']['so2'],
									'O3'    => &$GLOBALS['TL_LANG']['tl_module']['o3'],
								),
	'eval'				   => array('multiple'=>true, 'mandatory'=>true),
	'sql'				   => "blob NULL",
);

$GLOBALS['TL_DCA']['tl_module']['fields']['chartSize'] = array
(
	'label'                => &$GLOBALS['TL_LANG']['tl_module']['chartSize'],
	'exclude'              => true,
	'inputType'            => 'imageSize',
	'options'              => array('px', '%', 'em', 'rem', 'ex', 'pt', 'pc', 'in', 'cm', 'mm'),
	'eval'				   => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>false, 'tl_class'=>'w50'),
	'sql'				   => "varchar(128) NOT NULL default ''",
);


/**
 * Class tl_links
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Hamid Abbaszadeh 2015
 * @author     Hamid Abbaszadeh <http://respinar.com>
 * @package    Links
 */
class tl_airquality_template extends Backend
{

	/**
	 * Return all charts templates as array
	 * @param object
	 * @return array
	 */
	public function getChartTemplates(DataContainer $dc)
	{
		return $this->getTemplateGroup('charts_', $dc->activeRecord->pid);
	}
}
