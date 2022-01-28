<?php

namespace App\Http\Controllers;

use App\Models\HelpSubject;

class HelpSubjectController extends Controller
{
    public function __invoke()
    {
        return view('help.index', ['helpSubjects' => HelpSubject::all()]);
    }
}
