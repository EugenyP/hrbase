<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Person;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Tags\Tag;

class CategoryController extends Controller
{
	public function index() {
		return inertia('Category/index', [
			'categories' => Category::all(),
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Категории', 'href' => route('categories')]
			]
		]);
    }


	public function edit(Category $category) {

		return inertia()->render('Category/edit', [
			'category'	=> $category,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Категории', 'href' => route('categories')],
				[ 'title'	=> "Редактирование {$category->name}", 'href' => route('category.edit', $category->id)],
			]
		]);
	}

	public function create() {

		$category = new Category();

		$data = array_combine(
			$category->getFillable(),
			array_fill(0, count($category->getFillable()), '')
		);
		$category->id = 0;
		$category->fill($data);

		return inertia()->render('Category/edit', [
			'category'	=> $category,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Категории', 'href' => route('categories')],
				[ 'title'	=> "Редактирование {$category->name}", 'href' => route('category.edit', $category->id)],
			]
		]);
	}

	public function update(CategoryUpdateRequest $request, Category $category) {

		$category->fill($request->validated());

		$category->save();

		$aTags = $request->tags;
		if (is_array($aTags)) {
			$tmpTags = [];
			foreach ($aTags as $aTag) {
				$tag = Tag::findOrCreateFromString($aTag['name']['ru']);
				$tmpTags[] = $tag;
			}
			$category->syncTags($tmpTags);
		}

		return Redirect::route('categories', [$category->id]);
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(CategoryUpdateRequest $request): RedirectResponse
	{

		$category = new Category();
		$category->id = null;

		$this->update($request, $category);

		return Redirect::route('categories');
	}
}
