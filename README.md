# mirai的QQ推送服务

## mirai
> mirai 是一个在全平台下运行，提供 QQ Android 协议支持的高效率机器人库  
> 
项目地址[mirai](https://github.com/mamoe/mirai)

## mirai-qq-push
一款基于`mirai`和`mirai-http-api`的消息推送服务，帮助你搭建自己的消息推送系统。

本项目使用php来推送消息到QQ号或者QQ群，接口类似于Qmsg。

<br>


### 使用帮助
#### http接口
- msg：纯文本信息 不可省略
- type：group或friend 可与code一起省略
- code：群号或QQ号 可与type一起省略


更详细的内容可以参考[index.php](index.php)

#### 关于文件的解释
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

<br>

### 搭建过程
#### 准备工作
1. 配置好[mirai](https://github.com/mamoe/mirai)机器人，并登录`QQbot`
2. 安装`v2.X`版本的[mirai-api-http](https://github.com/project-mirai/mirai-api-http/blob/master/docs/api/API.md)插件

#### 使用方法
1. 运行bot机器人
2. 根据api获取SessionKey写入[key.txt](key.txt)中
3. 浏览器输入`你的网址`进行测试

<br>

### 改进说明
想要采用Qmsg一样链接形式如：``http://www.example.com/你的key/``，增加参数后为``http://www.example.com/你的key/?msg=你好``。

使用nginx服务器，在server中加入如下规则：

```nginx
location  / {
    if ($request_filename ~ /[a-zA-Z0-9]+/?) {
       rewrite ^/([a-zA-Z0-9]+)/?$ /push.php?key=$1&$args last;
    }
}
```

即将路径转化为push.php的key参数

<br>

### 展望
- [x] 寻找改进方法，使链接类似于Qmsg
- [ ] 增加调用后返回的数据格式，如json等
- [ ] 增加消息增强，如发送图片和艾特
