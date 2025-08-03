<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagCollection;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Tags\Tag;

class TagController extends Controller
{
	public function index() {
		$oProjects = Tag::query();

		$oProjects
			->orderBy('name', 'asc');

		$oPaginator = $oProjects->paginate(15);
		$oPaginator->onEachSide(5);

		return inertia()->render('Tag/index', [
			'tags'	=> $oProjects->get(),
			'paginate'	=> $oPaginator->links()->toHtml(),
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Технологии', 'href' => route('tags.index')],
			]
		]);
	}

	public function search(Request $request) {
		$oTags = Tag::query();

		if ($request->search != '') {
			$oTags->containing($request->search);
		}
		$oTags->paginate(10);
		//dd($oTags->get());
		return $oTags->get();
	}


	public function delete(Tag $tag) {
		$tag->delete();
		return Redirect::route('tags.index');
	}
}
