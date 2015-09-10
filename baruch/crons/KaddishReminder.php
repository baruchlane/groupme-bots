<?php
chdir(dirname(__FILE__));
require('../Decedent.php');
require('loadWp.php');
require('../Emailer.php');

new KaddishReminder($wpdb);

class KaddishReminder {
    private $daysAhead = [1, 10, 12, 13, 14, 15];
    public $wpdb;

    public function __construct($wpdb) {
        $this->wpdb = $wpdb;
        $this->process();
    }

    public function process() {
        $decedents = $this->getDecedents();
        /** @var Decedent $decedent */
        foreach ($decedents as $decedent) {
            $nextYartzeit = $decedent->calculateDateOfNextYartzeit();
            foreach($this->daysAhead as $dayAhead) {
                $future = new DateTime("+$dayAhead days midnight");
                if ($nextYartzeit == $future) {
                    $this->sendReminder($decedent, $dayAhead);
                }
            }
        }
    }

    public function getDecedents() {
        $decedents = [];
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
        $data = [
            'contactFirstName' => $decedent->get(FormField::CONTACT_FIRST_NAME),
            'relation' => $decedent->get(FormField::RELATION),
            'englishFirstName' => $decedent->get(FormField::ENGLISH_FIRST_NAME),
            'englishLastName' => $decedent->get(FormField::ENGLISH_LAST_NAME),
            'days' => $dayAhead,
            'date' => $decedent->calculateDateOfNextYartzeit()->format('m/d/Y'),
            'hebrewName' => $decedent->getFullHebrewName()
        ];
        $emailer = new Emailer();
        try {
            $emailer->prepare('yartzeitReminder', $data);
            $emailer->send($decedent->get(FormField::CONTACT_EMAIL), 'Yartzeit Reminder');
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}