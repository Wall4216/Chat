<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\MessageFormRequest;
use App\Models\Message;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(): Application
    {
        auth()->loginUsingId(1);

        return view('chat');
    }

    public function message()
    {
        return Message::query()
            ->with('user')
            ->get();
    }
    public function send(MessageFormRequest $request)
    {
        $message = $request->user()
            ->messages()
            ->create($request->validate());
        broadcast(new MessageSent($request->user(), $message));
        return $message;
    }
}
