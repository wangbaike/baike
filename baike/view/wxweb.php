<?php

use baike\tools\View;
use baike\tools\UrlPath;
use baike\tools\InputParam;

/**
 * This Tpl designed by wbk
 *
 * contact me by email with wangbaike168@qq.com if you have any question, good luck with you !
 *
 * @filename           wxweb.php
 * @package		Netbeans 8.0.2
 * @author		Administrator
 * @link		http://www.baikeshuo.cn
 * @datetime          2018-2-5 9:57:23
 */
?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <title>测试页面</title>
        <meta content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1, maximum-scale=1" name="viewport" />
        <meta name="format-detection" content="telephone=no, email=no" />
        <meta name="apple-mobile-web-app-status-bar-style" content="white" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- QQ强制竖屏 -->
        <meta name="x5-orientation" content="portrait" />
        <!-- UC强制全屏 -->
        <meta name="full-screen" content="yes" />
        <!-- QQ强制全屏 -->
        <meta name="x5-fullscreen" content="true" />
        <!-- UC应用模式 -->
        <meta name="browsermode" content="application" />
        <!-- QQ应用模式 -->
        <meta name="x5-page-mode" content="app" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <?php View::loadJs('jquery-3.3.1.min'); ?>
        <script type="text/javascript">
            //初始化获取登录二维码
            function getQr() {
                //获取uuid
                $.getJSON('<?php echo UrlPath::siteUrl('wx?a=get_uuid') ?>', function (result) {
                    //显示扫描二维码
                    $('.qr_show').html('<img src="https://login.weixin.qq.com/qrcode/' + result.data + '?t=webwx" width="150" height="150">');
                    $('.msg').html('请扫描二维码并点击确认');
                    loginCheck();
                });
            }
            //检测扫码状态
            function loginCheck() {
                $.getJSON('<?php echo UrlPath::siteUrl('wx?a=get_login') ?>', function (result_2) {
                    //alert(result_2.data.code + result_2.data.icon);
                    switch (result_2.data.code) {
                        case '201'://扫描成功
                            $('.qr_show').html('<img src="' + result_2.data.icon + '" width="150" height="150">');
                            $('.msg').html('扫描成功');
                            loginCheck();
                            break;
                        case '200'://确认登录
                            //alert('登录成功');
                            $('.msg').html('用户已点击确认');
                            loginDone();
                            break;
                        case '408'://用户未扫描，已过期
                            alert('用户未扫描，已过期');
                            break;
                        default :
                            alert(result_2.data.code);
                            break;
                    }
                });
            }
            //登录成功后的一些数据初始化
            function loginDone() {
                $('.msg').html('正在设置登录操作');
                $.getJSON('<?php echo UrlPath::siteUrl('wx?a=get_login_done') ?>', function (result_3) {
                    loginInit();
                });
            }
            //初始化
            function loginInit() {
                $('.msg').html('初始化页面');
                $.getJSON('<?php echo UrlPath::siteUrl('wx?a=get_login_init') ?>', function (result_4) {
                    $('.msg').html('初始化完成');
                    //location.reload();
                });
            }
            //心跳检测
            var timer = 0;
            function synccheck() {
                $.getJSON('<?php echo UrlPath::siteUrl('wx?a=get_synccheck') ?>', function (result_5) {
                    $('.msg').html('心跳检测：' + timer);
                    if (result_5.data.ret === '0') {
                        timer++;
                        $('.msg').html('心跳检测：' + timer);
                    } else {
                        //alert('登录失败');
                    }
                });
            }
            $(function () {
<?php if (!$isLogin): ?>
                    getQr();
<?php else: ?>
                    loginInit();
                    setInterval('synccheck()', 10000);
<?php endif; ?>
            });
        </script>
    </head>
    <body>
        <div class="qr_show"></div>
        <div class="msg"></div>
        <?php print_r($json) ?>
    </body>
</html>

