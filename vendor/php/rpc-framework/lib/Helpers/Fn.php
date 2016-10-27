<?php
namespace Helper;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Filesystem\Filesystem as Filesystem;

class Fn
{
    /**
     * 获取服务配置, 服务配置会覆盖全局配置
     *
     * @param $key
     * @return mixed
     */
    public static function C($key = null)
    {
        // 读取当前服务配置
        $local_config = include GEN_DIR . SERVICE . '/Config/config.php';

        if (!is_array($local_config)) {
            $local_config = [];
        }

        // 全局配置
        $global_config = include ROOT . '/config/config.php';

        if (!is_array($global_config)) {
            $global_config = [];
        }

        // 合并全局与当前配置,后者覆盖前者
        $config = array_merge($global_config, $local_config);

        if (empty($config)) {
            return false;
        }

        if (empty($key)) {
            return $config;
        }

        if (false !== strpos($key, '.')) {
            $key_arr = explode('.', $key);

            $cfg = '$config';

            foreach ($key_arr as $key) {
                $cfg .= "['{$key}']";
            }

            eval("\$conf =" . $cfg . ';');

            return $conf;
        }

        return $config[$key];
    }

    /**
     * 写入日志到文件
     * (复杂的日志需求直接使用monolog)
     *
     * @param $message
     * @param array $extra 额外的日志信息
     * @param int|string $level DEBUG 100; INFO 200; NOTICE 250; WARNING 300;
     *                          ERROR 400; CRITICAL 500; ALERT 550; EMERGENCY 600;
     * @param string $channel 通道名称
     */
    public static function logit($message, array $extra = [], $level = 100, $channel = null)
    {

        $logger = new Logger($channel ? $channel : 'default_logger');

        $log_path = static::C('log_path');
        $log_path .= strtolower(SERVICE) . '/';
        $log_name = date('Y.m.d') . '.log';
        $log_file = $log_path . $log_name;

        $fs = new Filesystem();

        if (!$fs->exists($log_file)) {
            $fs->mkdir($log_path);
            $fs->touch($log_file);
        }

        $logger->pushHandler(new StreamHandler($log_file, $level));

        switch ($level) {
            case '100':
                $logger->addDebug($message, $extra);
                break;
            case '200':
                $logger->addInfo($message, $extra);
                break;
            case '250':
                $logger->addNotice($message, $extra);
                break;
            case '300':
                $logger->addWarning($message, $extra);
                break;
            case '400':
                $logger->addError($message, $extra);
                break;
            case '500':
                $logger->addCritical($message, $extra);
                break;
            case '550':
                $logger->addAlert($message, $extra);
                break;
            case '600':
                $logger->addEmergency($message, $extra);
                break;
            default:
                $logger->addDebug($message, $extra);
                break;
        }
    }
}

