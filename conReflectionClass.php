<?php
class conReflectionClass implements ReflectionClass{
    private $docBlockFactory;
    private $docBlock;
    // 设置docBlockFactory
    public function setDocBlockFactory($docBlockFactory){
        $this->docBlockFactory=$docBlockFactory;
    }

    // 获取docBlock
    public function getDocBlock(){
        if($this->getDocBlock){
            return $this->getDocBlock;
        }
        $comment=$this->getDocComment(); 
        if(!$comment){
            return false;
        }
        $this->getDocBlock=$this->docBlockFactory->create($comment);
        return $this->getDocBlock;

        
    }
}