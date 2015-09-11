<?php

class HebrewDate {
    private $month;
    private $day;
    private $year;

    private $monthNames = ['', 'Tishrei', 'Cheshvan', 'Kislev', 'Tevet', 'Shvat', 'Adar', 'Adar II', 'Nissan', 'Iyar', 'Sivan', 'Tammuz', 'Av', 'Elul'];

    //(7y+1) mod 19 < 7
    public function __construct(DateTime $date = null) {
        if (!$date) {
            $date = new DateTime();
        }
        list($month, $day, $year) = explode('-', $date->format('m-d-Y'));
        list($this->month, $this->day, $this->year) = explode('/', jdtojewish(gregoriantojd($month, $day, $year)));
    }

    public function __toString() {
        $month = $this->monthNames[$this->month];
        //is Adar I?
        if ($this->month == 6 && (7 * $this->year + 1) % 19 > 7) {
            $month .= ' I';
        }
        return $this->day . ' ' . $month . ' ' . $this->year;
    }
}