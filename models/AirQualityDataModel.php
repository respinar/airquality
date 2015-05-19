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
namespace AirQuality;

/**
 * Class AirqualityDataModel
 *
 * @copyright  2015
 * @author     Hamid Abbaszadeh
 * @package    Devtools
 */
class AirQualityDataModel extends \Model
{

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_airquality_data';

	/**
	 * Find record items by its parent ID
	 *
	 * @param integer $intId      The air pollution category ID
	 * @param integer $intLimit   An optional limit
	 * @param integer $intOffset  An optional offset
	 * @param array   $arrOptions An optional options array
	 *
	 * @return \Model\Collection|null A collection of models or null if there are no news
	 */
	public static function findByPid($intId, $intLimit=1,$intOffset=0)
	{
		$t = static::$strTable;

		$arrColumns = array("$t.pid=?");

		if (!isset($arrOptions['order']))
		{
			$arrOptions['order'] = "$t.date DESC";
		}

		if ($intLimit > 0)
		{
			$arrOptions['limit'] = $intLimit;
		}

		$arrOptions['offset'] = $intOffset;

		return static::findBy($arrColumns, $intId, $arrOptions);
	}

	public static function findByPidAndToday($intId)
	{
		$t = static::$strTable;

		$date = strtotime(date('Y-m-d'));

		$arrColumns = array("$t.pid=? AND $t.date=?");

		return static::findBy($arrColumns, array($intId,$date));
	}
}
