<?php
require('Template.php');

class Emailer {
    /** @var Template $template */
    private $template;
    private $data;
    private $logFile = 'mailer.log';
    private $active = true;

    public function prepare($templateName, array $data = array()) {
        $this->template = new Template($templateName);
        $this->data = $data;
    }

    public function send($address, $subject) {
        if ($this->active) {
	    $headers = $this->getHeaders();
            $this->mail($address, $subject, $this->template->render($this->data), $headers, '-f reminders@recitekaddish.com');
        } else {
            echo $this->template->render($this->data);
        }
    }

    protected function mail($address, $subject, $body, $headers, $options) {
        $now = new \DateTime();
        if (mail($address, $subject, $body, $headers, $options)) {
            file_put_contents($this->logFile, $now->format('YYYY-mm-dd HH:ii:ss') . '> ' . json_encode(array(
                    'address' => $address,
                    'subject' => $subject,
                    'body' => $body
                ))
            );
        } else {
            file_put_contents($this->logFile, $now->format('YYYY-mm-dd HH:ii:ss') . '> Failure: ' . json_encode(array(
                    'address' => $address,
                    'subject' => $subject,
                    'body' => $body
                ))
            );
        }
    }

    private function getHeaders() {
        return "Return-Path: reminders@recitekaddish.com  \r\n" .
        	"From: ReciteKaddish <reminders@recitekaddish.com> \r\n" .
        	'X-Priority: 3' . "\r\n" .
        	'X-Mailer: PHP ' . phpversion() .  "\r\n" .
        	"Reply-To: ReciteKaddish <reminders@recitekaddish.com> \r\n" .
        	'MIME-Version: 1.0' . "\r\n" .
        	'Content-Transfer-Encoding: 8bit' . "\r\n" .
        	'Content-Type: text/html; charset=UTF-8' . "\r\n";
    }

}
