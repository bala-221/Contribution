<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\FriendRequest;
use Illuminate\Support\Facades\Redirect;

class profilesController extends Controller
{



    public function show(User $user){

        //$user = \App\User::findorFail($id);

        return view ('profile.show', compact('user'));
    }





    //if add fellow button is clicked
    public function sendRequest(User $user) {

         $userLoggedIn = auth()->user();
         //$userProfile = \App\User::findorFail($userId);
        if (isset($_GET['sendRequest'])){

            $userFrom = $userLoggedIn->userName;
            $userTo = $user->userName;

            $friendEntry = new FriendRequest;

            $friendEntry->user_from = $userFrom;
            $friendEntry ->user_to = $userTo;
            $friendEntry ->save();

            return view('profile.show', compact('user'));
        }



        if (isset($_GET['respondRequest'])){

            $userTo = $userLoggedIn->userName;
            $userFrom = $user->userName;

            $query = FriendRequest::where('user_to', $userTo)
                                    ->where('user_from', $userFrom)->get();


            return view('profile.request', compact('query'));



        }


        if (isset($_GET['removeFriend'])){

            $loggedInUser = $userLoggedIn->userName;
            $otherUser = $user->userName;

            $user_to_remove_comma = $otherUser.",";
            $remove_friend_query = User::where('userName', $loggedInUser)
            ->update(['friendArray' => \DB::raw("REPLACE(friendArray, '".$user_to_remove_comma."', '')")]);


            $user_to_remove_commaTwo = $loggedInUser.",";
            $remove_friend_query = User::where('userName',  $otherUser )
            ->update(['friendArray' => \DB::raw("REPLACE(friendArray, '".$user_to_remove_commaTwo."', '')")]);


            $userLoggedIn->friendArray = str_replace($user_to_remove_comma,'', $userLoggedIn->friendArray); //avoid going to DB again but updating the auth()

           return view('profile.show', compact('user'));


        }






    }



// This is activated by the notifcation button of the header
public function decision(){

            $userLoggedIn = auth()->user();
            $query = FriendRequest::where('user_to', $userLoggedIn->userName)->get();
                    return view('profile.request', compact('query'));

    }



public function acceptOrReject($user_from){

        $userLoggedIn = auth()->user();

        $user_fromx = preg_replace('/\s+/', '_', $user_from); //replacing spaces with underscore we need this for the below if statements
        $user_to = $userLoggedIn->userName;

            if(isset($_POST['accept_request'.$user_fromx])) {

                        $add_friend_query = User::where('userName', $userLoggedIn->userName)
                        ->update(['friendArray' => \DB::raw("CONCAT(friendArray, '".$user_from."', ',')")]);

                        $add_friend_query = User::where('userName', $user_from)
                        ->update(['friendArray' => \DB::raw("CONCAT(friendArray, '".$user_to."', ',')")]);


                        //$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");

                        $delete_query =  FriendRequest::where('user_to', $userLoggedIn->userName)
                                                        ->where('user_from', $user_from)->delete();

                        //echo "You are now friends!";

                        $user = User::where('userName', $user_from)->first(); //just so I can use compacts

                        $mesage = "You have succesfully added ".$user->getFirstAndLastName() . " as an afffiliate";

                        $userLoggedIn->friendArray = $userLoggedIn->friendArray. $user_from. ","; //avoid going to DB again but updating the auth()


                         return view('profile.show')
                         ->with('user', $user)
                         ->with('message', $mesage);
            }


            if(isset($_POST['ignore_request' . $user_fromx ])) {

                        //$delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLoggedIn' AND user_from='$user_from'");

                        $delete_query =  FriendRequest::where('user_to', $userLoggedIn->userName)
                                                        ->where('user_from', $user_from)->delete();
                        //echo "Request ignored!";

                        $user = User::where('userName', $user_from)->first(); //just so I can use compacts

                        return view('profile.show', compact('user'));
            }




}







}
