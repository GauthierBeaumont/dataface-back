<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;

use App\Http\Requests;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question();
        $question->title = htmlspecialchars_decode($request->title);
        $question->user_id = 1; /* AuthComponent::user('id') */
        $question->save();

        $user = User::find($question->user_id);
        return response()->json([
            'title' => $question->title,
            'user' => $user->lastname .' '.$user->firstname,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questions = Question::find($id);

        $title = '';
        $user = '';

        if (!empty($questions)) {
            $title = $questions->title;
            $user = User::find($questions->user_id);
            $user = $user->lastname;
        }

        return response()->json([
            'title' => $title,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $questions = Question::find($id);

        $title = '';
        $user = '';

        if (!empty($questions)) {
            $title = $questions->title;
            $user = User::find($questions->user_id);
            $user = $user->lastname;
        }

        return response()->json([
            'title' => $title,
            'user' => $user,
        ]);
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
        $question->title = htmlspecialchars_decode($request->title);
        $question->user_id = 1; /*AuthComponent::user('id')*/;
        $question->save();

        $user = User::find($question->user_id);
        return response()->json([
            'title' => $question->title,
            'user' => $user->lastname .' '.$user->firstname,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        $question->delete();

        return response()->json([
            'delete' => 'La question a bien été supprimé'
        ]);
    }
}
