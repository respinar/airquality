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
namespace Respinar\AirQuality\Frontend\Module;


/**
 * Class ModuleAirQualityChart
 *
 * @copyright  2015
 * @author     Hamid Abbaszadeh
 * @package    AirQuality
 */
class ModuleAirQualityChart extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_airquality_chart';

	/**
	 * Generate the module
	 */
	public function generate()
	{

		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['mod_airquality_chart'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		if (TL_MODE == 'FE')
		{
			$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/airquality/assets/Chart.js/Chart.js';
			$GLOBALS['TL_CSS'][]        = 'system/modules/airquality/assets/styles/style.css';
		}

		return parent::generate();

	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{

		$this->Template->emptyAirQuality = $GLOBALS['TL_LANG']['MSC']['emptyAirQuality'];

		$objAirQualityCity = \AirQualityCityModel::findById($this->airquality_city);

		$this->Template->city   = $objAirQualityCity->title;
		$this->Template->source = $objAirQualityCity->source;

		$objAirQualityStaions = \AirQualityStationModel::findByPid($this->airquality_city);

		$arrCityAQI = array();

		foreach($objAirQualityStaions as $objStation)
		{
			$arrStationAQI_DATE  = array();
			$arrStationAQI_AQI   = array();
			$arrStationAQI_COLOR = array();


			$objAirQualityIndexs = \AirQualityDataModel::findByPid($objStation->id,30);

			foreach($objAirQualityIndexs as $objAirQualityIndex)
			{

				if ($objAirQualityIndex !== null)
				{

					$aqi       = $objAirQualityIndex->AQI;
					$aqi_PM25  = $objAirQualityIndex->AQI_PM25;
					$aqi_PM10  = $objAirQualityIndex->AQI_PM10;
					$aqi_CO    = $objAirQualityIndex->AQI_CO;
					$aqi_NO2   = $objAirQualityIndex->AQI_NO2;
					$aqi_SO2   = $objAirQualityIndex->AQI_SO2;
					$aqi_O3    = $objAirQualityIndex->AQI_O3;

					$arrAirQuality = array
										(
											'aqi5'     => array($aqi,AirQuality::aqi_level($aqi)),
											'aqi_PM25' => array($aqi_PM25,AirQuality::aqi_level($aqi_PM25)),
											'aqi_PM10' => array($aqi_PM10,AirQuality::aqi_level($aqi_PM10)),
											'aqi_CO'   => array($aqi_CO,AirQuality::aqi_level($aqi_CO)),
											'aqi_NO2'  => array($aqi_NO2,AirQuality::aqi_level($aqi_NO2)),
											'aqi_SO2'  => array($aqi_SO2,AirQuality::aqi_level($aqi_SO2)),
											'aqi_O3'   => array($aqi_O3,AirQuality::aqi_level($aqi_O3)),
										);

					$arrStationAQI_DATE[] = \Date::parse('j F',$objAirQualityIndex->date);
					$arrStationAQI_AQI[]  = $aqi;
					$arrStationAQI_COLOR[]  = AirQuality::aqi_color($aqi);
				}
			}

			$arrCityAQI[] = array('Station'=>$objStation->title,'DATES'=> array_reverse($arrStationAQI_DATE),'AQI'=>array_reverse($arrStationAQI_AQI),'COLOR'=>array_reverse($arrStationAQI_COLOR));

			unset($arrStationAQI_DATE);
			unset($arrStationAQI_AQI);
			unset($arrStationAQI_AQI_COLOR);

		}

		$this->Template->arrCityAQI = $arrCityAQI;
	}
}
