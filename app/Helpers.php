<?php

function truncate($str, $length)
{
    if (strlen($str) > $length) {
        $str = substr($str, 0, $length + 1);
        $pos = strrpos($str, ' ');
        $str = substr($str, 0, ($pos > 0) ? $pos : $length);
    }
    return $str;
}

function estimate_reading_time($content): string
{
    $word_count = str_word_count(strip_tags($content));

    $minutes = floor($word_count / 200);
    $seconds = floor($word_count % 200 / (200 / 60));

    if ($seconds > 30) {
        $minutes = +1;
    }

    return $minutes;
}

function saveTextEditorImage($detail)
{
    $dom = new \domdocument();
    @$dom->loadHtml(mb_convert_encoding($detail, 'HTML-ENTITIES', 'UTF-8'));
    $images = $dom->getelementsbytagname('img');

    if (!File::exists(public_path('/uploads/'))) {
        File::makeDirectory(public_path() . '/' . '/uploads/', 0777, true, true);
    }
    foreach ($images as $k => $img) {
        $data = $img->getattribute('src');
        $check_image = substr($data, 0, 10);
        if ($check_image != "data:image") {
            continue;
        }
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $image_name = time() . $k . '.png';
        $path = public_path("/") . '/uploads/' . $image_name;
        file_put_contents($path, $data);
        $img->removeattribute('src');
        $img->setattribute('src', asset('/uploads/' . $image_name));
    }

    return $detail = $dom->savehtml();
}

/**
 * This method inserts ad script into articles after specific paragraph or break line if paragraph is not there.
 *
 * @param $insertion
 * @param $adInfo
 * @param $content
 * @return string
 */
function insert_ad_into_content($insertion, $adInfo, $content): string
{
    if (env('APP_ENV') == 'local' || (env('APP_ENV') == 'production' && $adInfo == null)) {
        return $content;
    }

    $closeTag = '</p>';
    $paragraphs = explode($closeTag, $content);

    if (count($paragraphs) === 1) {
        $closeTag = '<br />';
        $paragraphs = explode($closeTag, $content);
    }

    if (count($paragraphs) >= $insertion) {
        foreach ($paragraphs as $index => $paragraph) {

            if (trim($paragraph)) {
                $paragraphs[$index] .= $closeTag == '<br />' ? $closeTag . $closeTag : $closeTag;
            }

            if ($insertion == $index + 1) {
                $paragraphs[$index] .= $adInfo->formatted_content;
            }
        }

        return implode('', $paragraphs);
    }

    return $content;
}


function isIosDevice($userAgent): bool
{
    if (empty($userAgent)) return false;

    $userAgent = strtolower($userAgent);
    $iosDevice = array('iphone', 'ipod', 'ipad', 'apple');
    $isIos = false;

    foreach ($iosDevice as $val) {
        if (stripos($userAgent, $val) !== false) {
            $isIos = true;
            break;
        }
    }

    return $isIos;
}
