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


 /**
  * Namespace
  */
 namespace Respinar\AirQuality\Frontend;


 /**
  * Class ModuleAirQuality
  *
  * @copyright  2015
  * @author     Hamid Abbaszadeh
  * @package    AirQuality
  */
abstract class ModuleAirQuality extends \Frontend
{

	/**
	 * URL cache array
	 * @var array
	 */
	private static $arrUrlCache = array();


    protected function parseCity($objAirQualityCity,$blnAddArchive=false, $strClass='', $intCount=0)
    {

        /** @var \PageModel $objPage */
		global $objPage;

		$objTemplate->setData($objAirQualityCity->row());

        $this->Template->date   = \Date::parse('l j F');

    }

    protected function parseStation($objStation)
    {

    }

    protected function parseData($objData)
    {

    }

}
