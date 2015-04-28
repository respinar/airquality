<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   AirQuality
 * @author    Hamid Abbaszadeh
 * @license   GNU/LGPL
 * @copyright 2014
 */


/**
 * Namespace
 */
namespace AirQuality;


/**
 * Class ModuleAirQualityCharts
 *
 * @copyright  2014
 * @author     Hamid Abbaszadeh
 * @package    Devtools
 */
class ModuleAirQualityFull extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_airquality_full';

	/**
	 * Generate the module
	 */
	public function generate()
	{

		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['mod_airquality_full'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}


        // Set the item from the auto_item parameter
		if (!isset($_GET['items']) && $GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item']))
		{
			\Input::setGet('items', \Input::get('auto_item'));
		}

		// Return if there are no items
		if (!\Input::get('items'))
		{
			return '';
		}

		if (TL_MODE == 'FE')
		{
            $GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/airquality/assets/js/Chart.min.js|static';
            $GLOBALS['TL_CSS'][]        = 'system/modules/airquality/assets/css/style.css';
        }

		return parent::generate();

	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{

		$parameters = deserialize($this->airquality_parameters);

		$size = deserialize($this->chartSize);
		$this->Template->width  = $size[0];
		$this->Template->height = $size[1];


		$objAirQualityCity = \AirQualityCityModel::findByAlias(\Input::get('items'));

		$this->Template->city   = $objAirQualityCity->title;
		$this->Template->date   = \Date::parse('l j F Y');
		$this->Template->source = $objAirQualityCity->source;

		$objAirQualityStaions = \AirQualityStationModel::findByPid($objAirQualityCity->id);

		// No stations found
		if ($objAirQualityStaions === null)
		{
			$this->Template = new \FrontendTemplate('mod_airquality_empty');
			$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyAirQuality'];
		} else {

			$arrAirQuality = array();
			$arrCityMaxAQI = array(parameter=>'',value=>0,color=>'',level=>'');

			foreach($objAirQualityStaions as $objStation)
			{
				$objAirQualityData = \AirQualityDataModel::findByPidAndToday($objStation->id);

				if ($objAirQualityData !== null)
				{
					$aqi    = new \AirQuality($objAirQualityData);
					$aqis   = $aqi->AirQualityIndexes;
					$maxaqi = $aqi->AirQualityIndex;

					$arrAirQuality = array
										(
											'station' => $objStation->title,
											'date'    => \Date::parse('l j F',$objAirQualityData->date),
											'aqi'     => $aqis,
											'maxaqi'  => $maxaqi
										);

					$objTemplate = new \FrontendTemplate($this->chartTemplate);

					$size = deserialize($this->chartSize);
					$objTemplate->width  = $size[0];
					$objTemplate->height = $size[1];
					$objTemplate->title = $objStation->title;
					$objTemplate->alias = $objStation->alias;
					$objTemplate->id = uniqid('chart_');

					$objTemplate->labels = '"PM2.5","PM10","CO","NO2","SO2","O3"';
					$objTemplate->data = $arrAirQuality;

					$arrAirQualityCharts[] = $objTemplate->parse();

					if ($arrCityMaxAQI[value] < $maxaqi[value])
					{
						$arrCityMaxAQI = $maxaqi;
					}
				}
			}

			//foreach ($arrAirQuality as $AQ)
			//{
				//if ($citymaxaqi < $AQ[maxaqi])
					//$citymaxaqi = $AQ[maxaqi];
			//}

			$this->Template->citymaxaqi = $arrCityMaxAQI;
			if ($arrAirQualityCharts)
			{
				$this->Template->airqualitycharts = $arrAirQualityCharts;
			} else {
				$this->Template = new \FrontendTemplate('mod_airquality_empty');
				$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyAirQuality'];
			}

			$arrAirQualityAll = array();
			foreach($objAirQualityStaions as $objStation)
			{
				$objAirQualityData = \AirQualityDataModel::findByPid($objStation->id,30,1);

				while($objAirQualityData->next())
				{
					$aqi = new \AirQuality($objAirQualityData);
					$arrAirQualityAll[$objStation->title][\Date::parse('m/d',$objAirQualityData->date)] = $aqi->AirQualityIndexes;
				}
			}

			$this->Template->allaqi = $arrAirQualityAll;

		}
	}
}
