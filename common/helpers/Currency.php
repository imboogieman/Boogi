<?php

class Currency
{

    /**
     * Gig currencies
     * @return array
     */
    public static function getCurrencies()
    {
        return array(
            1 => 'US Dollar',
            2 => 'Euro'
        );
    }

    /**
     * Gig currency symbols
     * @return array
     */
    public static function getCurrencySymbols()
    {
        return array(
            1 => '$',
            2 => '&euro;'
        );
    }

    /**
     * Get readable currency by id
     * @param int $id
     * @return string
     */
    public static function getCurrencyById($id)
    {
        $variants = self::getCurrencies();
        return isset($variants[$id]) ? $variants[$id] : 'US Dollar';
    }

    /**
     * Get readable currency by id
     * @param int $id
     * @return string
     */
    public static function getCurrencySymbolById($id)
    {
        $variants = self::getCurrencySymbols();
        return isset($variants[$id]) ? $variants[$id] : '';
    }
}