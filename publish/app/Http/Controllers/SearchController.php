<?php

namespace App\Http\Controllers;

use Runsite\CMF\Http\Controllers\RunsiteCMFBaseController;
use Illuminate\View\View;
use Illuminate\Http\Request;

class SearchController extends RunsiteCMFBaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {

			if(! $request->term)
				return redirect()->back();

			return $next($request);
		});
    }

	/**
	 * Redirect to first subsection.
	 */
	public function root(Request $request)
	{
        $firstChild = M('search_category')->where('parent_id', $this->node->id)->ordered()->first();
        return redirect(lPath($firstChild->node->path->name . '?term=' . $request->term));
	}

    protected function results(Request $request): View
    {
        $searchResults = M($this->fields->model)
            ->where('name', 'like', '%'.$request->term.'%')
            ->orderBy('rs_nodes.created_at', 'desc')
            ->paginate();

        $searchCategories = M('search_category')->where('parent_id', $this->node->parent_id)->ordered()->get();

        $parentSection = M('section')->where('node_id', $this->node->parent_id)->first();
        
        return $this->view('search.show', compact('searchResults', 'searchCategories', 'parentSection'));
    }
}
