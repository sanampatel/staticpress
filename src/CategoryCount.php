<?php

namespace SanamPatel\StaticPress;

use TightenCo\Jigsaw\Jigsaw;

class CategoryCount {

	public function handle(Jigsaw $jigsaw) {

		$categoriesCollection = collect($jigsaw->getCollection('posts')->map(function ($page) use ($jigsaw) {
			return $page->categories;
		})->values());

		$categoriesArray = $categoriesCollection->toArray();

		if(is_array($categoriesArray)) {
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
						}
					}
				}
			}
		}
	}
}
