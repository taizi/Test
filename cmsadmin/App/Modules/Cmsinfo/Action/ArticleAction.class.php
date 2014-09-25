<?php
class ArticleAction extends BaseAction{
	public function index(){
		import("Page",LIB_PATH.'Util');
		$newsView = D('NewsView');
		$hubType= D('HubTypeView');
	
		if($this->_request('search_style')){
			switch ($this->_request('search_style')){
				case 1:
					$where['news_status'] = array('eq',1);
					break;
				case 2:
					$where['news_status'] = array('eq',2);
					break;
				case 3:
					$where['news_status'] = array('eq',0);
					break;
				default:
					break;
			}
		}
		
		if($this->_request('search_filter')){
			switch ($this->_request('search_filter')){
				case 'name':
					if($this->_request('search_name')){
						$where['news_title'] = array('like','%'.$this->_request('search_name').'%');
					}
					break;
				case 'num':
					if($this->_request('search_name')){
						$nid = $this->_request('search_name');
						$where['news_id'] = array('eq',@(int)$nid);
					}
					break;
				default:
					if($this->_request('search_name')){
						$where['news_title'] = array('like','%'.$this->_request('search_name').'%');
					}
					break;
			}
		}
		
		$news_page = $this->_request('page');
		$count = $newsView->_count($where);
		if($count > 0){
			$Page = new Page($count, C('PAGE_SIZE'));
			$data['where'] = $where;
			$data['firstRow'] = $Page->firstRow;
			$data['listRows'] = $Page->listRows;
			$data['order'] = 'News.id desc';
			$list = $newsView->_list($data);
			if(!empty($list)){
				foreach($list as $k => $v_list){
					switch ($v_list['news_status']){
						case 0:
							$list[$k]['status'] = '未审核';
							break;
						case 1:
							$list[$k]['status'] = '已启用';
							break;
						case 2:
							$list[$k]['status'] = '已禁用';
							break;
					}
					$type_list = null;
					$type_list = $hubType->type_list(array('where'=>array('nid'=>$v_list['news_id'])));
					$type_len = count($type_list);
					
					if($type_len > 0){
						for($i=0;$i<$type_len;$i++){
							$list[$k]['news_type'] .= $type_list[$i]['news_type'];
							if($i < ($type_len-1)){
								$list[$k]['news_type'] .= ' | ';
							}else{
								break;
							}
						}
					}
				}
			}
			$Page->setConfig('header', '条数据');
			$Page->setConfig('first', '<<');
			$Page->setConfig('last', '>>');
			$page = $Page->show();
			$this->assign("page", $page);
			$this->assign("news_list", $list);
			$this->assign('news_page',$news_page);
		}
		$this->display();
	}
	
	public function insert(){
		$type = D('NewsType');
		$page = $this->_get('page');
		$news_type = $type->getType(array('status'=>1,'id'=>array('neq',0)));
		$this->assign('news_type',$news_type);
		$this->assign('page',$page);
		$this->display();
	}
	
	public function add_news(){
		$news = D('News');
		$newsDetails = D('NewsDetails');
		$hubType = D('HubType');
		$newsCover = D('NewsCover');
		$user = $this->getUser();
		$news_type = $this->_post('news_type');	//文章类型
		$data_news['title'] = $this->_post('news_title');	//文章标题
		$data_news['summary'] = $this->_post('news_summary');	//文章简介
		$data_news['keyword'] = $this->_post('news_keyword');	//文章关键字
		$data_news['sort'] = $this->_post('news_sort');	//文章排序
		$data_news['update_user'] = $user;	//操作账号
		
		$data_details['subject'] = $this->_post('news_subject');	//文章副标题
		$data_details['content'] = trim($this->_post('news_content'));	//文章内容
		$data_details['author'] = $this->_post('news_author');	//文章作者
		$data_details['source'] = $this->_post('news_source');	//文章来源
		
		$news_date = $this->_post('news_date');
		$data_details['date'] = strtotime($news_date);	//文章日期
		$data_details['update_user'] = $user;	//操作账号
		
		$news_id = $news->add_news($data_news);
		if($news_id){
			$data_details['nid'] = $news_id;
			$details_id = $newsDetails->add_details($data_details);
			if(!empty($news_type)){
				foreach($news_type as $k => $v_type){
					$hub_type = $hubType->add_newsType(array('news_id'=>$news_id,'type_id'=>$v_type));
				}
			}
			if($_FILES['news_cover']['error'] == 0){
				$scal = $this->imageScal('',133,$_FILES['news_cover']['tmp_name']);	//调整图片缩放比例，参数一为宽，参数二为高
				$pic = $this->imageUpload($scal);	//上传图片，并生成原图及缩略图
				if(!empty($pic)){
					$data_cover['nid'] = $news_id;
					$data_cover['type'] = $pic[0]['type'];
					$data_cover['name'] = $pic[0]['savename'];
					$data_cover['path'] = $pic[0]['savepath'];
					$data_cover['size'] = $pic[0]['size'];
					$data_cover['create_time'] = time();
					$data_cover['create_user'] = $user;
					$newsCover->add_cover($data_cover);
				}
			}
		}
		$this->redirect('/Cmsinfo/Article/index');
	}
	
	public function edit(){
		$news_id = $this->_get('id');
		$page = $this->_get('page');
		
		$newsView = D('NewsView');
		$hubType= D('HubTypeView');
		$type = D('NewsType');
		$cover = D('NewsCover');
		
		$news_type = $type->getType(array('status'=>1,'id'=>array('neq',0)));
		
		if(!empty($news_id)){
			$news_list = $newsView->_list(array('where'=>array('news_id'=>$news_id)));
			if(!empty($news_list[0]['news_id'])){
				$type_list = $hubType->type_list(array('where'=>array('nid'=>$news_list[0]['news_id'])));
				$type_len = count($type_list);
				if($type_len > 0){
					$news_list[0]['news_type'] = array();
					foreach($type_list as $v_type){
						$news_list[0]['news_type'][] = $v_type['type_id'];
					}
				}
				if(empty($news_list[0]['news_cover'])){
					$news_cover = $cover->news_cover(array('nid'=>$news_id));
					if(!empty($news_cover)){
						$news_list[0]['news_cover'] = 'http://'.$_SERVER['SERVER_NAME'].substr($news_cover['path'],1).'cover_'.$news_cover['name'];
					}
				}
				$this->assign('list',$news_list[0]);
			}
		}
		$this->assign('news_type',$news_type);
		$this->assign('page',$page);
		$this->display();
	}
	
	public function update_news(){
		$news = D('News');
		$newsDetails = D('NewsDetails');
		$hubType = D('HubType');
		$newsCover = D('NewsCover');
		$user = $this->getUser();
		$news_page = $this->_post('news_page');
		$news_id = $this->_post('news_id');	//文章id
		$news_type = $this->_post('news_type');	//文章类型
		
		$data_news['title'] = $this->_post('news_title');	//文章标题
		$data_news['keyword'] = $this->_post('news_keyword');	//文章关键字
		$data_news['sort'] = $this->_post('news_sort');	//文章排序
		$data_news['summary'] = $this->_post('news_summary');	//文章简介
		$data_news['update_time'] = time();	//文章更新时间
		$data_news['update_user'] = $user;	//操作账号
		
		$data_details['subject'] = $this->_post('news_subject');	//文章副标题
		$data_details['content'] = trim($this->_post('news_content'));	//文章内容
		$data_details['author'] = $this->_post('news_author');	//文章作者
		$data_details['source'] = $this->_post('news_source');	//文章来源
		$news_date = $this->_post('news_date');
		$data_details['date'] = strtotime($news_date);	//文章日期
		$data_details['update_time'] = time();	//文章详情更新时间
		$data_details['update_user'] = $user;	//操作账号
		
		$param_news['where'] = array('id'=>$news_id);
		
		$param_details['where'] = array('nid'=>$news_id);
		$param_details['details'] = $data_details;
		
		$param_type['where'] = array('news_id'=>$news_id);
		$param_type['type'] = $news_type;
		
		if($_FILES['news_cover']['error'] == 0){
			$cover_old = $newsCover->news_cover(array('nid'=>$news_id));
			if(!empty($cover_old)){
				$pic_file = 'E:/xampp/htdocs/cmsadmin'.substr($cover_old['path'],1).$cover_old['name'];
				$pic_file_mini = 'E:/xampp/htdocs/cmsadmin'.substr($cover_old['path'],1).'cover_'.$cover_old['name'];
				if(file_exists($pic_file) && is_file($pic_file)){
					unlink($pic_file);
				}
				if(file_exists($pic_file_mini) && is_file($pic_file_mini)){
					unlink($pic_file_mini);
				}
				$scal = $this->imageScal(178,133,$_FILES['news_cover']['tmp_name']);	//调整图片缩放比例，参数一为宽，参数二为高
				$pic = $this->imageUpload($scal);	//上传图片，并生成原图及缩略图
				if(!empty($pic[0])){
					$param_cover['where'] = array('nid'=>$news_id);
					$param_cover['cover'] = array('type'=>$pic[0]['type'],'name'=>$pic[0]['savename'],'path'=>$pic[0]['savepath'],'size'=>$pic[0]['size'],'update_time'=>time(),'create_user'=>$user);
					$res_cover = $newsCover->update_cover($param_cover);
					if($res_cover){
						$data_news['original_cover'] = NULL;
					}
				}
			}else{
				$scal = $this->imageScal(178,133,$_FILES['news_cover']['tmp_name']);	//调整图片缩放比例，参数一为宽，参数二为高
				$pic = $this->imageUpload($scal);	//上传图片，并生成原图及缩略图
				if(!empty($pic[0])){
					$cover_data = array('nid'=>$news_id,'type'=>$pic[0]['type'],'name'=>$pic[0]['savename'],'path'=>$pic[0]['savepath'],'size'=>$pic[0]['size'],'update_time'=>time(),'create_user'=>$user);
					$res_cover = $newsCover->add_cover($cover_data);
					if($res_cover){
						$data_news['original_cover'] = NULL;
					}
				}
			}
		}
		$param_news['news'] = $data_news;
		$news->update_news($param_news);
		$newsDetails->update_details($param_details);
		$hubType->update_newsType($param_type);
		$this->redirect('/Cmsinfo/Article/index?page='.$news_page);
	}
	
	public function delete(){
		$news_id = $this->_get('id');
		$news_page = $this->_get('page');
		$news = D('News');
		$newsDetails = D('NewsDetails');
		$hubType = D('HubType');
		$del_res = $news->del_news(array('id'=>$news_id));
		if($del_res){
			$newsDetails->del_details(array('nid'=>$news_id));
			$hubType->del_newsType(array('news_id'=>$news_id));
		}
		$this->redirect('/Cmsinfo/Article/index?page='.$news_page);
	}
	
	//图片上传
	private function imageUpload($size_mini){
		mkdir('./Uploads/Cover/'.date("Ymd"),0777);
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();	//实例化上传类
		$upload->maxSize  = 10485760 ;	//设置附件上传大小
		$upload->allowExts  = array('jpg','gif','png','jpeg');	//设置附件上传类型
		$upload->thumb = true;	//开启图片压缩
		$upload->thumbMaxWidth = "$size_mini[0]";	//最大宽度
		$upload->thumbMaxHeight = "$size_mini[1]";	//最大高度
		$upload->thumbPrefix = 'cover_';
		$upload->savePath =  './Uploads/Cover/'.date("Ymd").'/';	//设置附件上传目录
		$upload->uploadReplace = false;	//存在同名文件是否覆盖
		if(!$upload->upload()) {	//上传错误提示错误信息
			$this->error($upload->getErrorMsg());
		}else{	//上传成功 获取上传文件信息
			$info = $upload->getUploadFileInfo();
		}
		return $info;
	}
	
	//调整图片缩放比例
	private function imageScal($width,$height,$picpath){
		$imginfo = GetImageSize($picpath);
		$imgw = $imginfo[0];
		$imgh = $imginfo[1];
		 
		$ra = number_format(($imgw/$imgh),1);	//宽高比
		$ra2 = number_format(($imgh/$imgw),1);	//高宽比
		
		if($imgw > $width or $imgh > $height){
			if($imgw > $imgh){
				$newWidth = $width;
				$newHeight = round ($newWidth/$ra);
			}elseif($imgw < $imgh){
				$newHeight = $height;
				$newWidth = round($newHeight/$ra2);
			}else{
				$newWidth = $width;
				$newHeight = round($newWidth/$ra);
			}
		}else{
			$newHeight = $imgh;
			$newWidth = $imgw;
		}
		
		$newsize[0] = $newWidth;
		$newsize[1] = $newHeight;
		return $newsize;
	}
	
	public function full(){
		$newsView = D('NewsView');
		$news_page = $this->_request('page');
		$news_id = $this->_get('id');
		if(!empty($news_id)){
			$list = $newsView->_list(array('where'=>array('news_id'=>$news_id)));
			if(!empty($list)){
				foreach($list as $k => $v_list){
					switch ($v_list['news_status']){
						case 0:
							$list[$k]['status'] = '未审核';
							break;
						case 1:
							$list[$k]['status'] = '已通过';
							break;
						case 2:
							$list[$k]['status'] = '已禁用';
							break;
					}
				}
				$this->assign('news_list',$list[0]);
			}
		}
		$this->assign('page',$news_page);
		$this->display();
	}
	
	public function verify(){
		$news_id = $this->_post('news_id');
		$news_page = $this->_post('news_page');
		$news_status = $this->_post('news_status');
		$user = $this->getUser();
		$news = D('News');
		if(!empty($news_id)){
			$param_news['where'] = array('id'=>$news_id);
			$param_news['news'] = array('status'=>1,'verify_user'=>$user,'verify_time'=>time());
			if($news_status == 0){
				$news->update_news($param_news);
			}
		}
		$this->redirect('/Cmsinfo/Article/index?page='.$news_page);
	}
	
	public function disable(){
		$news_id = $this->_get('id');
		$news_page = $this->_get('page');
		$news = D('News');
		$user = $this->getUser();
		if(!empty($news_id)){
			$param_news['where'] = array('id'=>$news_id);
			$param_news['news'] = array('status'=>2,'verify_user'=>$user,'verify_time'=>time());
			$news->update_news($param_news);
		}
		$this->redirect('/Cmsinfo/Article/index?page='.$news_page);
	}
	
	public function undisable(){
		$news_id = $this->_get('id');
		$news_page = $this->_get('page');
		$news = D('News');
		$user = $this->getUser();
		if(!empty($news_id)){
			$param_news['where'] = array('id'=>$news_id);
			$param_news['news'] = array('status'=>0,'verify_user'=>$user,'verify_time'=>time());
			$news->update_news($param_news);
		}
		$this->redirect('/Cmsinfo/Article/index?page='.$news_page);
	}
	
	private function getUser(){	//获取操作者账号
		$adm = $this->_GetLoginInfo();
		if(!empty($adm['ref']['info'])){
			$user = $adm['ref']['info']['account'];
		}
		return $user;
	}
	
	
}
