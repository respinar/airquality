<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @package   airquality
 * @author    Hamid Abbaszadeh
 * @license   GNU/LGPL
 * @copyright 2015
 */


/**
 * Namespace
 */
namespace AirQuality;


/**
 * Class AirQuality
 *
 * @copyright  2015
 * @author     Hamid Abbaszadeh
 * @package    Devtools
 */


class AirQuality
{

	public $AirQualityIndexes,$AirQualityIndex;

	var $arrBreakPoints = array
	(
		'NO2' => array
				 (
					array(0.000,  54.0,   0,  50),
					array( 54.0, 101.0,  51, 100),
					array(101.0, 361.0, 101, 150),
					array(361.0, 641.0, 151, 200),
					array(641.0, 124.1, 201, 300),
					array(124.1, 164.1, 301, 400),
					array(164.1, 204.1, 401, 500)
				 ),
		'SO2' => array
				 (
					array(  0.0,  35.0,   0,  50),
					array( 35.0, 145.0,  51, 100),
					array(145.0, 225.0, 101, 150),
					array(225.0, 305.0, 151, 200),
					array(305.0, 605.0, 201, 300),
					array(605.0, 805.0, 301, 400),
					array(805.0, 1005 , 401, 500)
				  ),
		'CO' => array
				 (
					array( 0.00,  4.50,   0,  50),
					array( 4.50,  9.50,  51, 100),
					array( 9.50, 12.50, 101, 150),
					array(12.50, 15.50, 151, 200),
					array(15.50, 30.50, 201, 300),
					array(30.50, 40.50, 301, 400),
					array(40.50, 50.50, 401, 500)
				 ),
		'PM10' => array
				 (
					array(  0.0,  55.0,   0,  50),
					array( 55.0, 155.0,  51, 100),
					array(155.0, 255.0, 101, 150),
					array(255.0, 355.0, 151, 200),
					array(355.0, 425.0, 201, 300),
					array(425.0, 505.0, 301, 400),
					array(505.0, 645.0, 401, 500)
				  ),
		'PM25' => array
				 (
					array(  0.0,  15.5,   0,  50),
					array( 15.5,  35.0,  51, 100),
					array( 35.0,  65.5, 101, 150),
					array( 65.5, 150.5, 151, 200),
					array(150.5, 250.5, 201, 300),
					array(250.5, 350.5, 301, 400),
					array(350.5, 500.5, 401, 500)
				 ),
		'O31' => array
				 (
					array(125.0, 165.0, 101, 150),
					array(165.0, 205.0, 151, 200),
					array(205.0, 405.0, 201, 300),
					array(405.0, 505.0, 301, 400),
					array(505.0, 605.0, 401, 500)
				  ),
		'O38' => array
				 (
					array( 0.0,   60.0,   0,  50),
					array( 60.0,  76.0,  51, 100),
					array( 76.0, 096.0, 101, 150),
					array(096.0, 116.0, 151, 200),
					array(116.0, 375.0, 201, 300)
				 )
	);

	/**
	* Return AirQualityIndexes and AirQualityIndex
	**/

	function __construct($data)
	{

		$O3 = deserialize($data->O3);
		$rawdata = array
		(
			'PM25' => $data->PM25,
			'PM10' => $data->PM10,
			'CO'  => $data->CO,
			'NO2' => $data->NO2,
			'SO2' => $data->SO2,
			'O31' => $O3[0],
			'O38' => $O3[1]
		);

		$this->AirQualityIndexes = $this->aqi($rawdata);
		$this->AirQualityIndex   = $this->maxaqi($this->AirQualityIndexes);
		return;
	}

	/**
	* Calculate AirQualityIndexes
	**/

	function aqi($rawData)
	{

		$result = array();
		foreach ($rawData as $parameter => $value )
		{
			$_aqi   = intval($this->calc_aqi($parameter,$value));
			$_color = $this->aqi_color($_aqi);
			$_level = $this->aqi_level($_aqi);
			$result[$parameter] = array('parameter'=>$parameter,'value'=>$_aqi,'color'=>$_color,'level'=>$_level);
		}

		$aqi_O3 = max($result[O31][value],$result[O38][value]);

		$result[O3] = array('parameter'=>'O3','value'=>$aqi_O3,'color'=>$this->aqi_color($aqi_O3),'level'=>$this->aqi_level($aqi_O3));

		unset($result[O31],$result[O38]);

		return $result;
	}

	/**
	* Return AirQualityIndex
	*/

	function maxaqi($data)
	{
		$max_value = 0;

		foreach($data as $key => $aqi)
		{
			if ($aqi[value] > $max_value)
			{
				$max_key   = $key;
				$max_value = $aqi[value];
			}
		}

		return $data[$max_key];
	}


	/**
	* Calculate AirQualityIndexes
	**/

	function calc_aqi($parameter,$value)
	{
		foreach($this->arrBreakPoints[$parameter] as $arrBreakPoint)
		{
			if ($arrBreakPoint[0] <= $value && $value < $arrBreakPoint[1])
			{
				$breakpoint_lo = $arrBreakPoint[0];
				$breakpoint_hi = $arrBreakPoint[1];
				$index_lo      = $arrBreakPoint[2];
				$index_hi      = $arrBreakPoint[3];
				break;
			}
		}

		if (($breakpoint_hi - $breakpoint_lo) != 0)
		{
			$aqi = (($index_hi - $index_lo) / ($breakpoint_hi - $breakpoint_lo))*($value - $breakpoint_lo) + $index_lo;
		} else {
			$aqi = 0;
		}

		return $aqi;
	}


	/**
	* Return AirQualityIndexes Colors
	**/

	function aqi_color($_aqi)
	{
		switch($_aqi)
		{
			case($_aqi <= 50):                 $_color = "green"; break;
			case($_aqi <= 100 && $_aqi >  50): $_color = "yellow"; break;
			case($_aqi <= 150 && $_aqi > 100): $_color = "orange"; break;
			case($_aqi <= 200 && $_aqi > 150): $_color = "red"; break;
			case($_aqi <= 300 && $_aqi > 200): $_color = "purple"; break;
			case($_aqi <= 500 && $_aqi > 300): $_color = "maroon"; break;
		}

		return $_color;
	}

	/**
	* Return AirQualityIndexes Level
	*/

	function aqi_level($_aqi)
	{
		switch($_aqi)
		{
			case($_aqi <= 50):                 $_level = "good"; break;
			case($_aqi <= 100 && $_aqi >  50): $_level = "moderate"; break;
			case($_aqi <= 150 && $_aqi > 100): $_level = "unhealthysg"; break;
			case($_aqi <= 200 && $_aqi > 150): $_level = "unhealthy"; break;
			case($_aqi <= 300 && $_aqi > 200): $_level = "veryunhealthy"; break;
			case($_aqi <= 500 && $_aqi > 300): $_level = "hazardous"; break;
		}

		return $_level;
	}

}
