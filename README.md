/*
 * 这个说明是为了让您快速了解本系统！
 * 
 * 
 * 创建于2018-04-26
 * 
 * 
 * 【程序执行流程】
 * 
 * WEB程序执行流程：入口文件index.php ->路由解析 ->加载对应控制器 ->调用数据 ->调用视图 ->输出结果。
 * 脚本执行流程：/use/bin/php 命令执行 cli.php ->解析argv 参数获取要执行的类库路径，把其它参数写入到GET变量中 ->加载对应类库 ->执行程序。
 * 脚本的执行方式为 /usr/bin/php cli.php worker/PHPtest/main 其中worker/PHPtest为脚本类名称 run为要执行的指定方法。
 * 
 * 【目录结构】
 * 
 *  |- public/  网站对外可访问的目录，里面包含静态资源文件和上传的文件
 *      |- assets/  静态资源文件夹
 *      |- index.php  入口文件
 *      |- Route.php  路由文件，用来控制入口文件的路由，目前支持pathinfo规则，支持无限目录分类。
 *              路由说明：/index.php/home/index/name/baike/age/25 等于 /index.php/home/index?name=baike&age=25
 *              前两个参数home和index分别为 baike/controller 文件里面的Home.php类文件和它的方法index
 * 
 * 
 *  |- cli/  脚本执行文件目录
 *       |- worker/
 *            |- PHPtest.php 测试脚本 其中的run方法为执行主方法，要操作的程序从这里开始执行
 * 
 *  |- baike/ 程序目录，包含配置文件、控制器、类库、数据模型、工具和视图文件
 *      |- configs/        配置文件目录
 *      |- controller/     控制器文件目录
 *          |- data/       缓存数据和日志文件目录
 *      |- libs/           类库文件目录
 *      |- middle/         中间件类库目录
 *      |- model/          数据模型文件目录
 *      |- tools/          工具类文件目录
 *      |- view/           视图文件目录
 *      |- Core.php        系统全局容器
 *      |- bootstrap.php   自动加载机制文件
 * 
 * 
 * 
 * 【文件调用（引用）机制】
 * 
 * 类库、模型、配置、工具、控制器类文件的调用用 use直接调用，然后按照正常使用方法使用。
 * 
 * 
 * 
 * 【模板文件使用】
 * 
 * 引入模板文件 use baike\tools\View;
 * 然后 View::load('模板文件名');即可，建议先看看可用的方法，选择合适的调用方式
 * 
 * 
 * 
 * 【中间件】
 * 
 * 在接收到用户的请求之后，处理请求之前可以加载一些定置化的类库，比如记日志、权限验证
 * 
 * 为规范数据默认存放目录为 /libs/middle 您也可以添加任何一个类库到中间件容器中
 * 
 * 添加方法为：
 *      Core::addMiddleClass('\\baike\middleware\RequestLog', 'record');
 *      可以根据自己需要添加系统内任何类库的及公共方法，支持静态方法和常规方法
 * 
 */
