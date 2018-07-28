<?php

namespace App\Http\Controllers;

use Runsite\CMF\Http\Controllers\RunsiteCMFBaseController;
use Illuminate\View\View;

class RootsController extends RunsiteCMFBaseController
{
	/**
	 * Display the root node.
	 */
	public function show(): View
	{
		return $this->view('roots.show');
	}
}
