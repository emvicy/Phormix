<?php

/**
 * @name $PhormixController
 */
namespace Phormix\Controller;

use App\Controller;
use App\Model\Menu;
use MVC\Config;
use MVC\DataType\DTRequestIn;
use MVC\DataType\DTRoute;
use MVC\Http\Header;
use MVC\Session;
use Phormix\Model\Phormix;


class _Master extends Controller
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    public static function __preconstruct()
    {
        parent::__preconstruct();
    }

    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @throws \ReflectionException
     */
    public function __construct(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        parent::__construct($oDTRequestIn, $oDTRoute);
        view();
        Header::init()->ContentSecurityPolicy();

        Menu::build(
            Config::MODULE('Phormix')['Menu'],
            bGetPropertiesFromRouteOnTag: true,
            sCallback: '\App\Model\Menu::buildBootstrap5Menu'
        );

        // Infotool off
        Config::set_MVC_INFOTOOL_ENABLE(false);
        // add the template directory of this module
        view()->addTemplateDir(realpath(__DIR__ . '/../' . '/templates/'));
        // set the template directory of this module
        view()->sTemplateDir = realpath(__DIR__ . '/../' . '/templates/');
    }

    /**
     * delivers a captcha image
     * @return void
     * @throws \ReflectionException
     */
    public function captcha(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        // take identifier from parameter
        $sCaptchaId = ($oDTRequestIn->get_pathParamArray()['sCaptchaId'] ?? 'Captcha');
        \Phimcap::image(
            Session::is('Phormix')->get($sCaptchaId),
            realpath(__DIR__ . '/../') . '/etc/config/Phormix/config/Educational_Gothic_V2/EducationalGothic-Regular.otf'
        );
    }

    /**
     * delivers complete, final config as JSON
     * @param \Phormix\Model\Phormix $oPhormix
     * @return void
     */
    protected function showConfigOnDemand(Phormix $oPhormix)
    {
        if (false === isset($_GET['config']))
        {
            return;
        }

        if ('json' === $_GET['config'])
        {
            $oPhormix->getFinalConfigAsJson(bReturn: false);
        }

        if ('php' === $_GET['config'])
        {
            $oPhormix->getFinalConfigAsPhp(bReturn: false);
        }

        if ('yaml' === $_GET['config'])
        {
            $oPhormix->getFinalConfigAsYaml(bReturn: false);
        }
    }

    /**
     * @throws \ReflectionException
     * @throws \SmartyException
     */
    public function __destruct()
    {
        parent::__destruct();
        view()->render();
    }
}