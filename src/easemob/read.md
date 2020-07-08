# 环信im

此库基于：https://github.com/suframe/laravel-easemob 修改

```
$config = [
    'domain_name' => '',
    'org_name' => '',
    'app_name' => '',
    'client_id' => '',
    'client_secret' => '',
];
$cache = 缓存对象; 需要支持get,set,delete,has4个方法
return $this->sdk = new SDK($config, $cache);
```