<?php
/**
 * Created by PhpStorm.
 * User: loekv
 * Date: 12-5-2016
 * Time: 11:45
 */

namespace Payday;

/**
 * Represents the remainder of the year from the current day
 * @package Payday
 */
class YearPayday {

    /**
     * Return the first days of every remaining month until the next year
     * @return array
     */
    public function getMonthsToNewYear() {
        $startDate = new \DateTime('midnight');
        $endDate = new \DateTime('1st january next year');

        $month = new \DateInterval('P1M');
        $newPeriod = new \DateTime('first day of next month');
        $period = new \DatePeriod($newPeriod, $month, $endDate);

        // Start array with current date
        $dates = array($startDate);

        // Add all remaining dates to array
        foreach ($period as $date) {
            array_push($dates, $date);
        }

        return $dates;
    }
}