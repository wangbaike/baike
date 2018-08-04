<?php

/*
 * ------调用方便，快速入手-------
 * 这个说明是为了让您快速了解本系统！
 * ----------简单易用-------------
 * 
 * 创建于2018-04-26 最新修改时间2018-05-06
 * 所有的文件加载请在命名空间下面用 use加载，禁止在程序中使用 \ 开头的加载调用方式！
 * 
 * 【程序执行流程】
 * WEB程序执行流程：入口文件index.php ->路由解析 ->加载对应控制器 ->调用数据 ->调用视图 ->输出结果。
 * 脚本执行流程：/use/bin/php 命令执行 cli.php ->解析argv 参数获取要执行的类库路径，把其它参数写入到GET变量中 ->加载对应类库 ->执行程序。
 * 脚本的执行方式为 /usr/bin/php cli.php worker/PHPtest/run 其中worker/PHPtest为脚本类名称 run为要执行的指定方法。
 * 
 * 【目录结构】
 *  |- baike/ 程序目录，包含配置文件、控制器、类库、数据模型、工具和视图文件
 *      |- configs/             配置文件目录
 *      |- controller/          控制器文件目录（控制器类文件的首字母必须是大写）
 *      |- data/                缓存数据和日志文件目录
 *      |- framework/           框架提供的目录
 *          |- exception/       异常处理类库目录
 *          |- libs/            框架类库目录
 *          |- model/           框架数据模型目录
 *          |- tools/           框架提供的一些工具目录
 *          |- Core.php         系统全局文件，用来走系统的一些初始化操作和类库的耦合管理
 *          |- Route.php        路由文件，用来控制入口文件的路由，目前支持pathinfo规则，支持无限目录分类
 *          |- bootstrap.php    自动加载机制文件
 *      |- libs/                用户自定义的类库文件目录
 *      |- middleware/          用户自定义的中间件类库目录
 *      |- model/               用户自定义的数据模型文件目录
 *      |- tools/               工具类文件目录
 *      |- view/                视图文件目录    
 *  |- cli/                     脚本执行文件目录
 *      |- worker/
 *          |- PHPtest.php      测试脚本 其中的run方法为执行主方法，要操作的程序从这里开始执行
 *      |- cli.php              自动加载机制文件
 *  |- public/                  网站对外可访问的目录，里面包含静态资源文件和上传的文件
 *      |- assets/              静态资源文件夹
 *      |- index.php            入口文件
 * 
 * 【路由说明】
 * 路由说明：/index.php/home/index/name/baike/age/25 等于 /index.php/home/index?name=baike&age=25
 * 前两个参数home和index分别为 baike/controller 文件里面的Home.php类文件和它的方法index
 * 
 * 【文件调用（引用）机制】
 * 类库、模型、配置、工具、控制器类文件的调用用 use直接调用，然后按照正常使用方法使用。
 * 
 * 【模板文件使用】
 * 引入模板文件 use baike\tools\View;
 * 然后 View::load('模板文件名');即可，建议先看看可用的方法，选择合适的调用方式
 * 
 * 【中间件】
 * 在接收到用户的请求之后，处理请求之前可以加载一些定置化的类库，比如记日志、权限验证
 * 为规范数据默认存放目录为 /baike/middleware/ 您也可以添加任何一个类库到中间件容器中
 * 添加方法为：
 *      Core::addMiddleClass('\\baike\middleware\RequestLog', 'record');
 *      可以根据自己需要添加系统内任何类库的及公共方法，支持静态方法和常规方法
 * 
 */

use baike\framework\Core;

header("Content-type:text/html;charset=utf-8");
/**
 * 设置时区
 */
date_default_timezone_set('Asia/Shanghai');
/**
 * 设置警告级别
 */
error_reporting(E_ALL);
/**
 * 定义前端路径
 */
define('WEB_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
/**
 * 定义程序目录
 */
define('APP_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'baike' . DIRECTORY_SEPARATOR);
/**
 * 加载全局脚本
 */
require APP_PATH . DIRECTORY_SEPARATOR . 'framework' . DIRECTORY_SEPARATOR . 'bootstrap.php';
/**
 * 添加中间件，支持多次添加
 */
Core::addMiddleClass('\\baike\middleware\RequestLog', 'record');
/**
 * 初始化系统
 */
Core::run();




