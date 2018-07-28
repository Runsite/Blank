<?php

namespace Runsite\Blank\Console\Commands;

use Illuminate\Console\Command;
use Runsite\CMF\Models\Model\Model;
use Runsite\CMF\Models\Model\Field\Field;
use Runsite\CMF\Models\Dynamic\Language;
use Runsite\CMF\Models\Node\Node;
use Runsite\CMF\Models\Node\Dependency;
use Artisan;

class BlankCommand extends Command
{
	protected $signature = 'runsite:blank';
    protected $description = 'Creating blank website';
    
    private function createMenu()
    {
        $menuItemModel = Model::create([
            'name' => 'menu_item',
            'display_name' => trans('runsite-blank::model.menu_item.display_name'),
            'display_name_plural' => trans('runsite-blank::model.menu_item.display_name_plural'),
        ]);

        Field::create([
            'name' => 'name',
            'display_name' => trans('runsite-blank::model.menu_item.fields.name.display_name'),
            'hint' => null,
            'type_id' => 9,
            'model_id' => $menuItemModel->id,
            'group_id' => null,
            'is_common' => false,
            'is_visible_in_nodes_list' => true,
        ]);

        Field::create([
            'name' => 'inner_link',
            'display_name' => trans('runsite-blank::model.menu_item.fields.inner_link.display_name'),
            'hint' => trans('runsite-blank::model.menu_item.fields.inner_link.hint'),
            'type_id' => 12,
            'model_id' => $menuItemModel->id,
            'group_id' => null,
            'is_common' => true,
            'is_visible_in_nodes_list' => true,
        ]);

        Field::create([
            'name' => 'external_link',
            'display_name' => trans('runsite-blank::model.menu_item.fields.external_link.display_name'),
            'hint' => trans('runsite-blank::model.menu_item.fields.external_link.hint'),
            'type_id' => 9,
            'model_id' => $menuItemModel->id,
            'group_id' => null,
            'is_common' => true,
            'is_visible_in_nodes_list' => true,
        ]);

        $adminSectionModel = Model::where('name', 'admin_section')->first();

        $node = Node::create(['parent_id'=>1, 'model_id'=>$adminSectionModel->id], 'Settings');
        foreach(Language::get() as $language)
        {
            $node->{$language->locale}->is_active = true;
            $node->{$language->locale}->name = trans('runsite-blank::nodes.settings.name', [], 'messages', $language->locale);
            $node->{$language->locale}->save();
        }

        $node->baseNode->settings->node_icon = 'cog';
        $node->baseNode->settings->save();
        
        Dependency::create([
            'node_id' => $node->baseNode->id,
            'depended_model_id' => $adminSectionModel->id,
        ]);

        $node = Node::create(['parent_id'=>$node->baseNode->id, 'model_id'=>$adminSectionModel->id], 'Navigation', [], 'messages', $language->locale);
        foreach(Language::get() as $language)
        {
            $node->{$language->locale}->is_active = true;
            $node->{$language->locale}->name = trans('runsite-blank::nodes.navigation.name', [], 'messages',  $language->locale);
            $node->{$language->locale}->save();
        }

        $node->baseNode->settings->node_icon = 'list';
        $node->baseNode->settings->save();

        Dependency::create([
            'node_id' => $node->baseNode->id,
            'depended_model_id' => $adminSectionModel->id,
        ]);

        $node = Node::create(['parent_id'=>$node->baseNode->id, 'model_id'=>$adminSectionModel->id], 'Main menu');
        foreach(Language::get() as $language)
        {
            $node->{$language->locale}->is_active = true;
            $node->{$language->locale}->name = trans('runsite-blank::nodes.main_menu.name', [], 'messages',  $language->locale);
            $node->{$language->locale}->save();
        }

        Dependency::create([
            'node_id' => $node->baseNode->id,
            'depended_model_id' => $menuItemModel->id,
        ]);

        $node = Node::create(['parent_id'=>$node->baseNode->id, 'model_id'=>$menuItemModel->id], 'Home page');
        foreach(Language::get() as $language)
        {
            $node->{$language->locale}->is_active = true;
            $node->{$language->locale}->name = trans('runsite-blank::nodes.home_page_link.name', [], 'messages',  $language->locale);
            $node->{$language->locale}->inner_link = 1;
            $node->{$language->locale}->save();
        }
    }

    private function addGaCodeToRoot()
    {
        $model = Model::where('name', 'root')->first();

        Field::create([
            'name' => 'ga_code',
            'display_name' => trans('runsite-blank::model.root.fields.ga_code.display_name'),
            'hint' => null,
            'type_id' => 14,
            'model_id' => $model->id,
            'group_id' => null,
            'is_common' => true,
            'is_visible_in_nodes_list' => false,
        ]);
    }

    private function makeRootModelSearchable()
    {
        $model = Model::where('name', 'root')->first();

        $model->settings->is_searchable = true;
        $model->settings->save();
    }

    private function createSearch()
    {
        $searchCategoryModel = Model::create([
            'name' => 'search_category',
            'display_name' => trans('runsite-blank::model.search_category.display_name'),
            'display_name_plural' => trans('runsite-blank::model.search_category.display_name_plural'),
        ]);

        $searchCategoryModel->methods->get = 'SearchController@results';
        $searchCategoryModel->methods->save();

        Field::create([
            'name' => 'name',
            'display_name' => trans('runsite-blank::model.search_category.fields.name.display_name'),
            'hint' => null,
            'type_id' => 9,
            'model_id' => $searchCategoryModel->id,
            'group_id' => null,
            'is_common' => false,
            'is_visible_in_nodes_list' => true,
        ]);

        Field::create([
            'name' => 'model',
            'display_name' => trans('runsite-blank::model.search_category.fields.model.display_name'),
            'hint' => null,
            'type_id' => 9,
            'model_id' => $searchCategoryModel->id,
            'group_id' => null,
            'is_common' => true,
            'is_visible_in_nodes_list' => false,
        ]);

        $sectionModel = Model::where('name', 'section')->first();
        
        $node = Node::create(['parent_id'=>1, 'model_id'=>$sectionModel->id], 'Search');
        foreach(Language::get() as $language)
        {
            $node->{$language->locale}->is_active = true;
            $node->{$language->locale}->name = trans('runsite-blank::nodes.search.name', [], 'messages', $language->locale);
            $node->{$language->locale}->save();
        }

        $node->baseNode->methods->get = 'SearchController@root';
        $node->baseNode->methods->save();

        $node->baseNode->settings->node_icon = 'search';
        $node->baseNode->settings->save();

        Dependency::create([
            'node_id' => $node->baseNode->id,
            'depended_model_id' => $searchCategoryModel->id,
        ]);

        $node = Node::create(['parent_id'=>$node->baseNode->id, 'model_id'=>$searchCategoryModel->id], 'Pages');
        foreach(Language::get() as $language)
        {
            $node->{$language->locale}->is_active = true;
            $node->{$language->locale}->name = trans('runsite-blank::nodes.pages.name', [], 'messages', $language->locale);
            $node->{$language->locale}->model = 'page';
            $node->{$language->locale}->save();
        }

        
    }

	public function handle()
	{
        $this->comment('Creating navigation...');
        $this->createMenu();

        $this->comment('Creating GA Code field...');
        $this->addGaCodeToRoot();

        $this->comment('Making Root model searchable...');
        $this->makeRootModelSearchable();

        $this->comment('Creating search...');
        $this->createSearch();

        $this->comment('Publishing vendor...');
        Artisan::call('vendor:publish', [
			'--provider' => 'Runsite\Blank\RunsiteBlankServiceProvider',
			'--force' => true,
		]);

        $this->comment('OK: All done');



        


	}
}
