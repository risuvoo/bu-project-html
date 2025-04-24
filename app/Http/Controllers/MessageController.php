<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Message;
use App\Models\Setting;
use App\Events\LiveChat;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function load_chat_box($id){
        $buyer = Auth::guard('web')->user();

        $provider = User::find($id);

        $messages =  Message::with('service')->where(['buyer_id' => $buyer->id, 'provider_id' => $id])->get();

        Message::where(['buyer_id' => $buyer->id, 'provider_id' => $id])->update(['buyer_read_msg' => 1]);

        return view('chat_box')->with(['messages' => $messages, 'buyer' => $buyer, 'provider' => $provider]);

    }

    public function send_message_to_provider(Request $request){

        $buyer = Auth::guard('web')->user();

        $message = new Message();
        $message->provider_id = $request->provider_id;
        $message->buyer_id = $buyer->id;
        $message->message = $request->message;
        $message->provider_read_msg = 0;
        $message->buyer_read_msg = 1;
        $message->send_by = 'buyer';
        $message->service_id = $request->service_id ? $request->service_id : 0;
        $message->save();

        $provider = User::find($request->provider_id);

        $messages =  Message::with('service')->where(['provider_id' => $provider->id, 'buyer_id' => $buyer->id])->get();

        $data = array([
            'buyer_id' => $buyer->id,
            'message_id' => $message->id
        ]);

        event(new LiveChat($provider, $data));

        return view('chat_box')->with(['messages' => $messages, 'provider' => $provider, 'buyer' => $buyer]);


    }
}
