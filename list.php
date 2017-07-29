<?php
require './vendor/autoload.php';

//$dir
function list_dir_file($dir){
    if(is_dir($dir)){
        $handle = opendir($dir);
        if($handle){
            while (($file = readdir($handle)) !== false) {
                if ($file != "." && $file != "..") {
                    $cur_path = $dir . '/' . $file;
                    if (is_dir( $cur_path))
                    {
                        list_dir_file($cur_path);
                    }else{
                        $ext = pathinfo($file,PATHINFO_EXTENSION);
                        if ($ext == 'php') {
                            //echo "$cur_path<br>";
                            $str = file_get_contents($cur_path);
                            $strArr = explode(';',$str);
                            $strArr = explode(' ',$strArr[0]);
                            $namespace = end($strArr);
                            make($cur_path,$namespace);
                        }
                    }
                }
            }
            closedir($handle);
        }
    }
    
    return 'not a dir';
}

function make($cur_path,$namespace){
    // 引入需要反射的文件
    require "$cur_path";
    $pathinfo = pathinfo($cur_path);

    // 创建目标渲染引擎
    $latte = new Latte\Engine;
    $latte->setTempDirectory('./tmp');


    // 创建反射
    $reflection = new ReflectionClass($namespace . '\\' . $pathinfo['filename']);
    $methods = $reflection->getMethods();

    // 创建docBlock解析器
    $factory  = \phpDocumentor\Reflection\DocBlockFactory::createInstance();

    $param['reflection']=$reflection;
    $param['factory']=$factory;


    $html = $latte->renderToString('./theme/class.latte', $param);
    file_put_contents($pathinfo['dirname'] . '/' . $pathinfo['filename'] . '.md',$html);
};

list_dir_file("E:\\php\\WWW\\test\\tp\\thinkphp\\library\\think");