<?php
    $key = $_GET['key'];
    if($_GET['key']){
        $key = $_GET['key'];
    }
    else{
        $key = $_POST['key'];
    }
    $my_url = file_get_contents('myurl.txt');
    $data_json = file_get_contents('data.json');
    $json = json_decode($data_json, true);
    for($i=0; $i<sizeof($json); $i++){
        if($json[$i]['key']==$key){
            $data = $json[$i];
            break;
        }
    }
    if($i==sizeof($json)){
        header("Location: $my_url");
    }
    if($_GET['msg']){
        $msg = $_GET['msg'];
    }
    else{
        $msg = $_POST['msg'];
    }
    if($_GET['code']){
        $code = $_GET['code'];
    }
    else{
        $code = $_POST['code'];
    }
    if($_GET['type']){
        $type = $_GET['type'];
    }
    else{
        $type = $_POST['type'];
    }
    $Sessionkey = file_get_contents('key.txt');
    $my_code = $data['code'];
    $data['friends'][]=$my_code;
    $my_key = $data['key'];
    $my_friend = $data['friends'];
    $my_group = $data['group'];
    
    function send_post($url, $postdata) {
        $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => (string)json_encode($postdata),
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
    
    function send_friend($msg, $code){
        global $Sessionkey;
        global $my_friend;
        $flag=0;
        for($i=0; $i<sizeof($my_friend); $i++){
            if($my_friend[$i]==$code){
                $send_data=array(
                        "sessionKey" => (string)($Sessionkey),
                        "target" => (int)$code,
                        "messageChain" => array(
                            array(
                                "type" => "Plain",
                                "text" => $msg
                            )
                        )
                    );
                $flag=1;
                decode_respond(send_post('http://localhost:8080/sendFriendMessage', $send_data));
                break;
            }
        }
        if(!$flag)
            echo "该好友不在您的推送列表中，请联系管理员添加";
    }
    
    function send_group($msg, $code){
        global $Sessionkey;
        global $my_group;
        $flag=0;
        for($i=0; $i<sizeof($my_group); $i++){
            if($my_group[$i]==$code){
                $send_data=array(
                        "sessionKey" => (string)($Sessionkey),
                        "target" => (int)$code,
                        "messageChain" => array(
                            array(
                                "type" => "Plain",
                                "text" => $msg
                            )
                        )
                    );
                $flag=1;
                decode_respond(send_post('http://localhost:8080/sendGroupMessage', $send_data));
                break;
            }
        }
        if(!$flag)
            echo "该群聊不在您的推送列表中，请联系管理员添加";
    }
    
    function decode_respond($msg){
        global $key;
        $text = json_decode($msg, true);
        file_put_contents("log/".$key.".txt", date('Y-m-d H:i:s', time())."    ".$_SERVER["REMOTE_ADDR"]."    ".$text['code']."\r\n" , FILE_APPEND);
        if($text['code']==0){
            echo "发送成功";
        }
        elseif($text['code']==5){
            echo "机器人没有加入群聊或机器人未加该QQ号为好友";
        }
        else{
            // echo $msg;//////////////////////////////////////////////////////////////////
            echo "未知错误，请联系管理员";
        }
    }
    
    if($msg){
        ?><div style='font-size:5em;'><?php
        if(strlen($msg)>15000){
            echo '超过字数限制';
        }
        else{
            if(!$code && !$type){
                send_friend($msg, $my_code);
            }
            elseif($code && $type){
                if($type == 'friend'){
                    send_friend($msg, $code);
                }
                elseif($type == 'group'){
                    send_group($msg, $code);
                }
                else{
                    echo "type参数只能为<span style='color:red;'>friend</span>或者<span style='color:red;'>group</span>";
                }
            }
            else{
                echo "应同时具有code和type参数，且type参数只能为<span style='color:red;'>friend</span>或者<span style='color:red;'>group</span>";
            }
        }
        ?></div><?php
    }
    elseif($code && $type){
        ?><div style='font-size:5em;'><?php
        echo "不能发送空消息";
        ?></div><?php
    }
    else{
        echo file_get_contents($my_url.'index.php?key='.$my_key.'&code='.$my_code);
    }
?>