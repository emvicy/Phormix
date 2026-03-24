<?php

/**
 * @usage {'<foo> bla bla </foo>'|tidyMarkup}
 * @param string $sMarkup
 * @return string
 */
function smarty_modifier_tidyMarkup(string $sMarkup = '')
{
    return (string) tidyMarkup($sMarkup);
}