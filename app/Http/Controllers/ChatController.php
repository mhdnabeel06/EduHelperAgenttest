<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agents\EduHelperAgent;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = $request->input('message');


        $agent = new EduHelperAgent();
        $reply = $agent->reply($message);


        $history = session()->get('edu_history', []);
        $history[] = ['sender' => 'user', 'message' => $message];
        $history[] = ['sender' => 'agent', 'message' => $reply];
        session()->put('edu_history', $history);

        return response()->json([
            'reply' => $reply,
            'history' => $history,
        ]);
    }


    public function history()
    {
        return response()->json(session()->get('edu_history', []));
    }

    
    public function clear(Request $request)
    {
        session()->forget('edu_history');
        return response()->json(['ok' => true]);
    }
}
