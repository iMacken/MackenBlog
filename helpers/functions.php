<?php

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