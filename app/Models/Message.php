<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Message extends Model
{
    protected $fillable =['from', 'to', 'text'];
    public static function getMessagesBetweenUser($contactID){
        //mark all received messages as read
        Message::where('from',$contactID)->where('to',auth()->id())->update(['read'=>true]);

        return Message::where(function ($q) use ($contactID){
            $q->where('to',$contactID)->where('from',auth()->user()->id);
        })->orWhere(function ($q) use ($contactID){
            $q->where('from',$contactID)->where('to',auth()->user()->id);
        })->get();
    }

    public static function createNewMessageFor(Request $request){
        return Message::create([
            'from'=>auth()->user()->id,
            'to'=>$request->contact_id,
            'text'=>trim(htmlspecialchars($request->text))
        ]);
    }

    public function fromContact(){
        return $this->hasOne(User::class, 'id','from');
    }
}
