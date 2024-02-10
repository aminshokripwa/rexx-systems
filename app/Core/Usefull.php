<?php

    /**
     * Remove symboles from strings to help them add as key
     *
     * @param {string} checkThis
     */
function removesymbols($string)
{
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}