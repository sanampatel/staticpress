<?php

namespace SanamPatel\StaticPress;

use TightenCo\Jigsaw\Jigsaw;

class SlugChecker
{
    public function handle(Jigsaw $jigsaw)
    {
        try {
            $posts = collect($jigsaw->getCollection('posts')->map(function ($page) use ($jigsaw) {
                return [
                    'title' => $page->title,
                    'path' => $page->getPath(),
                    'slug' => $page->slug
                ];
            })->values());

            foreach ($posts as $post) {
                if($post['slug'] !== "" || $post['slug'] !== null) {

                    $postPath = $jigsaw->getSourcePath() . '/_posts' . $post['path'] . '.md';
                    $newPath = $jigsaw->getSourcePath() . '/_posts/' . senitize_url($post['slug']) . '.md';

                    if(file_exists($postPath) && !file_exists($newPath)) {
                        if($postPath != $newPath) {
                            rename($postPath, $newPath);
                        }
                    }
                }
            }
        } catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }
    }
}
