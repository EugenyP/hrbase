<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller {
	//
	public function __invoke() {
		$oPersons = Person::query();
		$oPersons
			->limit(10)
			->orderBy('id', 'DESC');
		return Inertia::render('Dashboard', [
			'persons' => $oPersons->get()
		]);
	}
}
