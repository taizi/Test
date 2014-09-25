<?php
define('MESSAGE_SEND_NUMS', 100);//每隔3秒发送的次数
include_once 'Mysql.class.php';

doAutoSendMessage();

function M($moudel=''){
	if($moudel==''){ echo '必须指定表名';die;}
	//$config['DB_HOST'],$config['DB_USER'],$config['DB_PWD'],$config['DB_NAME']
	$db=new Mysql();
	return $db->table($moudel);
}

//前台会员总数
function count_member(){
	return M('Member')->count();
}
//群发消息
function sendMessage($messid,$groupid=0,$startCount=0,$total){
	    $pagenum=ceil($total/MESSAGE_SEND_NUMS);
		if($startCount==$pagenum-1){ //最后一页的条数
			//$nums=ceil($total%MESSAGE_SEND_NUMS);
			 $nums=fmod(floatval($total),MESSAGE_SEND_NUMS);//取余  防止出现   45%100=44 的情况
		}else{
			$nums=MESSAGE_SEND_NUMS;
		} 
		
    	$memberidarray=M('Member')->field('id')->order('id asc')->limit($startCount,$nums)->select();
    	$ids=array();
    	foreach ($memberidarray as $k=>$v){
    		if($k > $total-1) continue;// 当条数超过设定的发送条数，就跳过
    		$nowtime=time();
    		$ids[]=array('uid'=>$v['id'],'messid'=>$messid,'isflag'=>0,'create_time'=>$nowtime);	
    	}
    	if(M('short_allsend')->add($ids)){
    		return true;
    	}
    	return false;	
    }
//查找一条和当前时间最近的信息  执行自动发送
function get_message_by_time(){
    	$times=time();
    	$where['status']=1;//状态为已审核
    	$where['messtype']=1;//消息类型为定时发送
    	//$where['sendtime']=array('EGT',$times-7200);  array($times-7200,$times)
    	$where['sendtime']=array('BETWEEN',array($times-3601,$times));//查找一小时以内的定时任务
    	$mess=M('short_message')->where($where)->order('sendtime desc')->select();
    	if($mess){
    		return $mess;
    	}
    	return false;
}

//多条发送
function doAutoSendMessage(){  //doAutoSendMessage
	$mess=get_message_by_time();
	if($mess){
		$model=M('short_message');
		foreach ($mess as $k=>$v){  //多条定时任务循环发送
			everySend($v);
			$where['id']=$v['id'];
			$data['status']=2;
		    $model->where($where)->save($data);//	修改状态为2
		}
	}
}
//每条任务的发送   如果每条任务的条数超过设定的每次发送条数    就分页发送   
function everySend($mess){
	$total=count_member();
	$num=MESSAGE_SEND_NUMS;
	$totalPage=ceil($total/$num);
	$p=1;
	while ($p<=$totalPage){
		$startCount=($p-1)*$num;
		sendMessage($mess['id'],$mess['level'],$startCount,$total);
		$p++;
		sleep(3);
	}
}










