<h1 align="center"> weather </h1>

<p align="center">基于 <a href="https://lbs.amap.com/dev/index">高德开放平台</a> 的 PHP 天气信息组件。</p>


## 安装

```shell
$ composer require cannonsir/weather -vvv
```


## 使用

> 在使用本扩展之前，你需要去 [高德开放平台](https://lbs.amap.com/dev/key/app) 注册账号，然后创建应用，获取应用的 API Key

```php
use CannonSir\Weather\Weather;

$weather = new Weather('your api key');
```

## 获取实时天气

```php
$weather->getWeather('成都')
$weather->getLiveWeather('成都', 'json')
```

返回结果示例:

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "四川",
            "city": "成都市",
            "adcode": "510100",
            "weather": "晴",
            "temperature": "24",
            "winddirection": "东",
            "windpower": "≤3",
            "humidity": "94",
            "reporttime": "2019-07-17 23:52:01"
        }
    ]
}
```

## 获取近期天气预报

```php
$weather->getWeather('成都', 'forecasts');
```

返回结果示例

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "成都市",
            "adcode": "510100",
            "province": "四川",
            "reporttime": "2019-07-17 23:52:01",
            "casts": [
                {
                    "date": "2019-07-17",
                    "week": "3",
                    "dayweather": "多云",
                    "nightweather": "晴",
                    "daytemp": "29",
                    "nighttemp": "23",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-07-18",
                    "week": "4",
                    "dayweather": "阵雨",
                    "nightweather": "阵雨",
                    "daytemp": "31",
                    "nighttemp": "23",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-07-19",
                    "week": "5",
                    "dayweather": "阵雨",
                    "nightweather": "阵雨",
                    "daytemp": "31",
                    "nighttemp": "24",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-07-20",
                    "week": "6",
                    "dayweather": "阵雨",
                    "nightweather": "小雨",
                    "daytemp": "33",
                    "nighttemp": "23",
                    "daywind": "无风向",
                    "nightwind": "无风向",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                }
            ]
        }
    ]
}
```

> 通过传递第最后一个参数可设置返回值类型: `json/xml` 默认`json`格式

## 参数说明

```php
array|string getWeather(string $city, string $type = 'live', string $format = 'json')
```

> + $city - 城市名，比如：“深圳”；   
> + $type - 返回内容类型：live: 返回实况天气 / forecasts: 返回预报天气；    
> + $format - 输出的数据格式，默认为 json 格式，当 format 设置为 “xml” 时，输出的为 XML 格式的数据。

## 在 Laravel 中使用
在Laravel中使用也是同样的安装方式，配置写在 config/services.php 中:

```php
'weather' => [
    'key' => env('AMAP_API_KEY')
]
```

然后在 `.env` 文件中配置 `AMAP_API_KEY`

```dotenv
AMAP_API_KEY=xxxxxxxxxxxxxxxxxxxxx
```

## 参考

+ [高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)

## License

MIT
