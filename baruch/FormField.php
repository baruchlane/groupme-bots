<?php
class FormField {
    private static $fieldNames = array(
        '2.3' => Decedent::CONTACT_FIRST_NAME,
        '2.6' => Decedent::CONTACT_LAST_NAME,
        '3' => Decedent::CONTACT_EMAIL,
        '5' => Decedent::RELATION,
        '6.3' => Decedent::ENGLISH_FIRST_NAME,
        '6.6' => Decedent::ENGLISH_LAST_NAME,
        '7' => Decedent::HEBREW_NAME,
        '8' => Decedent::GENDER,
        '9' => Decedent::FATHERS_HEBREW_NAME,
        '10' => Decedent::LINEAGE,
        '12' => Decedent::ENGLISH_DEATH_DATE,
        '13' => Decedent::DAY_NIGHT
    );
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
