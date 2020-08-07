<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Questionnaire;

class QuestionnaireController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function create()
    {
    	return view('questionnaire.create');
    }

    public function store(Request $request)
    {
    	$validatedData = $request->validate([
    		'title' => 'required',
    		'purpose' => 'required'
    	]);  	

    	$questionnaire = new Questionnaire;
    	$questionnaire->title = $request->title;
    	$questionnaire->purpose = $request->purpose;
    	$questionnaire->user_id = auth()->user()->id;
    	$questionnaire->save();

    	return redirect('/questionnaires/' .$questionnaire->id);

    }

    public function show(Questionnaire $questionnaire)
    {
    	// $questionnaire = Questionnaire::findOrFail($id); 	
        $questionnaire->load('questions.answers');
        // dd($questionnaire);
    	return view('questionnaire.show', compact('questionnaire'));
        
    }
}
