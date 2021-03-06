<?php

namespace suframe\tools\umeng;

use suframe\tools\umeng\notification\android\AndroidBroadcast;
use suframe\tools\umeng\notification\android\AndroidCustomizedcast;
use suframe\tools\umeng\notification\android\AndroidFilecast;
use suframe\tools\umeng\notification\android\AndroidGroupcast;
use suframe\tools\umeng\notification\android\AndroidUnicast;
use Exception;

class Android
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
     * @param $title
     * @param array $data
     * @param string $ticker
     * @param string $text
     * @return bool|string
     * @throws Exception
     */
    function sendBroadcast($title, $data = [], $ticker = '', $text = '')
    {
//        try {
        $ticker = $ticker ?: $title;
        $text = $text ?: $title;
        $brocast = new AndroidBroadcast();
        $brocast->setAppMasterSecret($this->appMasterSecret);
        $brocast->setPredefinedKeyValue("appkey", $this->appkey);
        $brocast->setPredefinedKeyValue("timestamp", $this->timestamp);
        $brocast->setPredefinedKeyValue("ticker", "{$title}");
        $brocast->setPredefinedKeyValue("title", "{$ticker}");
        $brocast->setPredefinedKeyValue("text", "{$text}");
        $brocast->setPredefinedKeyValue("after_open", "go_app");
        // Set 'production_mode' to 'false' if it's a test device.
        // For how to register a test device, please see the developer doc.
        $brocast->setPredefinedKeyValue("production_mode", "true");
        // [optional]Set extra fields
        foreach ($data as $key => $datum) {
            $brocast->setExtraField($key, $datum);
        }
        // print("Sending broadcast notification, please wait...\r\n");
        return $brocast->send();
        // print("Sent SUCCESS\r\n");
//        } catch (Exception $e) {
        // print("Caught exception: " . $e->getMessage());
//        }
    }

    /**
     * 按设备token发送
     * @param $title
     * @param $device_tokens
     * @param array $data
     * @param string $text
     * @param string $ticker
     * @return bool|string
     * @throws Exception
     */
    function sendUnicast($title, $device_tokens, $data = [], $text = '', $ticker = '')
    {
//        try {
        $ticker = $ticker ?: $title;
        $text = $text ?: $title;
        if (is_array($device_tokens)) {
            $device_tokens = implode(',', $device_tokens);
        }
        $unicast = new AndroidUnicast();
        $unicast->setAppMasterSecret($this->appMasterSecret);
        $unicast->setPredefinedKeyValue("appkey", $this->appkey);
        $unicast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set your device tokens here
        $unicast->setPredefinedKeyValue("device_tokens", $device_tokens);
        $unicast->setPredefinedKeyValue("ticker", "{$ticker}");
        $unicast->setPredefinedKeyValue("title", "{$title}");
        $unicast->setPredefinedKeyValue("text", "{$text}");
        $unicast->setPredefinedKeyValue("after_open", "go_custom");
        $unicast->setPredefinedKeyValue("custom", " 自定义内容 ");
        // Set 'production_mode' to 'false' if it's a test device.
        // For how to register a test device, please see the developer doc.
        $unicast->setPredefinedKeyValue("production_mode", "true");
        // Set extra fields
        foreach ($data as $key => $datum) {
            $unicast->setExtraField($key, $datum);
        }
        return $unicast->send();
        /*} catch (Exception $e) {
        }*/
    }

    /**
     * 发送图片消息
     * @param $title
     * @param $image
     * @param string $text
     * @param string $ticker
     * @return bool|string
     * @throws Exception
     */
    function sendFilecast($title, $image, $text = '', $ticker = '')
    {
//        try {
        $ticker = $ticker ?: $title;
        $text = $text ?: $title;
        $filecast = new AndroidFilecast();
        $filecast->setAppMasterSecret($this->appMasterSecret);
        $filecast->setPredefinedKeyValue("appkey", $this->appkey);
        $filecast->setPredefinedKeyValue("timestamp", $this->timestamp);
        $filecast->setPredefinedKeyValue("ticker", "{$ticker}");
        $filecast->setPredefinedKeyValue("title", "{$title}");
        $filecast->setPredefinedKeyValue("text", "{$text}");
        $filecast->setPredefinedKeyValue("after_open", "go_app");  //go to app
        // print("Uploading file contents, please wait...\r\n");
        // Upload your device tokens, and use '\n' to split them if there are multiple tokens
//            $filecast->uploadContents("aa" . "\n" . "bb");
        $filecast->uploadContents($image);
        // print("Sending filecast notification, please wait...\r\n");
        return $filecast->send();
        // print("Sent SUCCESS\r\n");
//        } catch (Exception $e) {
        // print("Caught exception: " . $e->getMessage());
//        }
    }

    /**
     * 按tag分组发送
     * @param $ticker
     * @param $title
     * @param $text
     * @param $tags
     * @return bool|string
     */
    function sendGroupcast($title, $tags, $text = '', $ticker = '')
    {
//        try {
        /*
          *  Construct the filter condition:
          *  "where":
          *	{
          *		"and":
          *		[
            *			{"tag":"test"},
            *			{"tag":"Test"}
          *		]
          *	}
          */
        $filter = array(
            "where" => array(
                "and" => $tags
            )
        );
        $ticker = $ticker ?: $title;
        $text = $text ?: $title;

        $groupcast = new AndroidGroupcast();
        $groupcast->setAppMasterSecret($this->appMasterSecret);
        $groupcast->setPredefinedKeyValue("appkey", $this->appkey);
        $groupcast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set the filter condition
        $groupcast->setPredefinedKeyValue("filter", $filter);
        $groupcast->setPredefinedKeyValue("ticker", "{$ticker}");
        $groupcast->setPredefinedKeyValue("title", "{$title}");
        $groupcast->setPredefinedKeyValue("text", "{$text}");
        $groupcast->setPredefinedKeyValue("after_open", "go_app");
        // Set 'production_mode' to 'false' if it's a test device.
        // For how to register a test device, please see the developer doc.
        $groupcast->setPredefinedKeyValue("production_mode", "true");
        // print("Sending groupcast notification, please wait...\r\n");
        return $groupcast->send();
        // print("Sent SUCCESS\r\n");
//        } catch (Exception $e) {
        // print("Caught exception: " . $e->getMessage());
//        }
    }

    /**
     * 自有的账号系统(alias) 来发送消息给指定的账号或者账号群
     * @param $title
     * @param $alias
     * @param $alias_type
     * @param string $text
     * @param string $ticker
     * @return bool|string
     * @throws Exception
     */
    function sendCustomizedcast($title, $alias, $alias_type, $text = '', $ticker = '')
    {
//        try {
        $ticker = $ticker ?: $title;
        $text = $text ?: $title;
        $customizedcast = new AndroidCustomizedcast();
        $customizedcast->setAppMasterSecret($this->appMasterSecret);
        $customizedcast->setPredefinedKeyValue("appkey", $this->appkey);
        $customizedcast->setPredefinedKeyValue("timestamp", $this->timestamp);
        // Set your alias here, and use comma to split them if there are multiple alias.
        // And if you have many alias, you can also upload a file containing these alias, then
        // use file_id to send customized notification.
        $customizedcast->setPredefinedKeyValue("alias", "{$alias}");
        // Set your alias_type here
        $customizedcast->setPredefinedKeyValue("alias_type", "{$alias_type}");
        $customizedcast->setPredefinedKeyValue("ticker", "{$ticker}");
        $customizedcast->setPredefinedKeyValue("title", "{$title}");
        $customizedcast->setPredefinedKeyValue("text", "{$text}");
        $customizedcast->setPredefinedKeyValue("after_open", "go_app");
        // print("Sending customizedcast notification, please wait...\r\n");
        return $customizedcast->send();
        // print("Sent SUCCESS\r\n");
//        } catch (Exception $e) {
        // print("Caught exception: " . $e->getMessage());
//        }
    }

}