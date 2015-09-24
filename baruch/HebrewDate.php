<?php

class HebrewDate {
    private $month;
    private $day;
    private $year;

    private static $monthNames = ['', 'Tishrei', 'Cheshvan', 'Kislev', 'Tevet', 'Shvat', 'Adar', 'Adar II', 'Nissan', 'Iyar', 'Sivan', 'Tammuz', 'Av', 'Elul'];

    //(7y+1) mod 19 < 7
    public function __construct(DateTime $date = null) {
        if (!$date) {
            $date = new DateTime();
        }
        list($month, $day, $year) = explode('-', $date->format('m-d-Y'));
        list($this->month, $this->day, $this->year) = explode('/', jdtojewish(gregoriantojd($month, $day, $year)));
    }

    public function toDateTime() {
        return new DateTime(jdtogregorian(jewishtojd($this->month, $this->day, $this->year)));
    }

    public function __clone() {
        $newDate = new HebrewDate();
        return $newDate->setDay($this->day)
            ->setMonth($this->month)
            ->setYear($this->year);
    }

    public function addYear() {
        $this->year++;
        return $this;
    }

    public function setMonth($month) {
        if ($month < 1 || $month > 13) {
            throw new Exception('Invalid month value');
        }
        $this->month = (int) $month;
        return $this;
    }

    public function getMonth() {
        return $this->month;
    }

    public function setYear($year) {
        if ($year < 0) {
            throw new Exception('Invalid year value');
        }
        $this->year = $year;
        return $this;
    }

    public function getYear() {
        return $this->year;
    }

    public function setDay($day) {
        if ($day < 1 || $day > 30) {
            throw new Exception('Invalid day value');
        }
        $this->day = $day;
        return $this;
    }

    public function getDay() {
        return $this->day;
    }

    public function getMonthName() {
        $month = self::$monthNames[$this->month];
        //is Adar I?
        if ($this->month == 6 && (7 * $this->year + 1) % 19 > 7) {
            $month .= ' I';
        }
        return $month;
    }

    public function compare(HebrewDate $other) {
        if ($this->year != $other->getYear()) {
            return $this->year - $other->getYear();
        }
        if ($this->getMonth() != $other->getMonth()) {
            return $this->getMonth() - $other->getMonth();
        }
        if ($this->getDay() != $other->getDay()) {
            return $this->getDay() - $other->getDay();
        }
        return 0;
    }

    public function __toString() {
        return $this->day . ' ' . $this->getMonthName() . ' ' . $this->year;
    }
}