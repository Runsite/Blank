<?php

namespace App\Http\ViewComposers\Layouts\Middle;

use Illuminate\View\View;

class SearchComposer
{
	protected $categories;

	public function __construct()
	{
		$this->categories = M('search_category')->orderBy('position', 'asc')->get();
	}

	public function compose(View $view)
	{
		$view->with('categories', $this->categories);
	}
}
