<?php

class Config {
    /**
     * @var string
     */
    protected $configPath = 'configs/config.ini';

    /**
     * @var array
     */
    protected static $configs = array();

    private static $instance;

    public static function getConfig($configPath = null)
    {
        if (!self::$instance) {
            self::$instance = new Config($configPath);
        }
        return self::$instance;
    }
    /**
     * @param string|null $configPath
     */
    protected function __construct($configPath = null)
    {
        if ($configPath) {
            $this->configPath = $configPath;
        }

        try {
            if ((self::$configs = parse_ini_file($this->configPath)) === false) {
                throw new \Exception('Unable to open config file');
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param $key
     * @return string|bool
     */
    public function get($key)
    {
        return self::$configs[$key] ?: false;
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        self::$configs[$key] = $value;
    }
}