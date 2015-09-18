<?php
require('Template.php');

class Emailer {
    /** @var Template $template */
    private $template;
    private $data;
    private $active = false;

    public function prepare($templateName, array $data = []) {
        $this->template = new Template($templateName);
        $this->data = $data;
    }

    public function send($address, $subject) {
        if ($this->active) {
	    $headers = $this->getHeaders();
            mail($address, $subject, $this->template->render($this->data), $headers, '-f reminders@recitekaddish.com');
        } else {
            echo $this->template->render($this->data);
        }
    }

    private function getHeaders() {
        return "Return-Path: reminders@recitekaddish.com  \r\n" .
        	"From: ReciteKaddish <reminders$recitekaddish.com> \r\n" .
        	'X-Priority: 3' . "\r\n" .
        	'X-Mailer: PHP ' . phpversion() .  "\r\n" .
        	"Reply-To: ReciteKaddish <reminders@recitekaddish.com> \r\n" .
        	'MIME-Version: 1.0' . "\r\n" .
        	'Content-Transfer-Encoding: 8bit' . "\r\n" .
        	'Content-Type: text/html; charset=UTF-8' . "\r\n";
    }

}
