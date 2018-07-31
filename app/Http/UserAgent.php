<?php
namespace App\Http;

class UserAgent
{
    public static function isMobile()
    {
        $UserAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $UserAgent_CommentsBlock = preg_match('|\(.*?\)|', $UserAgent, $matches) > 0 ? $matches[0] : '';
        $mobile_os_list = array('Google Wireless Transcoder', 'Windows CE', 'WindowsCE', 'Symbian', 'Android', 'armv6l', 'armv5', 'Mobile', 'CentOS', 'mowser', 'AvantGo', 'Opera Mobi', 'J2ME/MIDP', 'Smartphone', 'Go.Web', 'Palm', 'iPAQ');
        $mobile_token_list = array('Profile/MIDP', 'Configuration/CLDC-', '160×160', '176×220', '240×240', '240×320', '320×240', 'UP.Browser', 'UP.Link', 'SymbianOS', 'PalmOS', 'PocketPC', 'SonyEricsson', 'Nokia', 'BlackBerry', 'Vodafone', 'BenQ', 'Novarra-Vision', 'Iris', 'NetFront', 'HTC_', 'Xda_', 'SAMSUNG-SGH', 'Wapaka', 'DoCoMo', 'iPhone', 'iPod');

        $found_mobile = self::CheckSubStr($mobile_os_list, $UserAgent_CommentsBlock) ||
            self::CheckSubStr($mobile_token_list, $UserAgent);

        if ($found_mobile) {
            return true;
        } else {
            return false;
        }
    }
    public static function CheckSubStr($subStr, $text)
    {
        foreach ($subStr as $value)
            if (false !== strpos($text, $value)) {
                return true;
            }
        return false;
    }
}