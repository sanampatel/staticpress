<?php

namespace sanampatel\StaticPress;

use TightenCo\Jigsaw\Jigsaw;

class TagCount
{
    public function handle(Jigsaw $jigsaw) {

        $tagsArray = collect($jigsaw->getCollection('posts')->map(function ($page) use ($jigsaw) {
            return $page->tags;
        })->values());

        if(is_array($tagsArray)) {
            if(count($tagsArray) > 0) {
                foreach($tagsArray as $tags) {
                    if(count($tags) > 0) {
                        foreach($tags as $tag) {
                            $tagPath = $jigsaw->getSourcePath() . '/_tags/' . $tag . '.md';
                            if(!file_exists($tagPath)) {
                                md_file_write($tagPath, $tag);
                            }
                        }
                    }
                }
            } else {
                $tagPath = $jigsaw->getSourcePath() . '/_tags/' . $tagsArray[0] . '.md';
            }
        } else {
            $tagPath = $jigsaw->getSourcePath() . '/_tags/' . $tagsArray . '.md';
        }

        $categoriesArray = collect($jigsaw->getCollection('posts')->map(function ($page) use ($jigsaw) {
            return $page->categories;
        })->values());

        if(count($categoriesArray) > 0) {
            foreach($categoriesArray as $categories) {
                if(is_array($categories)) {
                    if(count($categories) > 0) {
                        foreach($categories as $category) {
                            $categoryPath = $jigsaw->getSourcePath() . '/_categories/' . $category . '.md';
                            if(!file_exists($categoryPath)) {
                                md_file_write($categoryPath, $category);
                            }
                        }
                    } else {
                        $categoryPath = $jigsaw->getSourcePath() . '/_categories/' . $categories[0] . '.md';
                        if(!file_exists($categoryPath)) {
                            md_file_write($categoryPath, $categories);
                        }
                    }
                } else {
                    $categoryPath = $jigsaw->getSourcePath() . '/_categories/' . $categories . '.md';
                    if(!file_exists($categoryPath)) {
                        md_file_write($categoryPath, $categories);
                    }
                }
            }
        }
    }
}