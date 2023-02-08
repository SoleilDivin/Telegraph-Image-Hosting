<?php
/*
 * @Author: Vincent Young
 * @Date: 2022-10-05 05:18:48
 * @LastEditors: Vincent Young
 * @LastEditTime: 2022-10-05 07:08:37
 * @FilePath: /Telegraph-Image-Hosting/Web/api.php
 * @Telegram: https://t.me/missuo
 * 
 * Copyright © 2022 by Vincent, All Rights Reserved. 
 */
header("Content-type:application/json;charset=utf-8");
$file = $_FILES['file'];
$names = $file['name'];
$tmp_names = $file['tmp_name'];
$src = [];
for($i=0; $i < count($tmp_names); $i++) {
    $type = strtolower(substr($names[$i], strrpos($names[$i], '.') + 1));
    if (!is_uploaded_file($tmp_names[$i])) {
        return;
    }
    $ch = curl_init();
    $url = 'https://telegra.ph/upload';
    $post_data = array('file' => new \CURLFile(realpath($tmp_names[$i])));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1); //POST提交
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    $data = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($data, TRUE);
    $src[] = 'https://missuo.ru'.$res[0]['src'];
}
    $result = array(
        'code' => 200,
        'status' => 'success',
        'src' => $src
        );
    $result
    = json_encode($result,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    echo $result;
?>
