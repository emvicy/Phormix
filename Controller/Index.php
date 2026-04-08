<?php

/**
 * @name $PhormixController
 */
namespace Phormix\Controller;

use MVC\DataType\DTRequestIn;
use MVC\DataType\DTRoute;
use MVC\Strings;


class Index extends _Master
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
    }

    /**
     * @param \MVC\DataType\DTRequestIn $oDTRequestIn
     * @param \MVC\DataType\DTRoute     $oDTRoute
     * @return void
     * @throws \ReflectionException
     */
    public function readme(DTRequestIn $oDTRequestIn, DTRoute $oDTRoute)
    {
        view()->assign('sReadme', Strings::parsedown(file_get_contents(realpath(__DIR__ . '/../') . '/README.md')));
        view()->autoAssign();
    }

    /**
     * @throws \ReflectionException
     * @throws \SmartyException
     */
    public function __destruct()
    {
        parent::__destruct();
    }
}