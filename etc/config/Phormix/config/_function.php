<?php

if (false === function_exists('tidyMarkup'))
{
    function tidyMarkup(string $sMarkup = '')
    {
        $oDomHTMLDocument = \DOM\HTMLDocument::createFromString($sMarkup, LIBXML_HTML_NOIMPLIED);
        $sMarkup = $oDomHTMLDocument->saveHTML();

        // remove multiple whitespaces
        $sMarkup = preg_replace('!\s+!', ' ', trim($sMarkup));

        return $sMarkup;
    }
}