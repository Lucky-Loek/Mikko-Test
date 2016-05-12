<?php
/**
 * Created by PhpStorm.
 * User: loekv
 * Date: 12-5-2016
 * Time: 12:06
 */

namespace Payday;

/**
 * Represents a month in which paydays should be calculated
 * @package Payday
 */
class MonthPayday {

    private $startDate;

    /**
     * MonthPayday constructor.
     * @param \DateTime $startDate
     */
    public function __construct(\DateTime $startDate) {
        $this->startDate = $startDate;
    }

    /**
     * Returns full name of the Month, i.e. "March"
     * @return string
     */
    public function getFormattedMonth() {
        return $this->startDate->format('F');
    }

    /**
     * Return full name of the day, i.e. "Friday 13th"
     * @return string
     */
    public function getFormattedSalaryPayday() {
        return $this->getSalaryPayday()->format('l jS');
    }

    /**
     * Return full name of the day, i.e. "Friday 13th"
     * @return string
     */
    public function getFormattedBonusPayday() {
        return $this->getBonusPayday()->format('l jS');
    }

    /**
     * Returns the day the normal salary should be paid. Returns 'null' if salary already has been paid.
     * @return \DateTime|null
     */
    private function getSalaryPayday() {
        // Last day of the month
        $lastDay = $this->startDate->modify('last day of this month');

        // If last day is weekend, pay the Friday before that weekend
        if ($this->dayIsWeekend($lastDay)) {
            $lastDay = $lastDay->modify('previous friday');
        }

        // If this is checked in the last weekend, salary will be paid twice, so prevent that
        if ($this->startDate > $lastDay) {
            return null;
        }

        return $lastDay;
    }

    /**
     * Returns the day the bonus salary should be paid. Returns 'null' if salary already has been paid.
     * @return \DateTime|null
     */
    private function getBonusPayday() {
        $bonusDay = $this->startDate->modify('first day of this month')->modify('+14 days');

        // If 15th is weekend, pay the next Wednesday
        if ($this->dayIsWeekend($bonusDay)) {
            $bonusday = $bonusDay->modify('next wednesday');
        }

        // If this is checked on a day later than the 15th or next Wednesday after that, salary will be paid twice
        // So prevent that
        if ($this->startDate > $bonusDay) {
            return null;
        }

        return $bonusDay;
    }

    /**
     * Return true if day is a Saturday or Sunday.
     * @param \DateTime $day
     * @return bool
     */
    private function dayIsWeekend(\DateTime $day) {
        return $day->format('N') >= 6;
    }
}