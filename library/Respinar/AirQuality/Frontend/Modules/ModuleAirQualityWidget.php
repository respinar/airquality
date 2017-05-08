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
 * Class ModuleAirQualityWidget
 *
 * @copyright  2015
 * @author     Hamid Abbaszadeh
 * @package    AirQuality
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

		// Return if there are no city
		if (empty($this->airquality_city))
		{
			return;
		}

		if (TL_MODE == 'FE')
		{
            $GLOBALS['TL_CSS'][]        = 'system/modules/airquality/assets/styles/airquality.css';
            $GLOBALS['TL_CSS'][]        = 'system/modules/airquality/assets/styles/airquality_bar.css';            
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
		$this->Template->date   = \Date::parse('l j F');


		// Generate a jumpTo link
		if ($this->jumpTo > 0)
		{
			$objJump = \PageModel::findByPk($this->jumpTo);

			if ($objJump !== null)
			{
				$strLink = $this->generateFrontendUrl($objJump->row(), ($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/items/%s'));
			}

			$this->Template->link   = strlen($strLink) ? sprintf($strLink, $objAirQualityCity->alias) : '';
		}
		

		$objAirQualityStaions = \AirQualityStationModel::findByPid($this->airquality_city);        

		$CityAQI = 0;

        foreach($objAirQualityStaions as $objStation)
        {
            $objAirQualityIndex = \AirQualityDataModel::findByPidAndToday($objStation->id);

            if ($objAirQualityIndex !== null)
            {

				$objTemplate = new \FrontendTemplate($this->airquality_template);

                $aqi_PM25  = $objAirQualityIndex->AQI_PM25;
				$aqi_PM10  = $objAirQualityIndex->AQI_PM10;
				$aqi_CO    = $objAirQualityIndex->AQI_CO;
				$aqi_NO2   = $objAirQualityIndex->AQI_NO2;
				$aqi_SO2   = $objAirQualityIndex->AQI_SO2;
				$aqi_O3    = $objAirQualityIndex->AQI_O3;
                $aqi       = $objAirQualityIndex->AQI;

                $arrAirQuality = array
                                    (
                                        'aqi_PM25' => array($aqi_PM25,AirQuality::aqi_level($aqi_PM25)),
										'aqi_PM10' => array($aqi_PM10,AirQuality::aqi_level($aqi_PM10)),
										'aqi_CO'   => array($aqi_CO,AirQuality::aqi_level($aqi_CO)),
										'aqi_NO2'  => array($aqi_NO2,AirQuality::aqi_level($aqi_NO2)),
										'aqi_SO2'  => array($aqi_SO2,AirQuality::aqi_level($aqi_SO2)),
										'aqi_O3'   => array($aqi_O3,AirQuality::aqi_level($aqi_O3)),
                                    );        
				$objTemplate->AirQualityIndex = $arrAirQuality;
				$objTemplate->title = $objStation->title;                         

                $arrAirQualityStation[] = $objTemplate->parse();

                if ($CityAQI < $aqi)
				{
					$CityAQI = $aqi;
				}
            }
			

			$this->Template->cityaqi = $CityAQI;
			$this->Template->cityaqi_level = AirQuality::aqi_level($CityAQI);
			$this->Template->airqualitystation = $arrAirQualityStation;			

		}

	}
}
