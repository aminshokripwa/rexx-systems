<?php

class Controller
{
    /**
     * Remove symboles from strings to help them add as key
     *
     * @param {string} checkThis
     */
    public function removeAllSymbols($checkThis)
    {
        $out = preg_replace('/[^A-Za-z0-9\-]/', '', $checkThis);
        return $out;
    }
}