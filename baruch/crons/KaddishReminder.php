<?php
chdir(dirname(__FILE__));
require('../Decedent.php');
require('loadWp.php');
require('../Emailer.php');
new KaddishReminder($wpdb);

class KaddishReminder {
    private $daysAhead = array(1);
    public $wpdb;

    public function __construct($wpdb) {
        $this->wpdb = $wpdb;
        $this->process();
    }

    public function process() {
        $decedents = $this->getDecedents();
        /** @var Decedent $decedent */
        foreach ($decedents as $decedent) {
            $nextYartzeit = $decedent->getDateOfNextYartzeit();
            $daysAhead = [1];
            if ($decedent->get(Decedent::DAYS_BEFORE)) {
                $daysAhead[] = $decedent->get(Decedent::DAYS_BEFORE);
            }
            foreach($daysAhead as $dayAhead) {
                $future = new DateTime("+$dayAhead days midnight");
                if ($nextYartzeit == $future) {
                    $this->sendReminder($decedent, $dayAhead);
                }
            }
        }
    }

    public function getDecedents() {
        $decedents = array();
        $results = $this->wpdb->get_results("SELECT * FROM {$this->wpdb->prefix}rg_lead_detail ORDER BY lead_id, field_number");
        foreach ($results as $result) {
            if (!isset($decedents[$result->lead_id])) {
                $decedents[$result->lead_id] = new Decedent();
            }
            $decedents[$result->lead_id]->addField(new FormField($result->value, $result->field_number));
        }
        return $decedents;
    }

    public function sendReminder(Decedent $decedent, $dayAhead = null) {
        $data = array(
            'contactFirstName' => $decedent->get(Decedent::CONTACT_FIRST_NAME),
            'relation' => $decedent->get(Decedent::RELATION),
            'englishFirstName' => $decedent->get(Decedent::ENGLISH_FIRST_NAME),
            'englishLastName' => $decedent->get(Decedent::ENGLISH_LAST_NAME),
            'days' => $dayAhead,
            'date' => $decedent->getDateOfNextYartzeit()->format('m/d/Y'),
            'hebrewName' => $decedent->getFullHebrewName(),
            'hebrewDate' => $decedent->getHebrewDateOfNextYartzeit()
        );
        $emailer = new Emailer();
        $templateName = $dayAhead == 1 ? 'dayBeforeReminder' : 'yartzeitReminder';
        try {
            $emailer->prepare($templateName, $data);
            $emailer->send($decedent->get(Decedent::CONTACT_EMAIL), 'Yahrzeit Reminder');
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}
