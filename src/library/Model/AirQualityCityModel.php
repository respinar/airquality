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
namespace Respinar\AirQuality\Model;

/**
 * Class AirqualityCityModel
 *
 * @copyright  2015
 * @author     Hamid Abbaszadeh
 * @package    Devtools
 */
class AirQualityCityModel extends \Model
{

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_airquality_city';

	/**
	 * Find Air Pollution by its ID
	 *
	 * @param integer $intId      The air pollution category ID
	 *
	 * @return \Model\Collection|null A collection of models or null if there are no news
	 */
	public static function findById($intId)
	{
		$t = static::$strTable;

		$arrColumns = array("$t.id=?");

		return static::findBy($arrColumns, $intId);
	}

	/**
	 * Find Air Pollution by its Alias
	 *
	 * @param integer $intId      The air pollution category Alias
	 *
	 * @return \Model\Collection|null A collection of models or null if there are no news
	 */
	public static function findByAlias($Alias)
	{
		$t = static::$strTable;

		$arrColumns = array("$t.alias=?");

		return static::findBy($arrColumns, $Alias);
	}

}
