<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class NotesController extends Controller
{


    public function store(Request $request)
    {
        $data = $request->validate([
            'comment' => 'required|string',
        ], [
            'comment.required' => 'Bitte geben Sie eine Notiz ein.',
            'comment.string' => 'Bitte geben Sie eine Notiz ein.',
        ]);

        $request->user()->currentTeam->activities()->create([
            'user_id' => $request->user()->id,
            'type' => Activity::COMMENTED,
            'comment' => $data['comment'],
            'subject' => '',
        ]);

        return to_route('hub.dashboard');
    }

}
