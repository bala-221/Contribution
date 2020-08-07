<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'userName','gender', 'birthday', 'workPlace', 'jobTitle','salaryRange','email', 'password',
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



    public function didSendRequest(){

        $userFrom = auth()->user()->userName;

        $num = \App\FriendRequest::where('user_to', $this->userName)
                                   ->where('user_from', $userFrom)->get()->count();

        if($num > 0){

            return true;

        }else{

            return false;
        }

    }



    public function didReceiveRequest(){

        $userTo = auth()->user()->userName;

        $num = \App\FriendRequest::where('user_to', $userTo)
                                   ->where('user_from', $this->userName)->get()->count();

        if($num > 0){

            return true;

        }else{

            return false;
        }

    }


    public function isFriend(){

        $userLoggedIn = auth()->user();

        $username_to_check = $this->userName;

        $usernameComma = "," . $username_to_check . ",";


        if((strpos($userLoggedIn->friendArray, $usernameComma) !== false) || ($username_to_check ==  $userLoggedIn->userName)) {



			return true;
		}
		else {



			return false;
		}

    }



    public function getFirstAndLastName(){

        $userName = $this->userName;
        //$user = User::where('userName', $userName)->get();
        $firtsLastName = $this->firstName." ". $this->lastName;

        return $firtsLastName;
    }



    public function getNumberOfFriendRequests(){

        $userName = auth()->user()->userName;
        return FriendRequest::where('user_to', $userName)->count();

    }


    public function getAffiliates(){
        $friendArray = $this->friendArray;

        $user_array_explode = explode(",", $friendArray);

        $user_array_explode = array_filter($user_array_explode, 'strlen');

        return $query = User::whereIn('userName', $user_array_explode)->get();


    }

    public function contributions(){

        return $this->hasMany(Contribution::class);
    }




}
