<?php
//框架基础类
/**
 * 成员方法
 * run: 启动项目，依次调用下面四个过程
 * * _init: 设置路径
 * * _registerAutoLoad: 注册 类的自动加载
 * * _extend: 扩展，包括了启动会话，令牌生成
 * * _dispatch: 请求分发，结合_getParams. 默认user.IndexController.indexAction
 */
class Framework{
    //启动项目
    public static function run(){
        self::_init();
        self::_registerAutoLoad();
        self::_extend();
        self::_dispatch();
    }
    private static function _init(){
        //DS=>路径分隔符
        define('DS',DIRECTORY_SEPARATOR);
        define('ROOT',getcwd().DS);
        //配置目录常量
        define('APP_PATH',ROOT.'app'.DS);
        define('FRAMEWORK_PATH',ROOT.'framework'.DS);
        define('LIBRARY_PATH',FRAMEWORK_PATH.'library'.DS);
        define('COMMON_PATH',APP_PATH.'common'.DS);
        //获取p c a, 分别代表 前后台、控制器、具体操作
        list($p,$c,$a) = self::_getParams();
        define('PLATFORM', strtolower($p));
        define('PLATFORM_PATH',APP_PATH.PLATFORM.DS);
        define('CONTROLLER_PATH',PLATFORM_PATH.'controller'.DS);
        define('CONTROLLER', strtolower($c));
        define('ACTION',strtolower($a));
        //配置 模型、视图的路径
        define('MODEL_PATH',PLATFORM_PATH.'model'.DS);
        define('VIEW_PATH',PLATFORM_PATH.'view'.DS);
        define('COMMON_VIEW',VIEW_PATH.'common'.DS);
        //ACTION_VIEW能让前端分发到一个新页面
        define('CONTROLLER_VIEW',VIEW_PATH.CONTROLLER.DS);
        define('ACTION_VIEW',CONTROLLER_VIEW.ACTION.'.html');
        require FRAMEWORK_PATH.'function.php';
    }
    //注册自动加载
    private static function _registerAutoLoad(){
        spl_autoload_register(function($class_name){
            $class_name=ucwords($class_name);
            if(strpos($class_name,'Controller')){
                $target=CONTROLLER_PATH."$class_name.class.php";
            }elseif(strpos($class_name,'Model')){
                $target=MODEL_PATH."$class_name.class.php";
            }else{
                $target=LIBRARY_PATH."$class_name.class.php";
            }
            require $target;
        });
    }
    private static function _extend(){
        //设置HttpOnly
        C('PHPSESSID_HTTPONLY')&&ini_set('session.cookie_httponly',1);
        //启动session
        isset($_SESSION) || session_start();
        //生成CSRF令牌
        define('TOKEN',token_get());
        define('IS_POST',$_SERVER['REQUEST_METHOD']=='POST');
    }
    //处理请求
    private static function _dispatch(){
        $c = CONTROLLER.'Controller';
        $a = ACTION.'Action';
        //实现请求分发
        $Controller = new $c();
        $Controller->$a();
    }
    private static function _getParams(){
        $p = (isset($_GET['p'])?$_GET['p']:'home');
        $c = (isset($_GET['c'])?$_GET['c']:'index');
        $a = (isset($_GET['a'])?$_GET['a']:'index');   
        $p = (isset($_POST['p'])?$_POST['p']:$p);
        $c = (isset($_POST['c'])?$_POST['c']:$c);
        $a = (isset($_POST['a'])?$_POST['a']:$a);        
        return [$p,$c,$a];
    }
}