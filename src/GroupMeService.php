<?php

//namespace src;
//
//use CurlWrapper;
//use CurlWrapperException;
//use Template;

class GroupMeService
{
    /**
     * @var CurlWrapper
     */
    protected $curlWrapper;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var string
     */
    protected $botId;

    /**
     * @var Template
     */
    protected $template;

    /**
     * Environment
     * @var string
     */
    protected $env;

    public function __construct($botName)
    {
        $this->config = Config::getConfig();
        $this->env = $this->config->get($botName . '_bot_env');
        $this->baseUrl = $this->config->get('gm_base_url');
        $this->botId = $this->config->get($botName . '_bot_id_' . $this->env);

        try {
            $this->curlWrapper = new CurlWrapper();
        } catch (CurlWrapperException $e) {
            die($e->getMessage());
        }
    }

    public function prepareMessage($template)
    {
        $this->template = new Template($template);
        return $this;
    }

    public function sendMessage(array $data = array())
    {
        return $this->sendRawMessage($this->template->render($data));
    }

    public function sendRawMessage($message)
    {
        $this->curlWrapper->addHeader('Content-Type', 'application/json');
        $url = $this->baseUrl . 'post';
        $payload = array(
            'bot_id' => $this->botId,
            'text' => $message
        );
        try {
            $response = $this->curlWrapper->rawPost($url, json_encode($payload));
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return $response;
    }
}
