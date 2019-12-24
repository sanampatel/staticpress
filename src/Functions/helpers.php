<?php

namespace SanamPatel\StaticPress\Functions;

function content_sanitize($value)
{
    return str_replace(["\r", "\n", "\r\n"], ' ', strip_tags($value));
}

function str_limit_soft($value, $limit = 100, $end = '...')
{
    if (mb_strlen($value, 'UTF-8') <= $limit) {
        return $value;
    }
    return rtrim(strtok(wordwrap($value, $limit, "\n"), "\n"), ' .') . $end;
}

function posts_filter($posts, $tag)
{
    return $posts->filter(function ($post) use ($tag) {
    	// $post->tags = array_map('strtolower', $post->tags);
        return collect($post->tags)->contains($tag->name());
    });
}

function posts_filter_cat($posts, $category)
{
    return $posts->filter(function ($post) use ($category) {
    	// $post->categories = array_map('strtolower', $post->categories);
        return collect($post->categories)->contains($category->name());
    });
}

function get_setting($settings, $key)
{
    return $settings->filter(function ($setting) use ($key) {
        $setting->keys = array_map('strtolower', $setting->keys);
        return collect($setting->keys)->contains($key->name());
    });
}

function get_header($headers, $key)
{
    return $headers->filter(function ($header) use ($key) {
        $header->keys = array_map('strtolower', $header->keys);
        return collect($header->keys)->contains($key->name());
    });
}

function senitize_url($url) {
    $new_url = strtolower($url);
    $new_url = str_replace("  "," ", $new_url);
    $new_url = str_replace(" ","-", $new_url);
    $new_url = str_replace("- ","-", $new_url);
    $new_url = str_replace(" -","-", $new_url);
    $new_url = str_replace(" - ","-", $new_url);

    return $new_url;
}

function seo_keywords($title, $tags, $category) {
    $keywords = "";
    $keywords .= $title;

    if (!empty($tags)) {

        if (is_array ($tags)) {

            foreach ($tags as $key => $tag) {
                $keywords .= ", " . $tag;
            }

        }
        else {
            $keywords .= $tags;
        }
    }

    if (!empty($category)) {

        $keywords .= ", " . $category;

    }

    return $keywords;
}
  
function string_count($str, $counter = 160) {
 
        $out_str = "";
        $count = 0;

        if (strlen($str) < $counter) {
            return $str;
        }
  
        $words = explode(" ", $str);

        foreach ($words as $word) {
          
            $word_len = strlen(trim($word));
            $count += $word_len;
          
            $finalcount = strlen($out_str) + $word_len;
            
          if($finalcount <= $counter) {

            $out_str .= " " . $word;

          } else {
            
            return $out_str;

        }
    }
}

function seo($type, $tags, $category, $title, $return) {

    if ($type == "post" && $return == "keywords") {
        return seo_keywords($title, $tags, $category);
    }

    elseif ($type == "post" && $return == "description") {
        return string_count($title);
    }

    elseif ($type == "tag") {
        return seo_keywords($title, $tags, $category);
    }

    elseif ($type == "category") {
        return seo_keywords($title, $tags, $category);
    }
}

function indian_number_format($num){
    $num=explode('.',$num);
    $dec=(count($num)==2)?'.'.$num[1]:'';
    $num = (string)$num[0];
    if( strlen($num) < 4) return $num;
    $tail = substr($num,-3);
    $head = substr($num,0,-3);
    $head = preg_replace("/\B(?=(?:\d{2})+(?!\d))/",",",$head);
    return $head.",".$tail.$dec;
}

function regex($content){
    $content = preg_replace("/<img[^>]+\>/i", " ", $content); 
    $content = preg_replace("/<video[^>]+\>/i", " ", $content); 
    $content = preg_replace("/ <a.*a>/", " ", $content);
    return $content;
}

function name_from_path($name) {
    if (stripos($name, '.md') !== false) {
        $name = str_ireplace(".md", "", $name);
        if (stripos($name, 'source/_') !== false) {
            $name = str_ireplace("source/_categories/", "", $name);
            $name = str_ireplace("source/_tags/", "", $name);
        }
    }
    return $name;
}

function md_file_write($path, $value) {
    file_put_contents($path, '---' . PHP_EOL, FILE_APPEND);
    file_put_contents($path, 'title: ' . $value . '' . PHP_EOL, FILE_APPEND);
    file_put_contents($path, '---', FILE_APPEND);
}