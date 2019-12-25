<?php

namespace SanamPatel\StaticPress;

use TightenCo\Jigsaw\Jigsaw;

class TagCount {
	
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
    }
}