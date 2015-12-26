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
 * @package    AirQuality
 */
class ModuleAirQualityWidget extends \ModuleAirQuality
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
            $GLOBALS['TL_CSS'][]        = 'system/modules/airquality/assets/styles/style.css|static';
            $GLOBALS['TL_CSS'][]        = 'system/modules/airquality/assets/styles/style-bar.css|static';
            
        }

		return parent::generate();

	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
        
        $this->Template->emptyAirQuality = $GLOBALS['TL_LANG']['MSC']['emptyAirQuality'];

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
            retuen;
		} 

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
			

			$this->Template->citymaxaqi = $arrCityMaxAQI;			
			$this->Template->airqualitycharts = $arrAirQualityCharts;			

		}

	}
}
