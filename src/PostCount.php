<?php

namespace SanamPatel\StaticPress;

use TightenCo\Jigsaw\Jigsaw;

class PostCount
{
  public function handle(Jigsaw $jigsaw)
  {

    $posts_path = $jigsaw->getSourcePath() . '/_posts/';
    $post_count = 0;

    $files = glob($posts_path . "*");
    if ($files) {
      $post_count = count($files);
    }

    if ($post_count == 0) {
      $postfile = fopen($posts_path . 'first-post.md', "w") or die("Unable to open file!");

      // WIP
      // $post = file_get_contents('first-post.md');

      $post = <<<EOF
---
title: Features
authorname: StaticPress
date: 2019-07-06T00:00:00.000Z
seotitle: Do not delete this post
seokeywords: 'StaticPress, Warning, First Post'
seodescription: >-
  This is deafult post of StaticPress do not delete else it'll stop working!
tags:
  - demo
  - cms
categories: staticpress
image: /source/images/features-large.png
comments: false
---

This is deafult post of StaticPress do not delete else it'll stop working!
EOF;

      fwrite($postfile, $post);
    }
  }
}
