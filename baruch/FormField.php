<?php
class FormField {
    const CONTACT_FIRST_NAME = 'contactFirstName';
    const CONTACT_LAST_NAME = 'contactLastName';
    const CONTACT_EMAIL = 'contactEmail';
    const RELATION = 'relation';
    const ENGLISH_FIRST_NAME = 'englishFirstName';
    const ENGLISH_LAST_NAME = 'englishLastName';
    const HEBREW_NAME = 'hebrewName';
    const GENDER = 'gender';
    const FATHERS_HEBREW_NAME = 'fathersHebrewName';
    const CASTE = 'caste';
    const ENGLISH_DEATH_DATE = 'englishDeathDate';
    const DAY_NIGHT = 'daynight';

    private static $fieldNames = [
        '2.3' => self::CONTACT_FIRST_NAME,
        '2.6' => self::CONTACT_LAST_NAME,
        '3' => self::CONTACT_EMAIL,
        '5' => self::RELATION,
        '6.3' => self::ENGLISH_FIRST_NAME,
        '6.6' => self::ENGLISH_LAST_NAME,
        '7' => self::HEBREW_NAME,
        '8' => self::GENDER,
        '9' => self::FATHERS_HEBREW_NAME,
        '10' => self::CASTE,
        '12' => self::ENGLISH_DEATH_DATE,
        '13' => self::DAY_NIGHT
    ];
    private $fieldName;

    private $value;

    public function __construct($value, $fieldNumber = null) {
        $this->fieldName = isset(self::$fieldNames[$fieldNumber]) ? self::$fieldNames[$fieldNumber] : 'unknown';
        $this->value = $value;
    }

    public function getField() {
        return $this->fieldName;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
}