<?php

class Reminder {

    /**
     * @var Database
     */
    protected $db;

    /**
     * @var GroupMeService
     */
    protected $gm;

    public function __construct() {
        $this->db = new Database();
        $this->gm = new GroupMeService('birthday');
        $this->db->connect();
        $this->process();
    }

    public function process()
    {
        $dates = $this->db->get('dates');
        foreach ($dates as &$date) {
            $gregorianDate = $date['hebrew'] ?
                $date['date'] = $this->getNextHebrewDate($date['date'])->toDateTime() :
                $date['date'] = $this->getNextGregorianDate($date['date']);

            $nextWeek = new \DateTime('+1 week midnight');
            if ($gregorianDate == $nextWeek) {
                $this->sendReminder($date, $gregorianDate, 'week');
            }
            if ($gregorianDate == new \DateTime('midnight')) {
                $this->sendReminder($date, $gregorianDate, 'today');
            }
        }
    }

    public function getNextGregorianDate($date)
    {
        $date = new \DateTime($date);
        $now = new \DateTime('midnight');
        $date = $date->setDate($now->format('Y'), $date->format('m'), $date->format('d'));
        if ($date < $now) {
            $date->modify('+1 year');
        }

        return $date;
    }

    /**
     * @param $date
     * @return HebrewDate
     */
    public function getNextHebrewDate($date)
    {
        $hebrewDate = new HebrewDate(new DateTime($date));
        $now = new HebrewDate();
        while ($now->compare($hebrewDate) > 0) {
            $hebrewDate->addYear();
        }
        return $hebrewDate;
    }

    public function sendReminder(array $data, \DateTime $date, $occasion) {
        $recipients = $this->db->get('recipients');
        $emailer = new Emailer();
        $subject = ucfirst($data['occasion']) . ' Reminder';
        $templateName = $occasion === 'week' ? 'weekBeforeReminder' : 'todayReminder';
        $gmTemplateName = $occasion === 'week' ? 'gmWeekReminder' : 'gmTodayReminder';
        $data['date'] = $data['hebrew'] ?
            new HebrewDate($date) :
            $date->format('M d, Y');
        $data['hebrew'] = $data['hebrew'] ? 'hebrew' : 'english';

        try {
            $emailer->prepare($templateName, $data);
            foreach ($recipients as $recipient) {
                $emailer->send($recipient['email'], $subject);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try {
            $this->gm->prepareMessage($gmTemplateName)
                ->sendMessage($data);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}
