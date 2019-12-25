<?php

namespace SanamPatel\StaticPress;
use TightenCo\Jigsaw\Jigsaw;

class CategoryCount {

	public function handle(Jigsaw $jigsaw) {

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