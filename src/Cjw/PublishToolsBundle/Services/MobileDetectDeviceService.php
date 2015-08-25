<?php
namespace Cjw\PublishToolsBundle\Services;

/**
 * Class MobileDetectDeviceService
 *
 * usage:
 * \Cjw\PublishToolsBundle\Services\MobileDetectDeviceService::getDeviceTypeByPhoneTabletDesktop() => return tablet|phone|desktop
 * \Cjw\PublishToolsBundle\Services\MobileDetectDeviceService::getDeviceTypeByMobileDesktop() => return mobile|desktop
 *
 * @package Cjw\PublishToolsBundle\Services
 */
class MobileDetectDeviceService
{
    /**
     *
     * detect if the current request was taken
     * from an  tablet, phone or desktop  or   mobile and desktop
     *
     * default is desktop
     *
     * @author Felix Woldt - JAC Systeme GmbH
     * @return string   tablet|phone|desktop
     *
     */
    public static function getDeviceTypeByPhoneTabletDesktop()
    {
        $mobileDetect = new \Cjw\PublishToolsBundle\Services\MobileDetectService();

        if ( $mobileDetect->isTablet() )
        {
            $deviceType = 'tablet';
        }
        elseif( $mobileDetect->isMobile() )
        {
            $deviceType = 'phone';
        }
        else
        {
            $deviceType = 'desktop';
        }
        return $deviceType;
    }

    /**
     *
     * detect if the current request was taken
     * from an  tablet, phone or desktop  or   mobile and desktop
     *
     * default is desktop
     *
     * @author Felix Woldt - JAC Systeme GmbH
     * @return string  mobile|desktop
     *
     */
    public static function getDeviceTypeByMobileDesktop()
    {
        $mobileDetect = new \Cjw\PublishToolsBundle\Services\MobileDetectService();

        if ( $mobileDetect->isMobile() )
        {
            $deviceType = 'mobile';
        }
        else
        {
            $deviceType = 'desktop';
        }
        return $deviceType;
    }
}