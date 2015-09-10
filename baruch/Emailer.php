<?php
require('Template.php');

class Emailer {
    /** @var Template $template */
    private $template;
    private $data;
    private $active = true;

    public function prepare($templateName, array $data = []) {
        $this->template = new Template($templateName);
        $this->data = $data;
    }

    public function send($address, $subject) {
        if ($this->active) {
            mail($address, $subject, $this->template->render($this->data), $this->getHeaders());
        } else {
            echo $this->template->render($this->data);
        }
    }

    private function getHeaders() {
        return 'From: mailer@recitekaddish.com' . "\r\n" .
           'Reply-To: recitekaddish.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();
    }

}