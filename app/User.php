<?php

namespace App;

use App\Models\Message;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function getContacts(){

        $contacts = User::where('id','!=',auth()->user()->id)->get();
        $unreadIDs = Message::select(\DB::raw('messages.from as sender_id, count(messages.from) as messages_count'))
                     ->where('to',auth()->id())
                     ->where('read',false)
                     ->groupBy('from')->get();
        $contacts = $contacts->map(function ($contact) use ($unreadIDs) {
            $unreadContact = $unreadIDs->where('sender_id',$contact->id)->first();
            $contact->unread = $unreadContact ? $unreadContact->messages_count:0;
            return $contact;
        });
        return $contacts;
    }
}
