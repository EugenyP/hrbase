<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonUpdateRequest;
use App\Models\Category;
use App\Models\Person;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Tags\Tag;

class PersonController extends Controller
{

	public function index(Request $request) {
		$oPersons = Person::query();
		$oPersons
			->orderBy('id', 'DESC');


		$category = intval($request->query('category', 0));
		if ($category > 0) {
			$oPersons->where('category_id', $category);
		}
		$filter = [];

		$tech = $request->query('tech', []);
		$tags = [];
		if (count($tech)) {
			foreach ($tech as $id_tech) {
				$oTag = Tag::find($id_tech);
				if ($oTag) {
				//	dd($oTag);
					$tags[] = $oTag;
					$filter[] = $oTag;
				}
			}
			if (count($tags)) {
				$oPersons->withAnyTags($tags);
			}
		}
		$filterTags = Tag::query();
		$filterTags->orderBy('name', 'asc');
		$oPaginator = $oPersons->paginate(10);
		if ($category) {
			$oPaginator->appends(['category' => $category]);
		}
		$oPaginator->onEachSide(5);
		$aPersons = [];
		$aTmpPerson = $oPersons->get();

		$bExp = false;

		foreach ($aTmpPerson as $person) {
			$aPerson = $person->toArray();
			$projects = $person->projects()->get();
			$exp = [];
			if (count($tags)) {
				foreach ($projects as $project) {
					$date1 = Carbon::createFromFormat('Y-m-d', $project->startdate);
					$date2 = Carbon::createFromFormat('Y-m-d', $project->enddate);

					$tmpTags = array_map(function ($item) {
						return $item->id;
					}, $tags);
					$atags = $project->tags->find($tmpTags);
					$diff = round($date1->diffInMonths($date2));
					foreach ($atags as $tag) {
						!isset($exp[$tag->id]) && $exp[$tag->id] = 0;
						$exp[$tag->id] += $diff;
					}
				}
				$aPerson['exp'] = $exp;
				if ($exp > 0) {
					$bExp = TRUE;
				}
			}
			$aPersons[] = $aPerson;
		}

		$aCategories = Category::all();

		$data = [
			'persons' => $aPersons,

			'paginate'	=>	$oPaginator->links()->toHtml(),
			'categories'	=> $aCategories,
			'category'		=> $category,
			'filter'		=> $filter,
			'exp'			=> $bExp,
			'filterTags'	=> [],
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Кандидаты', 'href' => route('person.index')]
			]
		];
		if ($category) {
			$oCategory = Category::find($category);
			if ($oCategory) {
				$data['filterTags'] = $oCategory->tags->all();
				//dd($data['filterTags']);
				$data['breadcrumbs'][] = [ 'title'	=> $oCategory->name, 'href' => '#'];
			}
		} else {
			$data['filterTags'] = $filterTags->get();
		}
		return inertia()->render('Person/index', $data);
	}

	public function show(Person $person) {

		$projects = $person->projects()->get();
		$exp = [];
		foreach ($projects as $project) {
			$date1 = Carbon::createFromFormat('Y-m-d', $project->startdate);
			$date2 = Carbon::createFromFormat('Y-m-d', $project->enddate);

			$tags = $project->tags->all();
			$diff = round($date1->diffInMonths($date2));
			foreach ($tags as $tag ) {
				!isset($exp[$tag->id]) && $exp[$tag->id] = 0;
				$exp[$tag->id] += $diff;
			}
		}
		$aPerson = $person->toArray();
		$aPerson['exp'] = $exp;
		return inertia()->render('Person/show', [
			'person' => $aPerson,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Кандидаты', 'href' => route('person.index')],
				[ 'title'	=> "{$person->fio}", 'href' => route('person.show', $person->id)]
			]
		]);
	}

	public function edit(Person $person) {
		$aCategories = Category::all();
		return inertia()->render('Person/edit', [
			'person' => $person,
			'categories'	=> $aCategories,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Кандидаты', 'href' => route('person.index')],
				[ 'title'	=> "Редактирование {$person->fio}", 'href' => route('person.edit', $person->id)]
			]
		]);
	}

	public function update(PersonUpdateRequest $request, Person $person) {

		$person->fill($request->validated());
		$person->save();

		return Redirect::route('person.edit', $person->id);
	}

	/**
	 * Display the registration view.
	 */
	public function create(): Response
	{
		$person = new Person();

		$aCategories = Category::all();

		$data = array_combine(
			$person->getFillable(),
			array_fill(0, count($person->getFillable()), '')
		);
		$person->id = 0;
		$person->fill($data);

		return Inertia::render('Person/edit', [
			'person' => $person,
			'categories'	=> $aCategories,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Кандидаты', 'href' => route('person.index')],
				[ 'title'	=> "Добавление кандидата", 'href' => '#']
			]
		]);
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(PersonUpdateRequest $request): RedirectResponse
	{

		$person = new Person();
		$person->id = null;
		$person->fill($request->validated());

		$person->save();

		return Redirect::route('person.edit', $person->id);
	}

	public function delete(Person $person) {
		$person->delete();
		return Redirect::route('person.index');
	}
}
