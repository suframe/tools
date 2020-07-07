<?php

namespace suframe\tools\umeng;

use suframe\tools\umeng\notification\ios\IOSBroadcast;
use suframe\tools\umeng\notification\ios\IOSCustomizedcast;
use suframe\tools\umeng\notification\ios\IOSFilecast;
use suframe\tools\umeng\notification\ios\IOSGroupcast;
use suframe\tools\umeng\notification\ios\IOSUnicast;
use Exception;

class IOS
{
    protected $appkey = NULL;
    protected $appMasterSecret = NULL;
    protected $timestamp = NULL;

    function __construct($key, $secret)
    {
        $this->appkey = $key;
        $this->appMasterSecret = $secret;
        $this->timestamp = strval(time());
    }

    /**
     * 批量发送
     * @param $alert
     * @param array $data
     * @return bool|string
     */
    function sendBroadcast($alert, $data = [])
    {
        try {
            $brocast = new IOSBroadcast();
            $brocast->setAppMasterSecret($this->appMasterSecret);
            $brocast->setPredefinedKeyValue("appkey", $this->appkey);
            $brocast->setPredefinedKeyValue("timestamp", $this->timestamp);

            $brocast->setPredefinedKeyValue("alert", "{$alert}");
            // Set 'production_mode' to 'true' if your app is under production mode
            $brocast->setPredefinedKeyValue("production_mode", "false");
            // Set customized fields
            foreach ($data as $key => $item) {
                $brocast->setCustomizedField($key, $item);
            }
            // print("Sending broadcast notification, please wait...\r\n");
            return $brocast->send();
            // print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            // print("Caught exception: " . $e->getMessage());
        }
    }

    /**
     * 按设备token发送
     * @param $alert
     * @param $device_tokens
     * @param array $data
     * @return bool|string
     * @throws Exception
     */
    function sendUnicast($alert, $device_tokens, $data = [])
    {
        // try {
        $unicast = new IOSUnicast();
        $unicast->setAppMasterSecret($this->appMasterSecret);
        $unicast->setPredefinedKeyValue("appkey", $this->appkey);
        $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set your device tokens here
        $unicast->setPredefinedKeyValue("device_tokens", $device_tokens);
        $unicast->setPredefinedKeyValue("alert", "$alert");
        // Set 'production_mode' to 'true' if your app is under production mode
        $unicast->setPredefinedKeyValue("production_mode", "false");
        // Set customized fields
        foreach ($data as $key => $item) {
            $unicast->setCustomizedField($key, $item);
        }
        // // print("Sending unicast notification, please wait...\r\n");
        return $unicast->send();
        // // print("Sent SUCCESS\r\n");
        // } catch (Exception $e) {
        // // print("Caught exception: " . $e->getMessage());
        // }
    }

    /**
     * 发送图片文件
     * @param $alert
     * @param $image
     * @return bool|string
     */
    function sendFilecast($alert, $image)
    {
        try {
            $filecast = new IOSFilecast();
            $filecast->setAppMasterSecret($this->appMasterSecret);
            $filecast->setPredefinedKeyValue("appkey", $this->appkey);
            $filecast->setPredefinedKeyValue("timestamp", $this->timestamp);

            $filecast->setPredefinedKeyValue("alert", "{$alert}");
            // Set 'production_mode' to 'true' if your app is under production mode
            $filecast->setPredefinedKeyValue("production_mode", "false");
            // print("Uploading file contents, please wait...\r\n");
            // Upload your device tokens, and use '\n' to split them if there are multiple tokens
//            $filecast->uploadContents("aa" . "\n" . "bb");
            $filecast->uploadContents($image);
            // print("Sending filecast notification, please wait...\r\n");
            return $filecast->send();
            // print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            // print("Caught exception: " . $e->getMessage());
        }
    }

    /**
     * 按tag分组发送
     * @param $alert
     * @param $tags
     * @return bool|string
     */
    function sendGroupcast($alert, $tags)
    {
        try {
            /*
              *  Construct the filter condition:
              *  "where":
              *	{
              *		"and":
              *		[
                *			{"tag":"iostest"}
              *		]
              *	}
              */
            $filter = array(
                "where" => array(
                    "and" => $tags
                )
            );

            $groupcast = new IOSGroupcast();
            $groupcast->setAppMasterSecret($this->appMasterSecret);
            $groupcast->setPredefinedKeyValue("appkey", $this->appkey);
            $groupcast->setPredefinedKeyValue("timestamp", $this->timestamp);
            // Set the filter condition
            $groupcast->setPredefinedKeyValue("filter", $filter);
            $groupcast->setPredefinedKeyValue("alert", "{$alert}");
            // Set 'production_mode' to 'true' if your app is under production mode
            $groupcast->setPredefinedKeyValue("production_mode", "false");
            // print("Sending groupcast notification, please wait...\r\n");
            return $groupcast->send();
            // print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            // print("Caught exception: " . $e->getMessage());
        }
    }

    /**
     * 自有的账号系统(alias) 来发送消息给指定的账号或者账号群
     * @param $alert
     * @param $alias
     * @param $alias_type
     * @return bool|string
     */
    function sendCustomizedcast($alert, $alias, $alias_type)
    {
        try {
            $customizedcast = new IOSCustomizedcast();
            $customizedcast->setAppMasterSecret($this->appMasterSecret);
            $customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
            $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);

            // Set your alias here, and use comma to split them if there are multiple alias.
            // And if you have many alias, you can also upload a file containing these alias, then
            // use file_id to send customized notification.
            $customizedcast->setPredefinedKeyValue("alias", "{$alias}");
            // Set your alias_type here
            $customizedcast->setPredefinedKeyValue("alias_type", "{$alias_type}");
            $customizedcast->setPredefinedKeyValue("alert", "{$alert}");
            // Set 'production_mode' to 'true' if your app is under production mode
            $customizedcast->setPredefinedKeyValue("production_mode", "false");
            // print("Sending customizedcast notification, please wait...\r\n");
            return $customizedcast->send();
            // print("Sent SUCCESS\r\n");
        } catch (Exception $e) {
            // print("Caught exception: " . $e->getMessage());
        }
    }
}