<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台微信公众平台
 * @author royalwang
 */
class wechat_platform_response_api extends Component_Event_Api
{

    public function call(&$options)
    {
        define('WECHAT_LOG_FILE', SITE_LOG_PATH . 'wechat_' . date('Y-m-d') . '.log');

        RC_Loader::load_app_class('wechat_action', 'wechat', false);
        
        $config = array(
            'token'     => $options['token'],
            'appid'     => $options['appid'],
            'appsecret' => $options['appsecret'],
            'aeskey'    => $options['aeskey'],
        );
        $wechat = new Component_WeChat_WeChat($config);
        
        $wechat
            //回复文本消息
            ->on('Text', array('wechat_action', 'Text_action'))
            //回复图片消息
            ->on('Image', array('wechat_action', 'Image_action'))
            //回复语音消息
            ->on('Voice', array('wechat_action', 'Voice_action'))
            //回复视频消息
            ->on('Video', array('wechat_action', 'Video_action'))
            //回复音乐消息
            ->on('Music', array('wechat_action', 'Music_action'))
            //回复图文消息
            ->on('Articles', array('wechat_action', 'Articles_action'))
            
            //普通消息-小视频
            ->on('Shortvideo', array('wechat_action', 'Shortvideo_action'))
            //普通消息-地理位置
            ->on('Location', array('wechat_action', 'Location_action'))
            //普通消息-链接
            ->on('Link', array('wechat_action', 'Link_action'))
            //上报地理位置事件
            ->on('ReportLocation', array('wechat_action', 'ReportLocation_action'))
            //关注时
            ->on('Subscribe', array('wechat_action', 'Subscribe_action'))
            //用户已关注时的事件
            ->on('Scan', array('wechat_action', 'Scan_action'))
            //取消关注时
            ->on('Unsubscribe', array('wechat_action', 'Unsubscribe_action'))
            //自定义菜单点击事件
            ->on('Click', array('wechat_action', 'Click_action'))
            //自定义菜单跳转链接时的事件
            ->on('View', array('wechat_action', 'View_action'))
            //扫码推事件的事件
            ->on('Scancode_Push', array('wechat_action', 'Scancode_Push_action'))
            //扫码推事件且弹出“消息接收中”提示框的事件
            ->on('Scancode_WaitMsg', array('wechat_action', 'Scancode_WaitMsg_action'))
            //弹出系统拍照发图的事件
            ->on('Pic_SysPhoto', array('wechat_action', 'Pic_SysPhoto_action'))
            //弹出拍照或者相册发图的事件
            ->on('Pic_photo_or_album', array('wechat_action', 'pic_photo_or_album_action'))
            //弹出微信相册发图器的事件
            ->on('Pic_Weixin', array('wechat_action', 'Pic_Weixin_action'))
            //弹出地理位置选择器的事件
            ->on('Location_Select', array('wechat_action', 'Location_Select_action'))
            //模板消息发送成功
            ->on('TemplateSendJobFinish', array('wechat_action', 'TemplateSendJobFinish_action'))
            //客服消息接入会话的事件
            ->on('Kf_Create_Session', array('wechat_action', 'Kf_Create_Session_action'))
            //客服消息关闭会话的事件
            ->on('Kf_Close_Session', array('wechat_action', 'Kf_Close_Session_action'))
            //客服消息转接会话的事件
            ->on('Kf_Switch_Session', array('wechat_action', 'Kf_Switch_Session_action'))
            //群发发送成功
            ->on('MassSendJobFinish', array('wechat_action', 'MassSendJobFinish_action'));
        
        $request  = Component_WeChat_Request::createFromGlobals();
        
        RC_Logger::getLogger('wechat')->debug('REQUEST: ' . json_encode($request->getParameters()));
        
        $response = $wechat->handle($request);
        $response->send();
    }
}

// end