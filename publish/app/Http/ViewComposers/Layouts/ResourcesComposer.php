<?php

namespace App\Http\ViewComposers\Layouts;

use Illuminate\View\View;

class ResourcesComposer
{
	protected $rootNode;

	public function __construct()
	{
		$this->rootNode = M('root')->first();
	}

	public function compose(View $view)
	{
		$view->with('rootNode', $this->rootNode);
	}
}
