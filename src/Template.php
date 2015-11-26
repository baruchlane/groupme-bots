<?php

class Template {
    private $template;
    private $templateDir = '../templates/';

    public function __construct($templateName) {
        $templatePath = $this->templateDir . $templateName . '.html';
        if (!file_exists($templatePath)) {
            throw new Exception('unable to find/open template file.');
        }
        $this->template = file_get_contents($templatePath);
    }

    public function render(array $data = array()) {
        $templateInstance = $this->template;
        foreach ($data as $k => $v) {
            $templateInstance = preg_replace("/\\[$k\\]/", htmlspecialchars($v), $templateInstance);
        }
        return $templateInstance;
    }
}
