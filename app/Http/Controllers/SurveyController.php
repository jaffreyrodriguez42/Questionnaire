<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Questionnaire;

class SurveyController extends Controller
{
    public function show(Questionnaire $questionnaire, $slug)
    {
    	$questionnaire->load('questions.answers');
    	return view('survey.show', compact('questionnaire'));
    }

    public function store(Request $request, Questionnaire $questionnaire)
    {
        // dd($request->all());
    	$validatedData = $request->validate([
    		'responses.*.answer_id' => 'required',
    		'responses.*.question_id' => 'required',
            'survey.name' => 'required',
            'survey.email' => 'required|email'
    	]);

        $survey = $questionnaire->surveys()->create($validatedData['survey']);
        $survey->responses()->createMany($validatedData['responses']);

        // return 'Thank you';  	

        return redirect($questionnaire->path());
    }
}
