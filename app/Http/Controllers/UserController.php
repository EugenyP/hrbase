<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Spatie\Tags\Tag;

class UserController extends Controller
{
    //
	public function index() {
		return inertia('User/index', [
			'users' => User::all(),
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Пользователи', 'href' => route('users')]
			]
		]);
	}

	public function edit(User $user) {

		$userData = $user->toArray();
		$userData['password'] = '';
		$userData['password_confirmation'] = '';
		return inertia()->render('User/edit', [
			'user'	=> $userData,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Пользователи', 'href' => route('users')],
				[ 'title'	=> "Редактирование {$user->name}", 'href' => route('users.edit', $user->id)],
			]
		]);
	}

	public function create() {

		$user = new User();

		$data = array_combine(
			$user->getFillable(),
			array_fill(0, count($user->getFillable()), '')
		);
		$user->id = 0;
		$user->fill($data);

		$userData = $user->toArray();
		$userData['password'] = '';
		$userData['password_confirmation'] = '';
		return inertia()->render('User/edit', [
			'user'	=> $userData,
			'breadcrumbs'	=> [
				[ 'title'	=> 'Главная', 'href' => route('dashboard') ],
				[ 'title'	=> 'Пользователи', 'href' => route('users')],
				[ 'title'	=> "Редактирование {$user->name}", 'href' => route('users.edit', $user->id)],
			]
		]);
	}



	public function update(UserUpdateRequest $request, User $user) {

		$validated = $request->validated();
		$user->fill($request->validated());
		$user->update([
			'password' => Hash::make($validated['password']),
		]);

		$user->save();

		return Redirect::route('users', [$user->id]);
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(UserUpdateRequest $request): RedirectResponse
	{

		$user = new User();
		$user->id = null;

		$this->update($request, $user);

		return Redirect::route('users');
	}
}
