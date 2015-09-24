<?php

require('FormField.php');
require('HebrewDate.php');

class Decedent {
    private $fields = [];
    const CONTACT_FIRST_NAME = 'contactFirstName';
    const CONTACT_LAST_NAME = 'contactLastName';
    const CONTACT_EMAIL = 'contactEmail';
    const RELATION = 'relation';
    const ENGLISH_FIRST_NAME = 'englishFirstName';
    const ENGLISH_LAST_NAME = 'englishLastName';
    const HEBREW_NAME = 'hebrewName';
    const GENDER = 'gender';
    const FATHERS_HEBREW_NAME = 'fathersHebrewName';
    const LINEAGE = 'lineage';
    const ENGLISH_DEATH_DATE = 'englishDeathDate';
    const DAY_NIGHT = 'daynight';

    public function __construct() {

    }

    public function set($key, $value) {
        if (method_exists(Decedent::class, 'set'. $key)) {
            $methodName = 'set' . $key;
            $this->$methodName($value);
        }
        else {
            $this->fields[$key] = $value;
        }
        return $this;
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

    public function getDateOfNextYartzeit() {
        return $this->getHebrewDateOfNextYartzeit()->toDateTime();
    }

    public function getHebrewDateOfNextYartzeit() {
        $hebrewDate = new HebrewDate(new DateTime($this->get(self::ENGLISH_DEATH_DATE)));
        $now = new HebrewDate();
        while ($now->compare($hebrewDate) > 0) {
            $hebrewDate->addYear();
        }
        return $hebrewDate;
    }

    public function getFullHebrewName() {
        $name = $this->get(self::HEBREW_NAME);
        $name .= $this->get(self::GENDER) == 'Male' ? ' ben ' : ' bat ';
        $name .= $this->get(self::FATHERS_HEBREW_NAME);
        return $name;
    }
}
