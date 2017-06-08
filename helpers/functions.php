<?php
use App\User;

if (!function_exists('str_cut')) {
    /**
     * get a specified part of the given string
     * @param string $string
     * @param integer $length
     * @param string $suffix
     * @return string
     */
    function str_cut($string, $length, $suffix = '...')
    {
        $resultString = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strLength = strlen($string);
        for ($i = 0; (($i < $strLength) && ($length > 0)); $i++) {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')) {
                if ($length < 1.0) {
                    break;
                }
                $resultString .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            } else {
                $resultString .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $resultString = htmlspecialchars($resultString, ENT_QUOTES, 'UTF-8');
        if ($i < $strLength) {
            $resultString .= $suffix;
        }
        return $resultString;
    }
}

if (!function_exists('convert_markdown')) {
    /**
     * @param $markdownContent
     * @return string
     */
    function convert_markdown($markdownContent)
    {
        $parser = new Parsedown;
        return !empty($markdownContent) ? $parser->text($markdownContent) : '';
    }
}

if (!function_exists('tree')) {
    function tree($model, $parentId = 0, $level = 0, $html = '-')
    {
        $data = array();
        foreach ($model as $k => $v) {
            if ($v->parent_id == $parentId) {
                if ($level != 0) {
                    $v->html = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                    $v->html .= '|';
                }
                $v->html .= str_repeat($html, $level);
                $data[] = $v;
                $data = array_merge($data, tree($model, $v->id, $level + 1));
            }
        }
        return $data;
    }
}

if (!function_exists('setting_config')) {
    /**
     * get settings of the website
     * @param  [type] $key     [description]
     * @param  string $default [description]
     * @return string          [description]
     */
    function setting_config($key, $default = '')
    {
        $settingRepository = new \App\Repositories\MapRepository();
        $val = $settingRepository->getValue($key);
        return !empty($val) ? $val : $default;
    }
}

if (!function_exists('upload_file')) {
    /**
     * upload file
     * @param  [type] $fileInput file input's names
     * @param  object the instance of Request
     * @return mixed            [description]
     */
    function upload_file($fileInput, $request)
    {
        if ($request->hasFile($fileInput)) {
            $file = $request->file($fileInput);

            $fileName = (string)round((microtime(true) * 1000)) . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads'). '/' . date('Y-m');
            !\File::exists($uploadPath) && \File::makeDirectory($uploadPath, 0755, true);
            $file->move($uploadPath, $fileName);

            return '/uploads/' . date('Y-m') . '/' . $fileName;
        }
        return false;
    }
}

if (!function_exists('processImageViewUrl')) {

    function processImageViewUrl($rawImageUrl, $width = null, $height = null, $mode = 1)
    {
        $para = '?imageView2/' . $mode;
        if ($width)
            $para = $para . '/w/' . $width;
        if ($height)
            $para = $para . '/h/' . $height;
        return $rawImageUrl . $para;
    }
}

if (!function_exists('getImageViewUrl')) {
    /**
     * @see http://developer.qiniu.com/code/v6/api/kodo-api/image/imageview2.html
     * @param $key
     * @param null $width
     * @param null $height
     * @param int $mode
     * @return string
     */
    function getImageViewUrl($key, $width = null, $height = null, $mode = 1)
    {
        return processImageViewUrl(getUrlByFileName($key), $width, $height, $mode);
    }
}


if (!function_exists('formatBytes')) {
    function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int)$size;
            $base = log($size) / log(1024);
            $suffixes = [' bytes', ' KB', ' MB', ' GB', ' TB'];

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }
}

if (!function_exists('getMentionedUsers')) {
    function getMentionedUsers($content)
    {
        preg_match_all("/(\S*)\@([^\r\n\s]*)/i", $content, $atlist_tmp);
        $usernames = [];
        foreach ($atlist_tmp[2] as $k => $v) {
            if ($atlist_tmp[1][$k] || strlen($v) > 25) {
                continue;
            }
            $usernames[] = $v;
        }
        $users = User::whereIn('name', array_unique($usernames))->get();
        return $users;
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        /** @var User $user */
        $user = auth()->user();
        return $user != null && $user->is_admin === 1;
    }
}

if (!function_exists('get_gravatar')) {
    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */
    function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}