<?php

class GroupMeService
{
    protected $curlWrapper;

    protected $config;

    protected $baseUrl;

    protected $token;

    protected $gid;

    public function __construct()
    {
        $this->config = Config::getConfig();
        $this->curlWrapper = new CurlWrapper();
        $this->baseUrl = $this->config->get('gms_base_url');
        $this->token = $this->config->get('gms_token');
        $this->gid = $this->config->get('gms_gid');

    }
}