<?php

namespace App\Http\Controllers\chat;
use App\Events\NewMessage;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\MessaageResource;
use App\Models\Message;
use App\User;
use App\Http\Controllers\Controller;
class ContactListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getContacts(){

        $contacts = User::getContacts();
        return response(
            UserResource::collection($contacts),200);
    }

    public function getMessagesFor($contactID){

        $messages = Message::getMessagesBetweenUser($contactID);
        return response(
           MessaageResource::collection($messages),200);
    }

    public function sendNewMessagesFor(Request $request){
        $response = Message::createNewMessageFor($request);
        broadcast(new NewMessage($response));
        return response()->json($response,200);
    }


}
