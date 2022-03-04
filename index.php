<?php
    $k = $_GET['key'];
    $c = $_GET['code'];
    $my_url = file_get_contents('myurl.txt');
    if($k){
        $key = $k;
    }
    else{
        $key = "<span style='color:red'>你的key</span>";
    }
    if($c){
        $code = $c;
    }
    else{
        $code = "<span style='color:red'>你的QQ号</span>";
    }
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="cxh">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.0, user-scalable=yes" />   
    <meta name="apple-mobile-web-app-capable" content="yes" />  
    <meta name="format-detection" content="telephone=no" />  
    <title>推送帮助文档</title>
    <style>
        html{
            background-color: rgb(228, 228, 228);
        }
        body{
            margin: 0 2em 0;;
        }
        .body{
            padding: 2em 0 2em;
        }
        .text{
            margin: 0em;
            word-wrap: break-word;
        }
        .title{
            font-size: 2em;
            font-weight: 600;
        }
        .block{
            margin: 0 0 1em;
        }
        .sub-block{
            border-radius: 1em;
            background-color: white;
            padding: 1em;
        }
        .blue{
            color: blue;
        }
        .red{
            color: red;
        }
        .tip{
            color: rgb(150, 150, 150);
            margin: 0em;
        }
        .sub-title{
            margin: 0em;
            font-size: 1.3em;
            font-weight: 520;
        }
    </style>
</head>
<body>
    <div class='body'>
        <div class='block'>
            <div class="title">怎么用</div>
            <div class='sub-block'>
                <p class="text">专属的key链接：</p>
                <p class="text">$my_url<?php echo $key; ?>/?msg=<span class='blue'>消息</span>&type=<span class='blue'>group或者friend</span>&code=<span class='blue'>群号或者QQ号</span></p>
                <p class="tip">目前已支持GET和POST方式</p>
            </div>
        </div>
        <div class='block'>
            <div class="title">参数解释</div>
            <div class='sub-block'>
                <p class='text'>msg：纯文本信息  <span class='red'>不可省略</span></p>
                <p class='text'>type：group或friend  <span class='red'>可与code一起省略</span></p>
                <p class='text'>code：群号或QQ号  <span class='red'>可与type一起省略</span></p>
            </div>
        </div>
        <div class='block'>
            <div class="title">GET方式示例</div>
            <div class='sub-block'>
                <p class='sub-title'>仅输入msg</p>
                <?php
                    if($k && $c)
                        echo "<p class='text'><a href='$my_url".$key."/?msg=你好'>$my_url".$key."/?msg=你好</a>（可以点一下查看效果）</p>";
                    else
                        echo "<p class='text'>$my_url".$key."/?msg=你好</p>"
                ?>
                <p class='tip'>默认发送给自己的QQ号</p>
                <p class='text'><hr></p>
                <p class='sub-title'>输入完整参数</p>
                <?php
                    if($k && $c)
                        echo "<p class='text'><a href='$my_url".$key."/?type=friend&code=".$code."&msg=你好'>$my_url".$key."/?type=friend&code=".$code."&msg=你好</a>（可以点一下查看效果）</p>";
                    else
                        echo "<p class='text'>$my_url".$key."/?type=friend&code=".$code."&msg=你好</p>"
                ?>
                <p class='tip'>此链接与上面的链接等价</p>
            </div>
        </div>
        <div class='block'>
            <div class="title">POST方式示例</div>
            <div class='sub-block'>
                <p class='sub-title'>以python为例</p>
                <p class='text'>import requests</p>
                <?php
                    echo "<p class='text'>url=\"$my_url".$key."/\"</p>";
                ?>
                <p class='text'>data={'msg':'你好'}</p>
                <p class='text'>requests.post(url, data=data)</p>
                <p class='tip'>默认发送给自己的QQ号</p>
                <p class='text'><hr></p>
                <p class='text'>import requests</p>
                <?php
                    echo "<p class='text'>url=\"$my_url".$key."/\"</p>";
                ?>
                <p class='text'>data={'msg':'你好', 'type':'friend', 'code', <?php echo $code ?>}</p>
                <p class='text'>requests.post(url, data=data)</p>
                <p class='tip'>此请求与上面的请求等价</p>
            </div>
        </div>
    </div>
</body>
</html>