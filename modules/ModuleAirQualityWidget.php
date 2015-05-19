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
 * Class ModuleAirQualityWidget
 *
 * @copyright  2015
 * @author     Hamid Abbaszadeh
 * @package    Devtools
 */
class ModuleAirQualityWidget extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_airquality_widget';

	/**
	 * Generate the module
	 */
	public function generate()
	{

		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['mod_airquality_widget'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
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

		// Generate a jumpTo link
		if ($this->jumpTo > 0)
		{
			$objJump = \PageModel::findByPk($this->jumpTo);

			if ($objJump !== null)
			{
				$strLink = $this->generateFrontendUrl($objJump->row(), ($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/items/%s'));
			}
		}

		$parameters = deserialize($this->airquality_parameters);

		$objAirQualityCity = \AirQualityCityModel::findById($this->airquality_city);

		$this->Template->city   = $objAirQualityCity->title;
		$this->Template->source = $objAirQualityCity->source;
		$this->Template->date   = \Date::parse('l j F');
		$this->Template->link   = strlen($strLink) ? sprintf($strLink, $objAirQualityCity->alias) : '';


		$objAirQualityStaions = \AirQualityStationModel::findByPid($this->airquality_city);

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

					$aqis   = deserialize($objAirQualityData->AQI_ALL);
					$maxaqi = deserialize($objAirQualityData->AQI_MAX);

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

			$this->Template->citymaxaqi = $arrCityMaxAQI;

			if ($arrAirQualityCharts)
			{
				$this->Template->airqualitycharts = $arrAirQualityCharts;
			} else {
				$this->Template = new \FrontendTemplate('mod_airquality_empty');
				$this->Template->empty = $GLOBALS['TL_LANG']['MSC']['emptyAirQuality'];
			}

		}

	}
}
