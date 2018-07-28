<?php

namespace App\Http\ViewComposers\Layouts;

use Illuminate\View\View;
use LaravelLocalization;

class AppComposer
{
	protected $locales;
	protected $currentLocale;
	protected $mainMenuItems;

	public function __construct()
	{
		// Localizations
		foreach(LaravelLocalization::getSupportedLocales() as $locale=>$data)
		{
			$this->locales[$locale] = (object) [
				'short_name' => mb_strtoupper(str_limit($data['native'], 2, '')),
				'full_name' => title_case($data['native']),
			];

			if($locale == LaravelLocalization::getCurrentLocale())
			{
				$this->currentLocale = $this->locales[$locale];
			}
		}
	}

	public function compose(View $view)
	{
		$view->with('locales', $this->locales)
		->with('currentLocale', $this->currentLocale)
		->with('mainMenuItems', $this->mainMenuItems);
	}
}
