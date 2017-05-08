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
  * Namespace
  */
 namespace Respinar\AirQuality;


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
