<?php 
class Tree{  
    /** 
    * 生成树型结构所需要的2维数组 
    * @var array 
    */  
    public $arr = array();  
  
    /** 
    * 生成树型结构所需修饰符号，可以换成图片 
    * @var array 
    */  
    public $icon = array('│','├','└');  
    public $nbsp = " ";  
  
    /** 
    * @access private 
    */  
    public $ret = '';  
    
    public $selid=array();
  
    /** 
    * 构造函数，初始化类 
    * @param array 2维数组，例如： 
    * array( 
    *      1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'), 
    *      2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'), 
    *      3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'), 
    *      4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'), 
    *      5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'), 
    *      6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'), 
    *      7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目二') 
    *      ) 
    */  
    public function __construct($arr=array()){  
       $this->arr = $arr;  
       $this->ret = '';  
       return is_array($arr);  
    }  

    /** 
    * 得到子级数组 
    * @param int 
    * @return array 
    */  
    public function get_child($myid){  
        $a = $newarr = array();  
        if(is_array($this->arr)){  
            foreach($this->arr as $id => $a){  
                if($a['parent_id'] == $myid) $newarr[$id] = $a;  
            }  
        }  
        return $newarr ? $newarr : false;  
    }  
      
    /** 
     * 同上一类方法，jquery treeview 风格，可伸缩样式（需要treeview插件支持） 
     * @param $myid 表示获得这个ID下的所有子级 
     * @param $effected_id 需要生成treeview目录数的id 
     * @param $str 末级样式 
     * @param $str2 目录级别样式 
     * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制 
     * @param $style 目录样式 默认 filetree 可增加其他样式如'filetree treeview-famfamfam' 
     * @param $currentlevel 计算当前层级，递归使用 适用改函数时不需要用该参数 
     * @param $recursion 递归使用 外部调用时为FALSE 
     */  
    function get_treeview($myid,$effected_id='example',$str="<span class='file'>\$name</span>", $str2="<span class='folder'>\$name</span>" ,$showlevel = 0 ,$style='filetree ' , $currentlevel = 1,$recursion=FALSE) {  
        $child = $this->get_child($myid);  
        if(!defined('EFFECTED_INIT')){  
           $effected = ' id="'.$effected_id.'"';  
           define('EFFECTED_INIT', 1);  
        } else {  
           $effected = '';  
        }  
        $placeholder =  '<ul><li><span class="placeholder"></span></li></ul>';  
        if(!$recursion) $this->str .='<ul'.$effected.'  class="'.$style.'">';  
        foreach($child as $id=>$a) {  
            @extract($a);  
            if($showlevel > 0 && $showlevel == $currentlevel && $this->get_child($id)) $folder = 'hasChildren'; //如设置显示层级模式@2011.07.01  
            $floder_status = isset($folder) ? ' class="'.$folder.'"' : '';        
            $this->str .= $recursion ? '<ul><li'.$floder_status.' id=\''.$id.'\'>' : '<li'.$floder_status.' id=\''.$id.'\'>';  
            $recursion = FALSE;  
            if($this->get_child($id)){  
            	$checked='';
            	
            	if(!empty($this->selid)){
            		$checked=in_array($id,$this->selid)?'checked':'';            		
            	}
            	
                eval("\$nstr = \"$str2\";");  
                $this->str .= $nstr;  
                if($showlevel == 0 || ($showlevel > 0 && $showlevel > $currentlevel)) {  
                    $this->get_treeview($id, $effected_id, $str, $str2, $showlevel, $style, $currentlevel+1, TRUE);  
                } elseif($showlevel > 0 && $showlevel == $currentlevel) {  
                    $this->str .= $placeholder;  
                }  
            } else {  
            	$checked='';
            	if(!empty($this->selid)){
            	$checked=in_array($id,$this->selid)?'checked':'';
            	}
                eval("\$nstr = \"$str\";");  
                $this->str .= $nstr;  
            }  
            $this->str .=$recursion ? '</li></ul>': '</li>';  
        }  
        if(!$recursion)  $this->str .='</ul>';  
        return $this->str;  
    }  
      
    
    private function have($list,$item){  
        return(strpos(',,'.$list.',',','.$item.','));  
    }  
}  