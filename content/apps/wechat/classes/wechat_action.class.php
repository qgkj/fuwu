<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_action {
    /**
     * 文本回复
     * @param unknown $request
     */
    public static function Text_action($request) {
    	$content = null;
    	
    	RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'command_reply'), 10, 2);
    	RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'keyword_reply'), 90, 2);
    	RC_Hook::add_filter('wechat_text_response', array(__CLASS__, 'empty_reply'), 100, 2);
    	
    	$content = RC_Hook::apply_filters('wechat_text_response', $content, $request);
    	
    	$response = Component_WeChat_Response::create($content);
    	RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
    	$response->send();
    }
    
    /**
     * 消息为空回复
     * @param unknown $content
     * @param unknown $request
     * @return multitype:string unknown NULL
     */
    public static function empty_reply($content, $request) {
        if (!is_null($content)) {
            return $content;
        }
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        RC_Loader::load_app_class('wechat_response', 'wechat', false);
        $wechat_id = wechat_method::wechat_id();
       
        $wr_db    = RC_Loader::load_app_model('wechat_reply_model', 'wechat');
        $media_db = RC_Loader::load_app_model('wechat_media_model', 'wechat');
        $field    = 'reply_type,content,media_id';
        $data     = $wr_db->field($field)->find(array('wechat_id'=>$wechat_id,'type'=>'msg'));
        if ($data['reply_type'] == 'text') {
        	$msg = $data['content'];
        	$content = wechat_response::Text_reply($request, $msg);
        }else if ($data['reply_type'] == 'image') {
        	$msg   = $media_db->where(array('id' => $data['media_id']))->get_field('thumb');
        	$content = wechat_response::Image_reply($request, $msg);
        }else if ($data['reply_type'] == 'voice') {
        	$msg   = $media_db->where(array('id' => $data['media_id']))->get_field('media_id');
        	$content = wechat_response::Voice_reply($request, $msg);
        }else if ($data['reply_type'] == 'video') {
        	$field='title, digest, media_id';
        	$msg = $media_db->field($field)->find(array('id' => $data['media_id']));
        	$content = wechat_response::Video_reply($request, $msg['media_id'], $msg['title'], $msg['digest']);
        }
        return $content;
    }
    
    /**
     * 命令回复
     * @param unknown $content
     * @param unknown $request
     * @return unknown|multitype:string NULL
     */
    public static function command_reply($content, $request) {
        if (!is_null($content)) {
            return $content;
        }
        
        RC_Loader::load_app_class('platform_command', 'platform', false);
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        $wechat_id = wechat_method::wechat_id();
        
        $command = new platform_command($request, $wechat_id);
        $content = $command->runCommand($request->getParameter('Content'));
        
        return $content;
    }
    
    /**
     * 关键字回复
     * @param unknown $content
     * @param unknown $request
     * @return unknown|multitype:string NULL unknown
     */
    public static function keyword_reply($content, $request) {
        if (!is_null($content)) {
            return $content;
        }
        
        $wr_db     = RC_Loader::load_app_model('wechat_reply_model', 'wechat');
        $wr_viewdb = RC_Loader::load_app_model('wechat_reply_viewmodel','wechat');
        $media_db  = RC_Loader::load_app_model('wechat_media_model', 'wechat');
        RC_Loader::load_app_class('platform_account', 'platform', false);
        RC_Loader::load_app_func('global','wechat'); 
               
        $uuid           = trim($_GET['uuid']);
        $account        = platform_account::make($uuid);
        $wechat_id      = $account->getAccountID();
        $rule_keywords  = $request->getParameter('content');
        wechat_method::record_msg($request->getParameter('FromUserName'),$rule_keywords);
        $result         = $wr_viewdb->where(array('wrk.rule_keywords = '."'$rule_keywords'", 'wr.wechat_id' => $wechat_id))->field('wr.content,wr.media_id,wr.reply_type')->select();
        if(!empty($result)) {
            if (!empty($result[0]['media_id'])) {
                $field='id, title, content, digest, file, type, file_name, article_id, link';
                $mediaInfo = $media_db->field($field)->find(array('id' => $result[0]['media_id'],'wechat_id'=>$wechat_id));
                if ($result[0]['reply_type'] == 'image') {
                	$msg   = $media_db->where(array('id' => $result[0]['media_id']))->get_field('thumb');
                    $content = array(
                        'ToUserName' 	=> $request->getParameter('FromUserName'),
                        'FromUserName' 	=> $request->getParameter('ToUserName'),
                        'CreateTime' 	=> SYS_TIME,
                        'MsgType' 		=> $result[0]['reply_type'],
                        'Image' 		=> array(
                            'MediaId'	=>	$msg//通过素材管理接口上传多媒体文件，得到的id。
                        )
                    );
                    wechat_method::record_msg($request->getParameter('FromUserName'),RC_Lang::get('wechat::wechat.image_content'), 1);
                } elseif ($result[0]['reply_type'] == 'voice') {
                	$msg   = $media_db->where(array('id' => $result[0]['media_id']))->get_field('media_id');
                    $content = array(
                        'ToUserName' 	=> $request->getParameter('FromUserName'),
                        'FromUserName' 	=> $request->getParameter('ToUserName'),
                        'CreateTime' 	=> SYS_TIME,
                        'MsgType' 		=> $result[0]['reply_type'],
                        'Voice' 		=> array(
                            'MediaId' 	=> $msg,
                        )
                    );
                    wechat_method::record_msg($request->getParameter('FromUserName'),RC_Lang::get('wechat::wechat.voice_content'), 1);
                } elseif ($result[0]['reply_type'] == 'video') {
                	$msg   = $media_db->where(array('id' => $result[0]['media_id']))->get_field('media_id');
                    $content = array(
                        'ToUserName' 	=> $request->getParameter('FromUserName'),
                        'FromUserName' 	=> $request->getParameter('ToUserName'),
                        'CreateTime' 	=> SYS_TIME,
                        'MsgType' 		=> $result[0]['reply_type'],
                        'Video' 		=> array(
                            'MediaId' 	  => $msg,
                            'Title' 	  => $mediaInfo['title'],
                            'Description' => $mediaInfo['digest']
                        )
                    );
                    wechat_method::record_msg($request->getParameter('FromUserName'),RC_Lang::get('wechat::wechat.video_content'), 1);
                } elseif ($result[0]['reply_type'] == 'news') {
                    // 图文素材
                    $articles = array();
                    if (! empty($mediaInfo['article_id'])) {
                        $artids = explode(',', $mediaInfo['article_id']);
                        foreach ($artids as $key => $val) {
                            $field='id, title, file, content, digest,link';
                            $artinfo = $media_db->field($field)->find(array('id'=>$val, 'wechat_id' => $wechat_id));
                            $articles[$key]['Title']        = $artinfo['title'];
                            $articles[$key]['Description']  = '';
                            $articles[$key]['PicUrl']       = RC_Upload::upload_url($artinfo['file']);
                            $articles[$key]['Url']          = $artinfo['link'];
                        }
                    } else {
                        if (!empty($mediaInfo['digest'])){
                            $desc = $mediaInfo['digest'];
                        } else {
                            $desc = msubstr(strip_tags(html_out($mediaInfo['content'])),100);
                        }
                        $articles[0]['Title']       = $mediaInfo['title'];
                        $articles[0]['Description'] = $desc;
                        $articles[0]['PicUrl']      = RC_Upload::upload_url($mediaInfo['file']);
                        $articles[0]['Url']         = $mediaInfo['link'];
                    }
                    $count = count($articles);
                    $content = array(
                        'ToUserName' 	=> 	$request->getParameter('FromUserName'),
                        'FromUserName' 	=> 	$request->getParameter('ToUserName'),
                        'CreateTime' 	=> 	SYS_TIME,
                        'MsgType' 		=> 	$result[0]['reply_type'],
                        'ArticleCount'	=>	$count,
                        'Articles'		=>	$articles
                    );
                    wechat_method::record_msg($request->getParameter('FromUserName'),RC_Lang::get('wechat::wechat.graphic_info'), 1);
                }
        
            } else {
                $content = array(
                    'ToUserName'    => $request->getParameter('FromUserName'),
                    'FromUserName'  => $request->getParameter('ToUserName'),
                    'CreateTime'    => SYS_TIME,
                    'MsgType'       => 'text',
                    'Content'       => $result[0]['content']
                );
                wechat_method::record_msg($request->getParameter('FromUserName'),$result[0]['content'], 1);
            }
        } 
        return $content;
    }
    
    /**
     * 图片回复
     * @param unknown $request
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[image]]></MsgType>
     * <Image>
     * <MediaId><![CDATA[media_id]]></MediaId>
     * </Image>
     * </xml>
     */
    public static function Image_action($request) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'image',
            'Image'         => array(
                'MediaId'=>$request->getParameter('MediaId')//通过素材管理接口上传多媒体文件，得到的id。
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    
    /**
     * 语音回复
     * @param unknown $request
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[voice]]></MsgType>
     * <Voice>
     * <MediaId><![CDATA[media_id]]></MediaId>
     * </Voice>
     * </xml>
     */
    public static function Voice_action($request) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'voice',
            'Voice'         => array(
                'MediaId'=>$request->getParameter('MediaId')//通过素材管理接口上传多媒体文件，得到的id
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->info('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    /**
     * 视频回复
     * @param unknown $request
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[video]]></MsgType>
     * <Video>
     * <MediaId><![CDATA[media_id]]></MediaId>
     * <Title><![CDATA[title]]></Title>
     * <Description><![CDATA[description]]></Description>
     * </Video>
     * </xml>
     */
    public static function Video_action($request) {
        $content = array(
            'ToUserName'     => $request->getParameter('FromUserName'),
            'FromUserName'   => $request->getParameter('ToUserName'),
            'CreateTime'     => SYS_TIME,
            'MsgType'        => 'video',
            'Video'          => array(
                'MediaId'    =>$request->getParameter('MediaId'), //通过素材管理接口上传多媒体文件，得到的id
                'Title'      =>'test',
                'Description'=>'testneirong'
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    
    /**
     * 音乐回复
     * @param unknown $request
     * @return
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[music]]></MsgType>
     * <Music>
     * <Title><![CDATA[TITLE]]></Title>
     * <Description><![CDATA[DESCRIPTION]]></Description>
     * <MusicUrl><![CDATA[MUSIC_Url]]></MusicUrl>
     * <HQMusicUrl><![CDATA[HQ_MUSIC_Url]]></HQMusicUrl>
     * <ThumbMediaId><![CDATA[media_id]]></ThumbMediaId>
     * </Music>
     * </xml>
     */
    public static function Music_action($request) {    
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'music',
            'Music'         => array(
                'Title'         =>'',
                'Description'   =>'',
                'MusicUrl'      =>'',
                'HQMusicUrl'    =>'',//高质量音乐链接，WIFI环境优先使用该链接播放音乐
                'ThumbMediaId'  =>'',//缩略图的媒体id，通过素材管理接口上传多媒体文件，得到的id
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    
    /**
     * 自定义菜单点击事件
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[FromUser]]></FromUserName>
     * <CreateTime>123456789</CreateTime>
     * <MsgType><![CDATA[event]]></MsgType>
     * <Event><![CDATA[CLICK]]></Event>
     * <EventKey><![CDATA[EVENTKEY]]></EventKey>
     * </xml>
     */
    public static function Click_action($request) {
        RC_Loader::load_app_class('platform_command', 'platform', false);
        RC_Loader::load_app_class('wechat_method', 'wechat', false);
        $wechat_id = wechat_method::wechat_id();
        
        $command = new platform_command($request, $wechat_id);
        $content = $command->runCommand($request->getParameter('EventKey'));
        
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('wechat')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }

    
    /**
     * 图文回复
     * @param unknown $request
     * <xml>
     * <ToUserName><![CDATA[toUser]]></ToUserName>
     * <FromUserName><![CDATA[fromUser]]></FromUserName>
     * <CreateTime>12345678</CreateTime>
     * <MsgType><![CDATA[news]]></MsgType>
     * <ArticleCount>2</ArticleCount>
     * <Articles>
     * <item>
     * <Title><![CDATA[title1]]></Title>
     * <Description><![CDATA[description1]]></Description>
     * <PicUrl><![CDATA[picurl]]></PicUrl>
     * <Url><![CDATA[url]]></Url>
     * </item>
     * <item>
     * <Title><![CDATA[title]]></Title>
     * <Description><![CDATA[description]]></Description>
     * <PicUrl><![CDATA[picurl]]></PicUrl>
     * <Url><![CDATA[url]]></Url>
     * </item>
     * </Articles>
     * </xml>
     */
    public static function Articles_action($request) {
        $content = array(
            'ToUserName'    => $request->getParameter('FromUserName'),
            'FromUserName'  => $request->getParameter('ToUserName'),
            'CreateTime'    => SYS_TIME,
            'MsgType'       => 'news',
            'ArticleCount'  => '',
            'Articles'      => array(
                'item'      =>array(
                        'Title'         => '',
                        'Description'   => '',
                        'PicUrl'        => '',
                        'Url'           =>''
                    ),
                'item'      =>array(
                        'Title'         => '',
                        'Description'   => '',
                        'PicUrl'        => '',
                        'Url'           =>''
                    )
            )
        );
        $response = Component_WeChat_Response::create($content);
        RC_Logger::getLogger('pay')->debug('RESPONSE: ' . json_encode($response->getContent()));
        $response->send();
    }
    
    /**
     * 关注公众号
     * @param unknown $request
     */
    public static function Subscribe_action($request) {  
    	$wechatuser_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
    	
    	RC_Loader::load_app_class('wechat_method', 'wechat', false);
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    
    	$uuid   = trim($_GET['uuid']);
    	$wechat = wechat_method::wechat_instance($uuid);
    	
    	$openid = $request->getParameter('FromUserName');
    	$info   = $wechat->getUserInfo($openid);
    	if (empty($info)) {
    		$info = array();
    	}

    	$account   = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	
    	if (isset($info['unionid']) && $info['unionid']) {
    	    //查看有没有在手机或网站上使用微信登录
    	    $connect_user = RC_Api::api('connect', 'connect_user', array('connect_code' => 'sns_wechat', 'open_id' => $info['unionid']));
    	    if ($connect_user) {
    	        $ect_uid = $connect_user['user_id'];
    	    } else {
    	        //查看公众号unionid是否绑定
    	        $ect_uid = $wechatuser_db->where(array('unionid' => $info['unionid']))->get_field('ect_uid');
    	    }
    	} else {
    	    $ect_uid = 0;
    	}

    	$count = $wechatuser_db->where(array('wechat_id' => $wechat_id, 'openid' => $openid))->count();
    	if ($count > 0) {
    	    //曾经关注过,再次关注
    	    $data['group_id']             = isset($info['groupid']) ? $info['groupid'] : $wechat->getUserGroup($openid);
    	    $data['subscribe']            = 1;
    	    $data['nickname']             = $info['nickname'];
    	    $data['sex']                  = $info['sex'];
    	    $data['city']                 = $info['city'];
    	    $data['country']              = $info['country'];
    	    $data['province']             = $info['province'];
    	    $data['language']             = $info['language'];
    	    $data['headimgurl']           = $info['headimgurl'];
    	    $data['subscribe_time']       = $info['subscribe_time'];
    	    $data['remark']               = $info['remark'];
    	    $data['unionid']              = isset($info['unionid']) ? $info['unionid'] : '';
    	    $data['ect_uid']              = $ect_uid ? $ect_uid : 0;
    	    
    	    $wechatuser_db->where(array('wechat_id' => $wechat_id, 'openid' => $openid))->update($data);
    	} else { 
    	    $data['wechat_id']        = $wechat_id;
    	    $data['group_id']         = isset($info['groupid']) ? $info['groupid'] : $wechat->getUserGroup($openid);
    	    $data['subscribe']        = 1;
    	    $data['openid']           = $openid;
    	    $data['nickname']         = $info['nickname'];
    	    $data['sex']              = $info['sex'];
    	    $data['city']             = $info['city'];
    	    $data['country']          = $info['country'];
    	    $data['province']         = $info['province'];
    	    $data['language']         = $info['language'];
    	    $data['headimgurl']       = $info['headimgurl'];
    	    $data['subscribe_time']   = $info['subscribe_time'];
    	    $data['remark']           = $info['remark'];
    	    $data['unionid']          = isset($info['unionid']) ? $info['unionid'] : '';
    	    $data['ect_uid']          = $ect_uid ? $ect_uid : 0;
    	    
    	    $wechatuser_db->insert($data);
    	}

    	//给关注用户进行问候
    	$wr_db = RC_Loader::load_app_model('wechat_reply_model', 'wechat');
    	$field = 'reply_type,content,media_id';
    	$replymsg = $wr_db->field($field)->find(array('wechat_id'=>$wechat_id,'type'=>'subscribe'));
    	$media_db = RC_Loader::load_app_model('wechat_media_model', 'wechat');
    	if ($replymsg['reply_type'] == 'text') {
    		if(!empty($replymsg['content'])){
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => $replymsg['content']
    			);
    			wechat_method::record_msg($openid, $replymsg['content'], 1);
    		}else{
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => '感谢您的关注'
    			);
    			wechat_method::record_msg($openid, '感谢您的关注', 1);
    		}
    	} else if ($replymsg['reply_type'] == 'image') {
    		if(!empty($replymsg['media_id'])){
    			$thumb   = $media_db->where(array('id' => $replymsg['media_id']))->get_field('thumb');
    			$content = array(
    					'ToUserName'    => $request->getParameter('FromUserName'),
    					'FromUserName'  => $request->getParameter('ToUserName'),
    					'CreateTime'    => SYS_TIME,
    					'MsgType'       => 'image',
    					'Image'         => array(
    							'MediaId' => $thumb //通过素材管理接口上传多媒体文件，得到的id。
    					)
    			);
    			wechat_method::record_msg($openid, RC_Lang::get('wechat::wechat.image_content'), 1);
    		}else{
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => '感谢您的关注'
    			);
    			wechat_method::record_msg($openid, '感谢您的关注', 1);
    		}
    	}else if ($replymsg['reply_type'] == 'voice') {
    		if(!empty($replymsg['media_id'])){
    			$media_id = $media_db->where(array('id' => $replymsg['media_id']))->get_field('media_id');
    			$content = array(
    					'ToUserName'    => $request->getParameter('FromUserName'),
    					'FromUserName'  => $request->getParameter('ToUserName'),
    					'CreateTime'    => SYS_TIME,
    					'MsgType'       => 'voice',
    					'Voice'         => array(
    							'MediaId' 	=> $media_id, //通过素材管理接口上传多媒体文件，得到的id。
    					)
    			);
    			wechat_method::record_msg($openid, RC_Lang::get('wechat::wechat.voice_content'), 1);
    		}else{
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => '感谢您的关注'
    			);
    			wechat_method::record_msg($openid, '感谢您的关注', 1);
    		}
    	}else if ($replymsg['reply_type'] == 'video') {
    		if(!empty($replymsg['media_id'])){
    			$field='title, digest, media_id';
    			$mediaInfo = $media_db->field($field)->find(array('id' => $replymsg['media_id']));
    			$content = array(
    					'ToUserName'    => $request->getParameter('FromUserName'),
    					'FromUserName'  => $request->getParameter('ToUserName'),
    					'CreateTime'    => SYS_TIME,
    					'MsgType'       => 'video',
    					'Video'         => array(
    							'MediaId' 	     => $media_id, //通过素材管理接口上传多媒体文件，得到的id。
    							'Title' 	     => $mediaInfo['title'],
    							'Description'    => $mediaInfo['digest']
    					)
    			);
    			wechat_method::record_msg($openid, RC_Lang::get('wechat::wechat.video_content'), 1);
    		}else{
    			$content = array(
    					'ToUserName'   => $request->getParameter('FromUserName'),
    					'FromUserName' => $request->getParameter('ToUserName'),
    					'CreateTime'   => SYS_TIME,
    					'MsgType'      => 'text',
    					'Content'      => '感谢您的关注'
    			);
    			wechat_method::record_msg($openid, '感谢您的关注', 1);
    		}
    	}

    	$response = Component_WeChat_Response::create($content);
    	RC_Logger::getLogger('pay')->debug('RESPONSE: ' . json_encode($response->getContent()));
    	$response->send();
    }
    
    
    /**
     * 已关注事件
     * @param unknown $request
     */
    public static function Scan_action($request) {
    	$wechatuser_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
    	
    	RC_Loader::load_app_class('wechat_method', 'wechat', false);
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	
    	$uuid   = trim($_GET['uuid']);
    	$wechat = wechat_method::wechat_instance($uuid);
    	$openid = $request->getParameter('FromUserName');
    	
    	$info = $wechat->getUserInfo($openid);
    	
    	if (empty($info)) {
    		$info = array();
    	}
    
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	
    	$data['wechat_id']      = $wechat_id;
    	$data['group_id']       = isset($info['groupid']) ? $info['groupid'] : $wechat->getUserGroup($openid);
    	$data['subscribe']      = 1;
    	$data['openid']         = $openid;
    	$data['nickname']       = $info['nickname'];
    	$data['sex']            = $info['sex'];
    	$data['city']           = $info['city'];
    	$data['country']        = $info['country'];
    	$data['province']       = $info['province'];
    	$data['language']       = $info['language'];
    	$data['headimgurl']     = $info['headimgurl'];
    	$data['subscribe_time'] = $info['subscribe_time'];
    	$data['remark']         = $info['remark'];
    	$data['unionid']        = isset($info['unionid']) ? $info['unionid'] : '';
    	
    	$wechatuser_db->insert($data);
    }
    
	/**
	 * 取消关注时
	 * @param unknown $request
	 */
	public static function Unsubscribe_action($request) {
		$wechatuser_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
		RC_Loader::load_app_class('platform_account', 'platform', false);
		
		$uuid      = trim($_GET['uuid']);
		$account   = platform_account::make($uuid);
		$wechat_id = $account->getAccountID();
		$openid    = $request->getParameter('FromUserName');
		$rs        = $wechatuser_db->where(array('openid' => $openid,'wechat_id' => $wechat_id))->count();
		if ($rs > 0) {
			$wechatuser_db->where(array('openid' => $openid,'wechat_id' => $wechat_id))->update(array('subscribe' => 0));
		}
	}
	
	
	/**
	 * 客服消息接入会话的事件
	 * @param unknown $request
	 */
	public static function Kf_Create_Session_action($request) {
		$customer_log = RC_Loader::load_app_model('wechat_customer_log_model', 'wechat');
		
		$data['kf_account']    = $request->getParameter('KfAccount');
		$data['openid']        = $request->getParameter('ToUserName');
		$data['type']          = $request->getParameter('Event');
		$data['create_time']   = $request->getParameter('CreateTime');
		
		$customer_log->insert($data);
	}
	

	/**
	 * 客服消息关闭会话的事件
	 * @param unknown $request
	 */
	public static function Kf_Close_Session_action($request) {
		$customer_log = RC_Loader::load_app_model('wechat_customer_log_model', 'wechat');
		
		$data['kf_account']    = $request->getParameter('KfAccount');
		$data['openid']        = $request->getParameter('ToUserName');
		$data['type']          = $request->getParameter('Event');
		$data['create_time']   = $request->getParameter('CreateTime');
		
		$customer_log->insert($data);
	}
	

	/**
	 * 客服消息转接会话的事件
	 * @param unknown $request
	 */
	public static function Kf_Switch_Session_action($request) {
		$customer_log = RC_Loader::load_app_model('wechat_customer_log_model', 'wechat');
		
		$data['kf_account']    = $request->getParameter('FromKfAccount');
		$data['openid']        = $request->getParameter('ToUserName');
		$data['type']          = $request->getParameter('Event');
		$data['create_time']   = $request->getParameter('CreateTime');
		
		$customer_log->insert($data);
	}
	
	
	/**
	 * 群发发送成功之后推送的事件
	 * @param unknown $request
	 */
	public static function MassSendJobFinish_action($request) {
		$mass_history = RC_Loader::load_app_model('wechat_mass_history_model', 'wechat');
		$msgid = $request->getParameter('msgid');
		$data = array(
			$data['status']		= $request->getParameter('status'),
			$data['totalcount']	= $request->getParameter('totalcount'),
			$data['filtercount']= $request->getParameter('filtercount'),
			$data['sentcount']	= $request->getParameter('sentcount'),
			$data['errorcount']	= $request->getParameter('errorcount'),
		);
		$mass_history->where(array('msg_id' => $msgid))->update($data);
	}
}

// end