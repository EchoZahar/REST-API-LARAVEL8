<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Question::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required','max:50'],
            'email'     => ['required','email','min:5','max:100'],
            'message'   => ['required','min:5','max:500'],
        ]);
        return Question::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Question::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        $request->validate([
            'name'      => ['required','max:50'],
            'email'     => ['required','email','min:5','max:100'],
            'message'   => ['required','min:5','max:2000'],
            // только зарегастрированный пользователь
            'comment'   => ['required','min:5','max:500'],
            'user_id'   => ['required']
        ]);
        $question->update($request->all());
        return $question;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Question::destroy($id);
    }

    /**
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Question::where('name', 'like', '%'.$name.'%')->get();
    }
}
