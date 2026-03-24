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
use MVC\Media\Type_Application_json;
use Phormix\Model\Phormix;


class Index extends Controller
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
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @return void
     * @throws \ReflectionException
     */
    public function index(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        view()->autoAssign();
    }

    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @return void
     * @throws \ReflectionException
     */
    public function profile(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        $oPhormix = Phormix::init()
            // dir with form elements as "yaml" files
            ->setElementDirectory(Config::get_MVC_MODULES_DIR() . '/Phormix/element/')
            // formular config yaml file
            ->loadConfigYaml(Config::get_MVC_MODULES_DIR() . '/Phormix/formular.yaml')
            // set a Validate Class that fits your needs
            ->setValidateClass('\Phormix\Model\PhormixValidate')
            ->run();
        ;

        // show config
        if (true === isset($_GET['config']))
        {
            $this->showConfig($oPhormix);
        }

        if (true === $oPhormix->bSuccess)
        {
            info(
                $oPhormix->getDataAccepted()
            );
        }

        view()->assign('oPhormix', $oPhormix);
        view()->assign('oDTRoute', $oDTRoute);
        view()->autoAssign();
    }

    /**
     * @param \Phormix\Model\Phormix $oPhormix
     * @return void
     */
    protected function showConfig (Phormix $oPhormix)
    {
        Type_Application_json::header();
        echo json_encode($oPhormix->aConfig);
        exit();
    }

    /**
     * @throws \ReflectionException
     * @throws \SmartyException
     */
    public function __destruct ()
    {
        parent::__destruct();
        view()->render();
    }
}