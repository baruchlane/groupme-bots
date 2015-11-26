<?php

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
     * @var string
     */
    protected $gid;

    /**
     * @var Template
     */
    protected $template;

    public function __construct()
    {
        $this->config = Config::getConfig();
        $this->baseUrl = $this->config->get('gm_base_url');
        $this->botId = $this->config->get('gm_bot_id');
        $this->gid = $this->config->get('gm_gid');

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
        $this->curlWrapper->addHeader('Content-Type', 'application/json');
        $url = $this->baseUrl . 'post';
        $payload = array(
            'bot_id' => $this->botId,
            'text' => $this->template->render($data)
        );
        try {
            $response = $this->curlWrapper->rawPost($url, json_encode($payload));
        } catch (Exception $e) {
            die($e->getMessage());
        }
        var_dump($response);
    }
}