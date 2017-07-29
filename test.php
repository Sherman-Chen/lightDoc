<?php
require './vendor/autoload.php';


// 引入需要反射的文件
require 'E:/code/app/git/web/driver_web/thinkphp/library/think/model/Relation.php';
require 'E:/code/app/git/web/driver_web/thinkphp/library/think/model/relation/OneToOne.php';
require 'E:/code/app/git/web/driver_web/thinkphp/library/think/model/relation/hasOne.php';

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

$html = $latte->renderToString('./theme/class.latte', $param);
file_put_contents('./dest/class.md',$html);