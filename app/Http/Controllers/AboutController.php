<?php

namespace App\Http\Controllers;

use App\Models\CertificationRecord;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', [
            'skills' => Skill::orderBy('sort_order')->get(),
            'experiences' => Experience::orderBy('sort_order')->get(),
            'education' => Education::orderBy('sort_order')->get(),
            'certifications' => CertificationRecord::orderBy('sort_order')->get(),
        ]);
    }
}
