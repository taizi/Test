<?php
class CollectionAction extends BaseAction{
	public function _initialize(){
		parent::_initialize();
		include('/Applications/MAMP/htdocs/cmsadmin/Public/simplehtmldom_1_5/simple_html_dom.php');
	}
	public function index(){
		$this->display('Collection:index');
	}
	
	public function insert(){
		set_time_limit(600);
		$source = $this->_post('source');	//采集来源类型
		$page_start = @(int)$this->_post('page_start');	//采集起始页
		$page_offset = @(int)$this->_post('page_offset');	//采集偏移量
		if(empty($page_start)){
			$page_start = 1;
		}
		if(empty($page_offset)){
			$page_offset = 0;
		}else{
			if($page_offset > 10){
				$page_offset = 10;
			}elseif($page_offset < 0){
				$page_offset = 0;
			}
		}
		if(!empty($source)){
			switch ($source){
				case 1:
					break;
				case 2:
					$this->pclady($page_start,$page_offset,'makeup');
					break;
				case 3:
					$this->pclady($page_start,$page_offset,'hair');
					break;
				case 4:
					$this->fashion_woman($page_start,$page_offset,'korean');
					break;
				case 5:
					$this->fashion_woman($page_start,$page_offset,'stature');
					break;
				case 6:
					$this->fashion_woman($page_start,$page_offset,'occasion');
					break;
				case 7:
					$this->lady1314_clothing($page_start,$page_offset,'japanKorean');
					break;
				case 8:
					$this->lady1314_clothing($page_start,$page_offset,'star');
					break;
				case 9:
					$this->lady1314_clothing($page_start,$page_offset,'mashup');
					break;
				case 10:
					$this->lady1314_clothing($page_start,$page_offset,'europeAmerica');
					break;
				case 11:
					$this->lady1314_cosmetology($page_start,$page_offset,'makeup');
					break;
				case 12:
					$this->lady1314_cosmetology($page_start,$page_offset,'rouge');
					break;
				case 13:
					$this->lady1314_cosmetology($page_start,$page_offset,'nail');
					break;
				case 14:
					$this->lady1314_cosmetology($page_start,$page_offset,'eye');
					break;
				case 15:
					$this->fashion_witch($page_start,$page_offset,'clothing');
					break;
				case 16:
					$this->fashion_witch($page_start,$page_offset,'japanKorean');
					break;
				case 17:
					$this->fashion_witch($page_start,$page_offset,'whiteCollar');
					break;
				case 18:
					$this->fashion_witch($page_start,$page_offset,'accessories');
					break;
				case 19:
					$this->fashion_witch($page_start,$page_offset,'streetBeat');
					break;
				case 20:
					$this->fashion_witch($page_start,$page_offset,'popHair');
					break;
				case 21:
					$this->fashion_witch($page_start,$page_offset,'skinCare');
					break;
				case 22:
					$this->fashion_witch($page_start,$page_offset,'leisure');
					break;
				case 23:
					$this->women_clothing($page_start,$page_offset,'trendWith');
					break;
				case 24:
					$this->women_clothing($page_start,$page_offset,'trendsFashions');
					break;
				case 25:
					$this->mina_fashion($page_start,$page_offset,'street');
					break;
				case 26:
					$this->mina_fashion($page_start,$page_offset,'trend');
					break;
				case 27:
					$this->mina_fashion($page_start,$page_offset,'mashup');
					break;
				case 28:
					$this->onlylady($page_start,$page_offset,'collocation');
					break;
				case 29:
					$this->onlylady($page_start,$page_offset,'single');
					break;
				case 30:
					$this->herschina($page_start,$page_offset,'collocation');
					break;
				case 31:
					$this->herschina($page_start,$page_offset,'star');
					break;
				case 32:
					$this->herschina($page_start,$page_offset,'modeling');
					break;
				default:
					break;
			}
		}
		$this->redirect('/Cmsinfo/Collection/index');
	}
	
	private function getUser(){
		$adm = $this->_GetLoginInfo();
		if(!empty($adm['ref']['info'])){
			$user = $adm['ref']['info']['account'];
		}
		return $user;
	}
	
	private function reUrl($url,$num){
		if(!empty($url)){
			if($num > 0){
				$arr_url = explode('.',$url);
				$len_arr = count($arr_url);
				if($len_arr > 1){
					$arr_url[($len_arr-2)] = $arr_url[($len_arr-2)].'_'.$num;
				}
				$url = implode('.',$arr_url);
			}
			return $url;
		}
	}

	//cURL方法
	private function http_request($url, $params=array(), $method='post', $timeout=20, $headers=array()){
		$options = array(
				CURLOPT_RETURNTRANSFER => true,				// return web page
				CURLOPT_HEADER         => false,			// don't return headers
				CURLOPT_FOLLOWLOCATION => true,				// follow redirects
				CURLOPT_ENCODING       => "",				// handle all encodings
				CURLOPT_USERAGENT      => "",				// who am i
				CURLOPT_AUTOREFERER    => true,				// set referer on redirect
				CURLOPT_CONNECTTIMEOUT => 5,				// timeout on connect
				CURLOPT_TIMEOUT        => $timeout,			// timeout on response
				CURLOPT_MAXREDIRS      => 10,				// stop after 10 redirects
				CURLOPT_POST           => $method=='post',	// i am sending post data
				CURLOPT_POSTFIELDS     => $params,			// this are my post vars
				CURLOPT_VERBOSE        => 1,
				CURLOPT_HTTPHEADER	   => $headers
		);
		$ch      = curl_init($url);
		curl_setopt_array($ch,$options);
		$content = curl_exec($ch);
		$err     = curl_errno($ch);		//返回最后一次的错误号
		$errmsg  = curl_error($ch) ;	//返回一个保护当前会话最近一次错误的字符串
		$header  = curl_getinfo($ch);	//获取一个cURL连接资源句柄的信息
		curl_close($ch);
		return $content;
	}
	
	//cURL非POST方法
	private function http_get($url, $params=array(), $method='post', $timeout=20, $headers=array()){
		$options = array(
				CURLOPT_RETURNTRANSFER => true,				// return web page
				CURLOPT_HEADER         => false,			// don't return headers
				CURLOPT_FOLLOWLOCATION => true,				// follow redirects
				CURLOPT_ENCODING       => "",				// handle all encodings
				CURLOPT_USERAGENT      => "",				// who am i
				CURLOPT_AUTOREFERER    => true,				// set referer on redirect
				CURLOPT_CONNECTTIMEOUT => 5,				// timeout on connect
				CURLOPT_TIMEOUT        => $timeout,			// timeout on response
				CURLOPT_MAXREDIRS      => 10,				// stop after 10 redirects
				//CURLOPT_POST           => $method=='post',	// i am sending post data
				//CURLOPT_POSTFIELDS     => $params,			// this are my post vars
				CURLOPT_VERBOSE        => 1,
				CURLOPT_HTTPHEADER	   => $headers
		);
		$ch      = curl_init($url);
		curl_setopt_array($ch,$options);
		$content = curl_exec($ch);
		$err     = curl_errno($ch);		//返回最后一次的错误号
		$errmsg  = curl_error($ch) ;	//返回一个保护当前会话最近一次错误的字符串
		$header  = curl_getinfo($ch);	//获取一个cURL连接资源句柄的信息
		curl_close($ch);
		return $content;
	}
	
	//新闻详情页
	private function news_request($url,$timeout=20){
		$options = array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CONNECTTIMEOUT => $timeout,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_ENCODING => 'gzip'
				);
		
		$ch = curl_init();
		curl_setopt_array($ch,$options);
		$contents = trim(curl_exec($ch));
		curl_close($ch);
		return  $contents;
	}
	
	private function pclady($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'makeup':
				$target_url = 'http://beauty.pclady.com.cn/makeup/';
				break;
			case 'hair':
				$target_url = 'http://beauty.pclady.com.cn/hairstyle/frontier/';
				break;
			default:
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			if($start == 1 && $i == 0){
				$where_url = $target_url;
			}else{
				$where_url = $target_url.'index_'.($start+$i-1).'.html';
			}
			$get_news = null;
			$get_news = $this->http_request($where_url,null,'get',5);
			$get_news = @iconv("GBK", "UTF-8//IGNORE", $get_news);
			if(!empty($get_news)){
				$preg_newsUl = '/<div class=\"content\">(?:.*)<ul>(.*)<\/ul>(?:.*)<div class=\"clear\"><\/div>/iUs';
				preg_match_all($preg_newsUl,$get_news,$news_ul);
				
				if(!empty($news_ul[1])){
					$preg_newsLi = '/<li>(?:.*)<i class=\"iPic\"><a href=\"(?:.*)\" target=\"_blank\"><img src=\"(.*)\"(?:.*)><\/a><\/i>(?:.*)<span class=\"sDes\">(.*)<a href=\"(.*)\" target=\"_blank\">查看全文>><\/a><\/span>(?:.*)<span class=\"sLab\">(.*)<\/span>(?:.*)<\/i>(?:.*)<\/li>/iUs';
					preg_match_all($preg_newsLi,$news_ul[1][0],$news_li);
				}
				$len_newsLi = count($news_li[3]);
				if($len_newsLi > 0){
					$news_list = null;
					for($k=0;$k<$len_newsLi;$k++){
						$news_list['cover'][] = $news_li[1][$k];
						$news_list['summary'][] = $news_li[2][$k];
						$news_list['url'][] = $news_li[3][$k];
						$news_list['keyword'][] = $news_li[4][$k];
					}
					for($k=0;$k<$len_newsLi;$k++){
						$un_news = null;
						$un_news = $this->news_request($news_list[url][$k],15);
						$un_news = @iconv("GBK", "UTF-8//IGNORE", $un_news);
						$preg_newsPage = '/<div class=\"pclady_page\">(?:.*)<a class=\"viewAll\" href=\"(.*)\"(?:.*)>显示全文<\/a>(?:.*)<\/div>/iUs';
						preg_match($preg_newsPage,$un_news,$url_all);
						if(!empty($url_all[1])){
							$real_news = null;
							$real_news = $this->news_request($url_all[1],15);
							$real_news = @iconv("GBK", "UTF-8//IGNORE", $real_news);
							$preg_title = '/<h1>(.*)<\/h1>/iUs';	//匹配标题
							$preg_content = '/<div class=\"artText\" id=\"artText\">(?:.*)<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">(.*)<\/table>(?:.*)<\/div>/is';	//匹配内容
							$preg_source = '/<span>出处：(.*)<\/span>/iUs';	//匹配来源
							$preg_date = '/<p class=\"artInfo\"><span>(.*)<\/span>/iUs';	//匹配日期
							$preg_author = '/<span>作者：(.*)<\/span>/iUs';	//匹配作者
							preg_match($preg_title,$real_news,$un_title);
							preg_match($preg_content,$real_news,$un_content);
							preg_match($preg_source,$real_news,$un_source);
							preg_match($preg_date,$real_news,$un_date);
							preg_match($preg_author,$real_news,$un_author);
							$res_add = $collection->add_news($un_title[1],$news_list['summary'][$k],$un_content[1],$un_author[1],$un_source[1],$un_date[1],$news_list['keyword'][$k],$news_list['cover'][$k],$user);	//采集新闻到临时库
						}else{
							$preg_title = '/<meta http-equiv=\"Content-Type\"(?:.*)<title>(.*)<\/title>/iUs';	//匹配标题
							$preg_content = '/<div class=\"artCon\">(.*)<div class=\"Com\">/is';	//匹配内容
							$preg_author = '/<meta name=\"Author\" content=\"(.*)\">/iUs';	//匹配作者	
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_author,$un_news,$un_author);
							$res_add = $collection->add_news($un_title[1],$news_list['summary'][$k],$un_content[1],$un_author[1],'','',$news_list['keyword'][$k],$news_list['cover'][$k],$user);	//采集新闻到临时库
						}
						sleep(1);
					}
				}
			}
		}
	}
	
	private function fashion_woman($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'korean':
				$target_url = 'http://www.43.cn/fushi/dapeishengjing/woxingwoxiu/list_118_';
				break;
			case 'stature':
				$target_url = 'http://www.43.cn/fushi/dapeishengjing/shencaidapei/list_119_';
				break;
			case 'occasion':
				$target_url = 'http://www.43.cn/fushi/dapeishengjing/changhedapei/list_120_';
				break;
			default:
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			$where_url = $target_url.($start+$i).'.html';
			$get_news = null;
			$get_news = $this->http_get($where_url,null,'get',5);
			$get_news = @iconv("GBK", "UTF-8//IGNORE", $get_news);
			if(!empty($get_news)){
				$preg_newsUl = '/<ul class=\"article clearfix\">(.*)<\/ul>/iUs';
				preg_match_all($preg_newsUl,$get_news,$news_ul);
				
				if(!empty($news_ul[1])){
					$preg_newsLi = '/<li class=\"list\">(?:.*)<em>(?:.*)<\/em><a href=\"(.*)\"(?:.*)<\/li>/iUs';
					preg_match_all($preg_newsLi,$news_ul[1][0],$news_li);
				}
				$len_newsLi = count($news_li[1]);
				if($len_newsLi > 0){
					$news_list = null;
					for($k=0;$k<$len_newsLi;$k++){
						$un_news = null;
						$un_news = $this->news_request($news_li[1][$k],15);
						$un_news = @iconv("GBK", "UTF-8//IGNORE", $un_news);
						$preg_newsPage = '/<div class=\"page article_page\"  id=\"content_pages\">(?:.*)<a>共(.*)页: <\/a>(?:.*)<\/div>/iUs';
						preg_match($preg_newsPage,$un_news,$url_all);
						if(!empty($url_all[1])){
							$preg_title = '/<div class=\"article_tit\">(?:.*)<h1>(.*)<\/h1>/iUs';	//匹配标题
							$preg_content = '/<div class=\"textCon\">(.*)<\/div>(?:.*)<div class=\"page article_page\"  id=\"content_pages\">/is';	//匹配内容
							$preg_source = '/<span>来源：(.*)<\/span>/iUs';	//匹配来源
							$preg_date = '/<span>发表时间：(.*)<\/span>/iUs';	//匹配日期
							$preg_author = '/<span>编辑：(.*)<\/span>/iUs';	//匹配作者
							$preg_summary = '/<div class=\"daodu\">(?:.*)<p>(.*)<\/p>(?:.*)<\/div>/iUs';	//匹配简介
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_source,$un_news,$un_source);
							preg_match($preg_date,$un_news,$un_date);
							preg_match($preg_author,$un_news,$un_author);
							preg_match($preg_summary,$un_news,$un_summary);
							if($url_all[1] > 0){	//文章内容分页数量
								for($n=2;$n<=$url_all[1];$n++){
									$page_news = null;
									$page_news_url = null;
									$un_pageContent = null;
									$page_news_url = $this->reUrl($news_li[1][$k],$n);
									$page_news = $this->news_request($page_news_url,15);
									$page_news = @iconv("GBK", "UTF-8//IGNORE", $page_news);
									$preg_pageContent = '/<div class=\"textCon\">(.*)<\/div>(?:.*)<div class=\"page article_page\"  id=\"content_pages\">/is';	//匹配内容
									preg_match($preg_pageContent,$page_news,$un_pageContent);
									if(!empty($un_pageContent[1])){
										$un_content[1] .= $un_pageContent[1];
									}
									sleep(1);
								}
								$un_content[1] = str_replace('src="/uploads/','src="http://www.43.cn/uploads/',$un_content[1]);
							}
							$res_add = $collection->add_news($un_title[1],$un_summary[1],$un_content[1],$un_author[1],$un_source[1],$un_date[1],'','',$user);	//采集新闻到临时库
						}else{
							$preg_title = '/<div class=\"article_tit\">(?:.*)<h1>(.*)<\/h1>/iUs';	//匹配标题
							$preg_content = '/<div class=\"textCon\">(.*)<\/div>(?:.*)<div class=\"page article_page\"  id=\"content_pages\">/is';	//匹配内容
							$preg_source = '/<span>来源：(.*)<\/span>/iUs';	//匹配来源
							$preg_date = '/<span>发表时间：(.*)<\/span>/iUs';	//匹配日期
							$preg_author = '/<span>编辑：(.*)<\/span>/iUs';	//匹配作者
							$preg_summary = '/<div class=\"daodu\">(?:.*)<p>(.*)<\/p>(?:.*)<\/div>/iUs';	//匹配简介
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_source,$un_news,$un_source);
							preg_match($preg_date,$un_news,$un_date);
							preg_match($preg_author,$un_news,$un_author);
							preg_match($preg_summary,$un_news,$un_summary);
							$un_content[1] = str_replace('src="/uploads/','src="http://www.43.cn/uploads/',$un_content[1]);
							$res_add = $collection->add_news($un_title[1],$un_summary[1],$un_content[1],$un_author[1],$un_source[1],$un_date[1],'','',$user);	//采集新闻到临时库
						}
					}
				}
			}
		}
	}
	
	private function lady1314_clothing($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'japanKorean':
				$target_url = 'http://www.lady1314.com.cn/a/dress/jtsp/rhjt/list_85_';
				break;
			case 'star':
				$target_url = 'http://www.lady1314.com.cn/a/dress/jtsp/mxjp/list_86_';
				break;
			case 'mashup':	
				$target_url = 'http://www.lady1314.com.cn/a/dress/jtsp/gxlx/list_87_';
				break;
			case 'europeAmerica':
				$target_url = 'http://www.lady1314.com.cn/a/dress/jtsp/omlx/list_88_';
			default: 
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			$where_url = $target_url.($start+$i).'.html';
			$get_news = null;
			$get_news = $this->http_request($where_url,null,'get',5);
			//$get_news = @iconv("GBK", "UTF-8", $get_news);
			if(!empty($get_news)){
				$preg_newsUl = '/<ul class=\"art_list_news\">(.*)<\/ul>/iUs';
				preg_match_all($preg_newsUl,$get_news,$news_ul);
				if(!empty($news_ul[1])){
					$preg_newsLi = '/<li(?:.*)>(?:.*)<a href=\"(.*)\"(?:.*)<\/li>/iUs';
					preg_match_all($preg_newsLi,$news_ul[1][0],$news_li);
				}
				$len_newsLi = count($news_li[1]);
				if($len_newsLi > 0){
					$news_list = null;
					for($k=0;$k<$len_newsLi;$k++){
						$news_li[1][$k] = 'http://www.lady1314.com.cn'.$news_li[1][$k];
						$un_news = null;
						$un_news = $this->news_request($news_li[1][$k],15);
						//$un_news = @iconv("GBK", "UTF-8", $un_news);
						$preg_newsPage = '/<ul class=\"page\" id=\"pagelist\">(?:.*)<a>共(.*)页(?:.*)<\/a>(?:.*)<\/ul>/iUs';
						preg_match($preg_newsPage,$un_news,$url_all);
						if(!empty($url_all[1])){
							$preg_title = '/<div class=\"article\">(?:.*)<h1>(.*)<\/h1>/iUs';	//匹配标题
							$preg_content = '/<div class=\"art_con\">(.*)<ul class=\"page\" id=\"pagelist\">/is';	//匹配内容
							$preg_source = '/<div class=\"article_tip\">(?:.*)来源:(.*)\|(?:.*)<\/div>/iUs';	//匹配来源
							$preg_date = '/<div class=\"article_tip\">(?:.*)发布:(.*)\|(?:.*)<\/div>/iUs';	//匹配日期
							$preg_author = '/<div class=\"article_tip\">(?:.*)编辑:(.*)\|(?:.*)<\/div>/iUs';	//匹配作者
							$preg_summary = '/<div class=\"art_con\">(?:.*)导读(.*)<\/p>/iUs';	//匹配简介
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_source,$un_news,$un_source);
							preg_match($preg_date,$un_news,$un_date);
							preg_match($preg_author,$un_news,$un_author);
							$un_summary = null;
							preg_match($preg_summary,$un_news,$un_summary);
							if(empty($un_summary)){
								$preg_summary = '/<div class=\"art_con\">(?:.*)导语(.*)<\/p>/iUs';	//匹配简介
								preg_match($preg_summary,$un_news,$un_summary);
							}
							if($url_all[1] > 0){	//文章内容分页数量
								for($n=2;$n<=$url_all[1];$n++){
									$page_news = null;
									$page_news_url = null;
									$un_pageContent = null;
									$page_news_url = $this->reUrl($news_li[1][$k],$n);
									$page_news = $this->news_request($page_news_url,15);
									//$page_news = @iconv("GBK", "UTF-8", $page_news);
									$preg_pageContent = '/<div class=\"art_con\">(.*)<ul class=\"page\" id=\"pagelist\">/is';	//匹配内容
									preg_match($preg_pageContent,$page_news,$un_pageContent);
									if(!empty($un_pageContent[1])){
										$un_content[1] .= $un_pageContent[1];
									}
									sleep(1);
								}
								$un_content[1] = str_replace('src="/uploads/','src="http://www.lady1314.com.cn/uploads/',$un_content[1]);
							}
							$res_add = $collection->add_news($un_title[1],$un_summary[1],$un_content[1],$un_author[1],$un_source[1],$un_date[1],'','',$user);	//采集新闻到临时库
						}else{
							$preg_title = '/<div class=\"article\">(?:.*)<h1>(.*)<\/h1>/iUs';	//匹配标题
							$preg_content = '/<div class=\"art_con\">(.*)<ul class=\"page\" id=\"pagelist\">/is';	//匹配内容
							$preg_source = '/<div class=\"article_tip\">(?:.*)来源:(.*)\|(?:.*)<\/div>/iUs';	//匹配来源
							$preg_date = '/<div class=\"article_tip\">(?:.*)发布:(.*)\|(?:.*)<\/div>/iUs';	//匹配日期
							$preg_author = '/<div class=\"article_tip\">(?:.*)编辑:(.*)\|(?:.*)<\/div>/iUs';	//匹配作者
							$preg_summary = '/<div class=\"art_con\">(?:.*)导读(.*)<\/p>/iUs';	//匹配简介
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_source,$un_news,$un_source);
							preg_match($preg_date,$un_news,$un_date);
							preg_match($preg_author,$un_news,$un_author);
							$un_summary = null;
							preg_match($preg_summary,$un_news,$un_summary);
							if(empty($un_summary)){
								$preg_summary = '/<div class=\"art_con\">(?:.*)导语(.*)<\/p>/iUs';	//匹配简介
								preg_match($preg_summary,$un_news,$un_summary);
							}
							$un_content[1] = str_replace('src="/uploads/','src="http://www.lady1314.com.cn/uploads/',$un_content[1]);
							$res_add = $collection->add_news($un_title[1],$un_summary[1],$un_content[1],$un_author[1],$un_source[1],$un_date[1],'','',$user);	//采集新闻到临时库
						}
					}
				}
			}
		}
	}
	
	private function lady1314_cosmetology($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'makeup':
				$target_url = 'http://www.lady1314.com.cn/a/beauty/mxlz/list_3_';
				break;
			case 'rouge':
				$target_url = 'http://www.lady1314.com.cn/a/beauty/clcz/zincz/cz/list_29_';
				break;
			case 'nail':
				$target_url = 'http://www.lady1314.com.cn/a/beauty/clcz/zincz/mj/list_30_';
				break;
			case 'eye':
				$target_url = 'http://www.lady1314.com.cn/a/beauty/clcz/zrjq/yz/list_26_';
				break;
			default:
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			$where_url = $target_url.($start+$i).'.html';
			$get_news = null;
			$get_news = $this->http_request($where_url,null,'get',5);
			//$get_news = @iconv("GBK", "UTF-8", $get_news);
			if(!empty($get_news)){
				$preg_newsUl = '/<ul class=\"art_list_news\">(.*)<\/ul>/iUs';
				preg_match_all($preg_newsUl,$get_news,$news_ul);
				if(!empty($news_ul[1])){
					$preg_newsLi = '/<li(?:.*)>(?:.*)<a href=\"(.*)\"(?:.*)<\/li>/iUs';
					preg_match_all($preg_newsLi,$news_ul[1][0],$news_li);
				}
				$len_newsLi = count($news_li[1]);
				if($len_newsLi > 0){
					$news_list = null;
					for($k=0;$k<$len_newsLi;$k++){
						$news_li[1][$k] = 'http://www.lady1314.com.cn'.$news_li[1][$k];
						$un_news = null;
						$un_news = $this->news_request($news_li[1][$k],15);
						//$un_news = @iconv("GBK", "UTF-8", $un_news);
						$preg_newsPage = '/<ul class=\"page\" id=\"pagelist\">(?:.*)<a>共(.*)页(?:.*)<\/a>(?:.*)<\/ul>/iUs';
						preg_match($preg_newsPage,$un_news,$url_all);
						if(!empty($url_all[1])){
							$preg_title = '/<div class=\"article\">(?:.*)<h1>(.*)<\/h1>/iUs';	//匹配标题
							$preg_content = '/<div class=\"art_con\">(.*)<ul class=\"page\" id=\"pagelist\">/is';	//匹配内容
							$preg_source = '/<div class=\"article_tip\">(?:.*)来源:(.*)\|(?:.*)<\/div>/iUs';	//匹配来源
							$preg_date = '/<div class=\"article_tip\">(?:.*)发布:(.*)\|(?:.*)<\/div>/iUs';	//匹配日期
							$preg_author = '/<div class=\"article_tip\">(?:.*)编辑:(.*)\|(?:.*)<\/div>/iUs';	//匹配作者
							$preg_summary = '/<div class=\"art_con\">(?:.*)导读(.*)<\/p>/iUs';	//匹配简介
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_source,$un_news,$un_source);
							preg_match($preg_date,$un_news,$un_date);
							preg_match($preg_author,$un_news,$un_author);
							$un_summary = null;
							preg_match($preg_summary,$un_news,$un_summary);
							if(empty($un_summary)){
								$preg_summary = '/<div class=\"art_con\">(?:.*)导语(.*)<\/p>/iUs';	//匹配简介
								preg_match($preg_summary,$un_news,$un_summary);
							}
							if($url_all[1] > 0){	//文章内容分页数量
								for($n=2;$n<=$url_all[1];$n++){
									$page_news = null;
									$page_news_url = null;
									$un_pageContent = null;
									$page_news_url = $this->reUrl($news_li[1][$k],$n);
									$page_news = $this->news_request($page_news_url,15);
									//$page_news = @iconv("GBK", "UTF-8", $page_news);
									$preg_pageContent = '/<div class=\"art_con\">(.*)<ul class=\"page\" id=\"pagelist\">/is';	//匹配内容
									preg_match($preg_pageContent,$page_news,$un_pageContent);
									if(!empty($un_pageContent[1])){
										$un_content[1] .= $un_pageContent[1];
									}
									sleep(1);	//休眠一秒
								}
								$un_content[1] = str_replace('src="/uploads/','src="http://www.lady1314.com.cn/uploads/',$un_content[1]);
							}
							$res_add = $collection->add_news($un_title[1],$un_summary[1],$un_content[1],$un_author[1],$un_source[1],$un_date[1],'','',$user);	//采集新闻到临时库
						}else{
							$preg_title = '/<div class=\"article\">(?:.*)<h1>(.*)<\/h1>/iUs';	//匹配标题
							$preg_content = '/<div class=\"art_con\">(.*)<ul class=\"page\" id=\"pagelist\">/is';	//匹配内容
							$preg_source = '/<div class=\"article_tip\">(?:.*)来源:(.*)\|(?:.*)<\/div>/iUs';	//匹配来源
							$preg_date = '/<div class=\"article_tip\">(?:.*)发布:(.*)\|(?:.*)<\/div>/iUs';	//匹配日期
							$preg_author = '/<div class=\"article_tip\">(?:.*)编辑:(.*)\|(?:.*)<\/div>/iUs';	//匹配作者
							$preg_summary = '/<div class=\"art_con\">(?:.*)导读(.*)<\/p>/iUs';	//匹配简介
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_source,$un_news,$un_source);
							preg_match($preg_date,$un_news,$un_date);
							preg_match($preg_author,$un_news,$un_author);
							$un_summary = null;
							preg_match($preg_summary,$un_news,$un_summary);
							if(empty($un_summary)){
								$preg_summary = '/<div class=\"art_con\">(?:.*)导语(.*)<\/p>/iUs';	//匹配简介
								preg_match($preg_summary,$un_news,$un_summary);
							}
							$un_content[1] = str_replace('src="/uploads/','src="http://www.lady1314.com.cn/uploads/',$un_content[1]);
							$res_add = $collection->add_news($un_title[1],$un_summary[1],$un_content[1],$un_author[1],$un_source[1],$un_date[1],'','',$user);	//采集新闻到临时库
						}
					}
				}
			}
		}
	}
	
	private function fashion_witch($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'clothing':
				$target_url = 'http://www.love616.com/lady/fushi/';
				$target_url_follow = 'http://www.love616.com/lady/fushi/19-';
				break;
			case 'japanKorean':
				$target_url = 'http://www.love616.com/lady/rihan/';
				$target_url_follow = 'http://www.love616.com/lady/rihan/20-';
				break;
			case 'whiteCollar':
				$target_url = 'http://www.love616.com/lady/OL/';
				$target_url_follow = 'http://www.love616.com/lady/OL/2-';
				break;
			case 'accessories':
				$target_url = 'http://www.love616.com/lady/peishi/';
				$target_url_follow = 'http://www.love616.com/lady/peishi/list_60_';
				break;
			case 'streetBeat':	
				$target_url = 'http://www.love616.com/lady/jiepai/';
				$target_url_follow = 'http://www.love616.com/lady/jiepai/21-';
				break;
			case 'popHair':
				$target_url = 'http://www.love616.com/lady/PopHair/';
				$target_url_follow = 'http://www.love616.com/lady/PopHair/list_33_';
				break;
			case 'skinCare':
				$target_url = 'http://www.love616.com/lady/meironghufu/';
				$target_url_follow = 'http://www.love616.com/lady/meironghufu/4-';
				break;
			case 'leisure':
				$target_url = 'http://www.love616.com/lady/fzl/';
				$target_url_follow = 'http://www.love616.com/lady/fzl/30-';
				break;
			default:
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			if($start == 1 && $i == 0){
				$where_url = $target_url;
			}else{
				$where_url = $target_url_follow.($start+$i).'.html';
			}
			$get_news = null;
			$get_news = $this->http_request($where_url,null,'get',5);
			$get_news = @iconv("GBK", "UTF-8//IGNORE", $get_news);
			if(!empty($get_news)){
				$preg_newsUl = '/<DIV class=content_left>(?:.*)<DL>(.*)<\/DL>(?:.*)<\/DIV>/iUs';
				preg_match_all($preg_newsUl,$get_news,$news_ul);
				if(!empty($news_ul[1])){
					$preg_newsLi = '/<DD><a href=\'(?:.*)\' class=\'preview\'><img src=\'(.*)\'\/><\/a>(?:.*)<a href=\"(.*)\" class=\"title\" target=\"_blank\">(?:.*)<\/a>(?:.*)<P>(.*)<A(?:.*)<\/DD>/iUs';
					preg_match_all($preg_newsLi,$news_ul[1][0],$news_li);
				}
				$len_newsLi = count($news_li[2]);
				if($len_newsLi > 0){
					$news_list = null;
					for($k=0;$k<$len_newsLi;$k++){
						$news_list['cover'][] = $news_li[1][$k];
						$news_list['summary'][] = $news_li[3][$k];
						$news_list['url'][] = $news_li[2][$k];
					}
					for($k=0;$k<$len_newsLi;$k++){
						$un_news = null;
						$un_news = $this->news_request($news_list['url'][$k],15);
						$un_news = @iconv("GBK", "UTF-8//IGNORE", $un_news);
						$preg_newsPage = '/<div class=\"page article_page\"  id=\"content_pages\">(?:.*)<a>共(.*)页: <\/a>(?:.*)<\/div>/iUs';
						preg_match($preg_newsPage,$un_news,$url_all);
						if(!empty($url_all[1])){
							$preg_title = '/<DIV class=tw id=c4_cons2>(?:.*)<H1 class=\"(?:.*)\">(.*)<\/H1>/iUs';	//匹配标题
							$preg_content = '/<DIV class=tit_desc>(?:.*)<table(?:.*)class=\"fushi\">(.*)<\/table>(?:.*)<!-- 正文和摘要 end -->/is';	//匹配内容
							$preg_source = '/<DIV class=tw id=c4_cons2>(?:.*)来源：<a href=\"(?:.*)\">(.*)<\/a>/iUs';	//匹配来源
							$preg_date = '/<DIV class=tw id=c4_cons2>(?:.*)<DL class=from><SPAN>发布：(.*)&#160;&#160;来源/iUs';	//匹配日期
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_source,$un_news,$un_source);
							preg_match($preg_date,$un_news,$un_date);
							if($url_all[1] > 0){	//文章内容分页数量
								for($n=2;$n<=$url_all[1];$n++){
									$page_news = null;
									$page_news_url = null;
									$un_pageContent = null;
									$page_news_url = $this->reUrl($news_list['url'][$k],$n);
									$page_news = $this->news_request($page_news_url,15);
									$page_news = @iconv("GBK", "UTF-8//IGNORE", $page_news);
									$preg_pageContent = '/<DIV class=tit_desc>(?:.*)<table(?:.*)class=\"fushi\">(.*)<\/table>(?:.*)<!-- 正文和摘要 end -->/is';	//匹配内容
									preg_match($preg_pageContent,$page_news,$un_pageContent);
									if(!empty($un_pageContent[1])){
										$un_content[1] .= $un_pageContent[1];
									}
									sleep(1);	//休眠一秒
								}
							}
							$res_add = $collection->add_news($un_title[1],$news_list['summary'][$k],$un_content[1],'',$un_source[1],$un_date[1],'',$news_list['cover'][$k],$user);	//采集新闻到临时库
						}else{
							$preg_title = '/<DIV class=tw id=c4_cons2>(?:.*)<H1 class=\"(?:.*)\">(.*)<\/H1>/iUs';	//匹配标题
							$preg_content = '/<DIV class=tit_desc>(?:.*)<table(?:.*)class=\"fushi\">(.*)<\/table>(?:.*)<!-- 正文和摘要 end -->/is';	//匹配内容
							$preg_source = '/<DIV class=tw id=c4_cons2>(?:.*)来源：<a href=\"(?:.*)\">(.*)<\/a>/iUs';	//匹配来源
							$preg_date = '/<DIV class=tw id=c4_cons2>(?:.*)<DL class=from><SPAN>发布：(.*)&#160;&#160;来源/iUs';	//匹配日期
							preg_match($preg_title,$un_news,$un_title);
							preg_match($preg_content,$un_news,$un_content);
							preg_match($preg_source,$un_news,$un_source);
							preg_match($preg_date,$un_news,$un_date);
							$res_add = $collection->add_news($un_title[1],$news_list['summary'][$k],$un_content[1],'',$un_source[1],$un_date[1],'',$news_list['cover'][$k],$user);	//采集新闻到临时库
						}
					}
				}
			}
		}
	}
	
	private function women_clothing($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'trendWith':
				$target_url = 'http://www.nzw.cn/fashion/cloth/';
				break;
			case 'trendsFashions':
				$target_url = 'http://www.nzw.cn/fashion/show/';
				break;
			default:
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			$where_url = $target_url.($start+$i).'.html';
			$get_news = null;
			$get_news = $this->http_request($where_url,null,'get',5);
			$get_news = @iconv("GBK", "UTF-8//IGNORE", $get_news);
			if(!empty($get_news)){
				$preg_newsUl = '/<div class=\"boxx_left\">(?:.*)<div class=\"left2\">(.*)<div class=\"fanye\">/iUs';
				preg_match_all($preg_newsUl,$get_news,$news_ul);
		
				if(!empty($news_ul[1])){
					$preg_newsLi = '/<div class=\"left2_list_right_1\">(?:.*)<a href=\"(.*)\"(?:.*)>/iUs';
					preg_match_all($preg_newsLi,$news_ul[1][0],$news_li);
				}
				$len_newsLi = count($news_li[1]);
				if($len_newsLi > 0){
					for($k=0;$k<$len_newsLi;$k++){
						$un_news = null;
						$un_news = $this->news_request($news_li[1][$k],15);
						$un_news = @iconv("GBK", "UTF-8//IGNORE", $un_news);
						$preg_title = '/<div class=\"boxx_left\">(?:.*)<h3>(.*)<\/h3>/iUs';	//匹配标题
						$preg_content = '/<div class=\"left2_3\">(.*)<div class=\"left2_4\">/is';	//匹配内容
						$preg_author = '/<div class=\"boxx_left\">(?:.*)作者：<a(?:.*)>(.*)<\/a>/iUs';	//匹配作者
						$preg_source = '/<div class=\"boxx_left\">(?:.*)来源：(.*)<a(?:.*)>/iUs';	//匹配来源
						$preg_date = '/<div class=\"boxx_left\">(?:.*)<p class=\"zz\">(.*)作者/iUs';	//匹配日期
						$preg_summary = '/<div class=\"boxx_left\">(?:.*)<div class=\"left2_1\">(.*)<\/div>/iUs';	//匹配简介
						preg_match($preg_title,$un_news,$un_title);
						preg_match($preg_content,$un_news,$un_content);
						preg_match($preg_author,$un_news,$un_author);	
						preg_match($preg_source,$un_news,$un_source);
						preg_match($preg_date,$un_news,$un_date);
						preg_match($preg_summary,$un_news,$un_summary);
						$un_content = str_replace('src="/uploadfile/','src="http://www.nzw.cn/uploadfile/',$un_content);
						$res_add = $collection->add_news($un_title[1],$un_summary[1],$un_content[1],$un_author[1],$un_source[1],$un_date[1],'','',$user);	//采集新闻到临时库
						sleep(1);
					}
				}
			}
		}	
	}
	
	private function mina_fashion($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'street':
				$target_url = 'http://fz.mina.com.cn/jiepai/list_12_';
				break;
			case 'trend':
				$target_url = 'http://fz.mina.com.cn/chaoliu/list_8_';
				break;
			case 'mashup':
				$target_url = 'http://fz.mina.com.cn/mina/list_9_';
				break;
			default:
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			$where_url = $target_url.($start+$i).'.html';
			$get_news = null;
			$get_news = $this->http_get($where_url,null,'get',5);
			//$get_news = @iconv("GBK", "UTF-8", $get_news);
			if(!empty($get_news)){
				$preg_newsUl = '/<!--内容S-->(.*)<div class=\"search_top\">/iUs';
				preg_match_all($preg_newsUl,$get_news,$news_ul);
				if(!empty($news_ul[1])){
					$preg_newsLi = '/<div class=\"news_con1 mt10 f14 c3\">(?:.*)<img src=\"(.*)\"(?:.*)><\/a>(?:.*)<h3><a href=\"(.*)\">/iUs';
					preg_match_all($preg_newsLi,$news_ul[1][0],$news_li);
				}
				$len_newsLi = count($news_li[2]);
				if($len_newsLi > 0){
					$news_list = null;
					for($k=0;$k<$len_newsLi;$k++){
						$news_list['cover'][] = $news_li[1][$k];
						$news_list['url'][] = $news_li[2][$k];
					}
					for($k=0;$k<$len_newsLi;$k++){
						$un_news = null;
						$un_news = $this->news_request($news_list['url'][$k],15);
						//$un_news = @iconv("GBK", "UTF-8", $un_news);
						$preg_title = '/<div class=\"title_en\">(.*)<\/div>/iUs';	//匹配标题
						$preg_content = '/<div class=\"BSHARE_HTML\">(.*)<div style=\"margin-top:20px;\">/is';	//匹配内容
						$preg_head = '/<div class=\"title_summary\">(.*)\| 来源: <a>(.*)<\/a> \| 编辑：<a>(.*)<\/a>/iUs';	//匹配作者
						$preg_summary = '/<p class=\"Introduction BSHARE_TEXT\">\[<strong>本文导读<\/strong>\]<a>(.*)<\/a><\/p>/iUs';	//匹配简介
						preg_match($preg_title,$un_news,$un_title);
						preg_match($preg_content,$un_news,$un_content);
						preg_match_all($preg_head,$un_news,$un_head);	//匹配日期、来源、作者。
						preg_match($preg_summary,$un_news,$un_summary);
						$res_add = $collection->add_news($un_title[1],$un_summary[1],$un_content[1],$un_head[3][0],$un_head[2][0],$un_head[1][0],'',$news_list['cover'][$k],$user);	//采集新闻到临时库
						sleep(1);
					}
				}
			}
		}	
	}
	
	private function onlylady($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'collocation':
				$target_url = 'http://fashion.onlylady.com/more-xinyue.html';
				$target_url_follow = 'http://fashion.onlylady.com/more-xinyue-';
				break;
			case 'single':
				$target_url = 'http://fashion.onlylady.com/more-baodian.html';
				$target_url_follow = 'http://fashion.onlylady.com/more-baodian-';
				break;
			default:
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			if($start == 1 && $i == 0){
				$where_url = $target_url;
			}else{
				$where_url = $target_url_follow.($start+$i).'.html';
			}
			$get_news = null;
			$get_news = $this->http_get($where_url,null,'get',5);
			$get_news = @iconv("GBK", "UTF-8//IGNORE", $get_news);
			if(!empty($get_news)){
				$preg_newsUl = '/<div class=\"more_left_6\">(?:.*)<ul>(.*)<\/ul>/iUs';
				preg_match_all($preg_newsUl,$get_news,$news_ul);
				
				if(!empty($news_ul[1])){
					$preg_newsLi = '/<li> <a href=\"(.*)\"(?:.*)<\/li>/iUs';
					preg_match_all($preg_newsLi,$news_ul[1][0],$news_li);
				}
				$len_newsLi = count($news_li[1]);
				if($len_newsLi > 0){
					for($k=0;$k<$len_newsLi;$k++){
						$un_news = null;
						$un_news = $this->news_request('http://fashion.onlylady.com'.$news_li[1][$k],15);
						$un_news = @iconv("GBK", "UTF-8//IGNORE", $un_news);
						$preg_title = '/<h1 class=\"detail_h1\">(.*)<\/h1>/iUs';	//匹配标题
						$preg_content = '/<div class=\"detail_content\" id=\"detail_content\">(.*)<\/div><div class=\"detail_content detail_key\">/is';	//匹配内容
						$preg_head = '/<div class=\"detail_info_l\">(?:.*)<span>(.*)<\/span><span>来源：(.*)<\/span><span>编辑：(.*)<\/span>(?:.*)<\/div>/iUs';	//匹配日期、来源、作者
						$preg_keyword = '/<div class=\"detail_content detail_key\"><strong>关键词：<\/strong>(?:.*)<span>(.*)<\/span>(?:.*)<\/div>/iUs';
						preg_match($preg_title,$un_news,$un_title);
						preg_match($preg_content,$un_news,$un_content);
						preg_match($preg_keyword,$un_news,$un_keyword);
						preg_match_all($preg_head,$un_news,$un_head);
						$res_add = $collection->add_news($un_title[1],'',$un_content[1],$un_head[3][0],$un_head[2][0],$un_head[1][0],$un_keyword[1],'',$user);	//采集新闻到临时库
						sleep(1);
					}
				}
			}
		}
	}
	
	private function herschina($start,$offset=0,$urlType){
		$collection = D('NewsCollection');
		$user = $this->getUser();
		switch ($urlType){
			case 'collocation':
				$target_url = 'http://www.herschina.com/NiShang/20001.html';
				$target_url_follow = 'http://www.herschina.com/NiShang/20001_';
				break;
			case 'star':
				$target_url = 'http://www.herschina.com/NiShang/20004.html';
				$target_url_follow = 'http://www.herschina.com/NiShang/20004_';
				break;
			case 'modeling':
				$target_url = 'http://www.herschina.com/NiShang/20002.html';
				$target_url_follow = 'http://www.herschina.com/NiShang/20002_';
				break;
			default:
				break;
		}
		for($i=0;$i<=$offset;$i++){
			$where_url = null;
			if($start == 1 && $i == 0){
				$where_url = $target_url;
			}else{
				$where_url = $target_url_follow.($start+$i-1).'.html';
			}
			$list_html = null;
			$list_html = file_get_html($where_url);
			if($list_html){
				$list_news = array();
				foreach($list_html->find('a.tt14_heicu') as $e_url){
					$list_news['url'][] = $e_url->href;
				}
				foreach($list_html->find('div#contpic') as $e_cover){
					$list_news['cover'][] = $e_cover->children(0)->children(0)->src;
				}
				$len_newsUrl = count($list_news['url']);
				if($len_newsUrl > 0){
					for($k=0;$k<$len_newsUrl;$k++){
						$un_title = null;
						$un_summary = null;
						$un_content = null;
						$un_source = null;
						$un_date = null;
						$un_keyword = null;
						$news_text = null;
						$news_text = file_get_html($list_news['url'][$k]);
						if($news_text){
							$un_title = $news_text->find('h1',0)->plaintext;
							$un_summary = $news_text->find('META[name="description"]',0)->content;
							$un_content = $news_text->find('div[style=width:635px; margin:auto; font-size:14px; line-height:200%;]',0)->innertext;
							$un_source = $news_text->find('span#wFrom',0)->plaintext;
							$un_date = $news_text->find('div[style=width:660px; height:40px;]',0)->plaintext;
							if(!empty($un_date)){
								$str_date = array();
								$str_date = explode('　　',$un_date);
								$un_date = $str_date[0];
							}
							$un_keyword = $news_text->find('META[name="keywords"]',0)->content;
							$news_page = array();
							foreach($news_text->find('a.red1') as $e_page){
								$news_page[] = $e_page->href;
							}
							if(count($news_page) > 0){
								foreach($news_page as $v_pageUrl){
									$page_text = null;
									$page_text = file_get_html($v_pageUrl);
									if($page_text){
										$un_content .= $page_text->find('div[style=width:635px; margin:auto; font-size:14px; line-height:200%;]',0)->innertext;
										$page_text->clear();
									}
								}
							}
							$res_add = $collection->add_news($un_title,$un_summary,$un_content,'',$un_source,$un_date,$un_keyword,$list_news['cover'][$k],$user);	//采集新闻到临时库
							$news_text->clear();
							sleep(1);
						}
					}
				}
				$list_html->clear();	//释放内存
			}
		}
	}
	
	
	
	
	
	
}
