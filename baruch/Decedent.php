<?php

require('FormField.php');
require('HebrewDate.php');

class Decedent {
    private $fields = [];

    public function __construct() {

    }

    public function addField(FormField $field) {
        $this->fields[$field->getField()] = $field->getValue();
        return $this;
    }

    public function getValue($fieldName) {
        return isset($this->fields[$fieldName]) ? $this->fields[$fieldName] : null;
    }

    public function get($fieldName) {
        return $this->getValue($fieldName);
    }

    public function getHebrewDateOfNextYartzeit() {
        return new HebrewDate($this->calculateDateOfNextYartzeit());
    }

    public function calculateDateOfNextYartzeit() {
        list($gregYear, $gregMonth, $gregDay) = explode('-', $this->getValue(FormField::ENGLISH_DEATH_DATE));
        if ($this->getValue(FormField::DAY_NIGHT) != 'Before Sunset') {
            $gregDay++;
        }
        list($hebMonth, $hebDay, $hebYear) = explode('/', jdtojewish(gregoriantojd($gregMonth, $gregDay, $gregYear)));
        while (($next = new \DateTime(jdtogregorian(jewishtojd($hebMonth, $hebDay, $hebYear++)))) < (new \DateTime()));
        return $next;
    }

    public function getFullHebrewName() {
        $name = $this->get(FormField::HEBREW_NAME);
        $name .= $this->get(FormField::GENDER) == 'Male' ? ' ben ' : ' bat ';
        $name .= $this->get(FormField::FATHERS_HEBREW_NAME);
        return $name;
    }
}