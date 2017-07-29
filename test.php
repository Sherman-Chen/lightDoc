<?php
require './vendor/autoload.php';


// 引入需要反射的文件
require 'E:/php/WWW/think5/thinkphp/library/think/model/Relation.php';

// 创建目标渲染引擎
$latte = new Latte\Engine;
$latte->setTempDirectory('./tmp');


// 创建反射
$reflection = new ReflectionClass('think\model\Relation');
$methods = $reflection->getMethods();

// 创建docBlock解析器
$factory  = \phpDocumentor\Reflection\DocBlockFactory::createInstance();

$param['reflection']=$reflection;
$param['factory']=$factory;

echo "\n";
if(!file_exists("./document")){
    if(mkdir("./document")){
        echo "生成document文件夹成功\n";
    }else{
        echo "生成document文件夹失败\n";
    }
}else{
    echo "已生成document文件夹，不再生成\n";
}

$html = $latte->renderToString('./theme/class.latte', $param);
file_put_contents('./document/class.md',$html);