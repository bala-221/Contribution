<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\ContriRequest;

use \App\Notification;
use \App\User;

class ContributionController extends Controller
{


    public function create()
    {


        return view('contri.create');
    }


    public function search(Request $request)
    {

        $validatedData = $request->validate(
            [
                'search' => 'required',

            ]
        );

        $search = request('search');

        //validate the search entry
        $userName = auth()->user()->userName;

        $users = \App\User::where('userName', 'like', '%' . $search . '%')
            ->where('userName', '!=', $userName)->get();

        $htmlLinks = '';
        $htmlModal = '';
        $arrayUsers = array();
        $count = 0;


        foreach ($users as $user) {

            $htmlLinks =  $htmlLinks . "<a href='#affliateDetails$user->id'" . "data-toggle='modal'" . ">" . $user->firstName . "</a> <br>";

            //modal for that
            $htmlModal = $htmlModal . "<div class='modal fade' id='affliateDetails$user->id' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
        <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLongTitle'>User Profile</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                <span aria-hidden='true'>&times;</span>
            </button>
            </div>
            <div class='modal-body'>"
                . $user->getFirstAndLastName() . " works at " . $user->workPlace .  "<br>
            <p class='text-danger'> Your are advised to add only affliates you know.</p>
            </div>
            <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
            <button  id='buttonModal$user->id' class='btn btn-primary'>Add Affliate</button>
            </div>
        </div>
        </div>
    </div>";

            $firstName = $user->firstName;
            $lastName = $user->lastName;
            $workPlace = $user->workPlace;
            $userId = $user->id;

            $arrayUsers[$count] = array('userId' => $userId, 'firstName' => $firstName, 'lastName' => $lastName, 'workPlace' => $workPlace);
            $count++;



            //$dat=$dat.$user->firstName;
            //$dat=$dat.$user->lastName;
        }


        //return response($html);
        return response()->json([
            'success' => true,
            'htmlLinks' =>   $htmlLinks,
            'htmlModal' => $htmlModal,
            'arrayUsers' =>   $arrayUsers,
        ]);
    }






    public function store(Request $request)

    {

        $validatedData = $request->validate(
            [
                'title' => 'required',
                'dateContri' => 'required',
                'valContri' => 'required|numeric|between:25000,200000',
                'arrayAffiliates' => 'required|array|min:2',

            ],
            [

                'title.required' => 'Title needs to be entered',
                'valContri.required' => 'Monthly contribution is required',
                'valContri.between' => 'Contribution must be between N25,000 and N150,000',
                'valContri.numeric' => 'Please enter a number',
                'dateContri.required' => 'Please enter a proposed start data',
                'arrayAffiliates.required' => 'Please search select at least two Affiliates',
                'arrayAffiliates.min' => 'Please search select at least two Affiliates'





                //'arrayAffiliates' => 'required|array|min:2'


            ]
        );


        //add each affiliates as a request in table
        $arrayAffiliates = $request->arrayAffiliates;


        foreach ($arrayAffiliates as $item) {
            $sendTo = $item[-1];
            $contriRequest = new ContriRequest;
            $notification =  new Notification;
            $userFromId = auth()->user()->id;
            $userFirstLastName = auth()->user()->getFirstAndLastName();

            //check for duplications
            $check = ContriRequest::where('userFromId', $userFromId)
                ->where('userToId', $sendTo)->count();

            if (($check == 0)) {
                $contriRequest->userFromId = $userFromId;
                $contriRequest->userToId = $sendTo;
                $contriRequest->contri_value = $request->valContri;
                $contriRequest->start_date = $request->dateContri;
                $contriRequest->status = 0;
                $contriRequest->save();

                $requestId = $contriRequest->id;



                //create notification

                $notification->userFromId = $userFromId;
                $notification->userToId  =  $sendTo;
                $notification->message =   $userFirstLastName . " sent you a contribution request";
                $notification->link = "/contri/request/" . $requestId;
                $notification->opened  = 0;
                $notification->viewed = 0;
                $notification->save();
            }
        }



        $request->session()->flash('message', 'Task was successful!');
        $request->session()->flash('message-type', 'success');



        return response()->json([
            'success' => 'Form is successfully submitted!',
            'url' => url('/contri/adashiRequest'),
        ]);
    }




    public function requestView()
    {

        return view('contri.showRequest');
    }


    public function requestDashBoard($requestId)
    {

        $query =  ContriRequest::find($requestId);

        $userFromId = $query->userFromId;

        $queryAllMembers =  ContriRequest::where('userFromId', $userFromId)->get();


        $statuses = array(1); //by default creator will always be accepted 


        $members = array($userFromId);

        //getting the ids 

        foreach ($queryAllMembers as $member) {

            array_push($statuses, $member->status);

            array_push($members, $member->userToId);
        }





        $members = User::whereIn('id', $members)
            ->orderByRaw(\DB::raw("FIELD(id, " . implode(",", $members) . ")"))->get();



        return view('contri.requestView', compact('members', 'statuses'));
    }


    public function acceptRequest()
    {

        $userId = auth()->user()->id;
        ContriRequest::where('userToId', $userId)->update(['status' => 1]);

        return response()->json([
            'success' => true,
            'userId' => $userId,

        ]);
    }
}
