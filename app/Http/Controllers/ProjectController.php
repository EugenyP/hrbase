<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonUpdateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Models\Person;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Tags\Tag;

class ProjectController extends Controller
{
    public function index(Person $person) {
		$oProjects = $person->projects();

		$oProjects
			->orderBy('id', 'DESC');

		$oPaginator = $oProjects->paginate(10);
		$oPaginator->onEachSide(5);

		return inertia()->render('Project/index', [
			'projects'	=> $oProjects->get(),
			'person'	=> $person,
			'paginate'	=> $oPaginator->links()->toHtml(),
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Кандидаты', 'href' => route('person.index')],
				[ 'title'	=> "Редактирование {$person->firstname} {$person->lastname}", 'href' => route('person.edit', $person->id)],
				[ 'title'	=> 'Проекты', 'href' => route('persons.edit.projects', $person->id)]
			]
		]);
	}

	public function edit(Person $person, Project $project) {

		return inertia()->render('Project/edit', [
			'project'	=> $project,
			'person' => $person,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Кандидаты', 'href' => route('person.index')],
				[ 'title'	=> "Редактирование {$person->firstname} {$person->lastname}", 'href' => route('person.edit', $person->id)],
				[ 'title'	=> 'Проекты', 'href' => route('persons.edit.projects', $person->id)],
				[ 'title'	=> 'Редактирование', 'href' => route('persons.edit.projects.edit', [$person->id, $project->id])],
			]
		]);
	}

	public function create(Person $person) {

		$project = new Project();

		$data = array_combine(
			$project->getFillable(),
			array_fill(0, count($project->getFillable()), '')
		);
		$project->id = 0;
		$project->fill($data);

		return inertia()->render('Project/edit', [
			'project'	=> $project,
			'person' => $person,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Кандидаты', 'href' => route('person.index')],
				[ 'title'	=> "Редактирование {$person->firstname} {$person->lastname}", 'href' => route('person.edit', $person->id)],
				[ 'title'	=> 'Проекты', 'href' => route('persons.edit.projects', $person->id)],
				[ 'title'	=> 'Добавление проекта', 'href' => '#'],
			]
		]);
	}

	public function update(ProjectUpdateRequest $request, Person $person, Project $project) {

		$project->fill($request->validated());

		$project->save();

		$aTags = $request->tags;
		if (is_array($aTags)) {
			$tmpTags = [];
			foreach ($aTags as $aTag) {
				$tag = Tag::findOrCreateFromString($aTag['name']['ru']);
				$tmpTags[] = $tag;
			}
			$project->syncTags($tmpTags);
			$person->attachTags($tmpTags);
		}

		return Redirect::route('persons.edit.projects.edit', [$person->id, $project->id]);
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(ProjectUpdateRequest $request, Person $person): RedirectResponse
	{

		$project = new Project();
		$project->id = null;
		$project->person_id = $person->id;

		$this->update($request, $person, $project);

		return Redirect::route('persons.edit.projects', $person->id);
	}
}
