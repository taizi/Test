<?php 
class ArrayNode {  
    var $arr = array();  
    public function __construct($arr=array()){  
       $this->arr = $arr;  
       return is_array($arr);  
    } 
    function getResult($pid=0){
        $ret = array();
        foreach($this->arr as $k => $v) {
            if($v['pid'] == $pid) {
                $tmp = $this->arr[$k];unset($this->arr[$k]);
                $tmp['children'] = $this->getResult($v['node_id']);
                $ret[] = $tmp;
            }
        }
        return $ret;
    }
	
}  