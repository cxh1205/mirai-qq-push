# mirai的QQ推送服务

## mirai
> mirai 是一个在全平台下运行，提供 QQ Android 协议支持的高效率机器人库  
> 
项目地址[mirai](https://github.com/mamoe/mirai)

## mirai-qq-push
一款基于`mirai`和`mirai-http-api`的消息推送服务，用php来推送消息到QQ号或者QQ群  

### 使用接口
接口简单，仅有3个参数
- msg：纯文本信息 不可省略
- type：group或friend 可与code一起省略
- code：群号或QQ号 可与type一起省略


更详细的内容可以参考[index.php](index.php)

<br>

### 关于文件的解释
- log——消息推送的日志
- key.txt——`mirai`的`SessionKey`
- myurl.txt——网址
- index.php——消息推送帮助页
- push.txt——消息推送服务主体
  - 由php发起对`mirai`的post请求，采用`mirai`默认接口
- data.json——推送key的存储


```json
{
  "key": "temp",# string，推送网页登录的key
  "code": 12345,# int，key所有者的QQ号
  "friends": [],# int，这个key可推送的QQ号
  "group": [123456]# int，这个key可推送的QQ群号
}
```

### 兼容性说明
在[推送帮助文档](index.php)中采用了``http://www.example.com/你的key/``的形式，但实际上的推送链接应该是``http://www.example.com/push.php?key=你的key``，然后再到链接后增加参数，如``http://www.example.com/push.php?key=你的key&msg=你好``。

因为我将这个项目部署在服务器上时应用了如下`nginx`规则：
```nginx
location  / {
    if ($request_filename ~ /[a-zA-Z0-9]+/?) {
       rewrite ^/([a-zA-Z0-9]+)/?$ /push.php?key=$1&$args last;
    }
}
```
将`你的key`转化为php参数，所以达成现在的效果。

如果不配置这个规则，那么访问推送链接应使用``http://www.example.com/push.php?key=你的key``这个形式。因此在采用get和post方法时直接将目的链接改为``http://www.example.com/push.php?key=你的key``即可。

如python中：
```python
import requests
url="http://www.example.com/push.php?key=你的key"
data={'msg':'你好'}
requests.post(url, data=data)
requests.get(url, data=data)
```