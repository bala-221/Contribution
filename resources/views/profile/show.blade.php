



@php
    use \APP\Http\Controllers\profilesController;
    use App\FriendRequest;
    use APP\User;

@endphp

@include('includes.header')


<div class="container">
    <div class="row justify-content-right">
        <div class="col-sm-4">

            <div class="card">

                <div class="card-header">{{$user->firstName}}</div>

                <div class="card-body">

                    <p>Is a {{$user->jobTitle}} at {{$user->workPlace}}</p>

                    <?php $userLoggedIn = auth()->user(); ?>

                    <form action="/profile/sendRequest/{{$user->id}}" method="GET">

                        {{-- if user account is closed? just redirect to user_closed page --}}


                        @if ($user != $userLoggedIn)


                             @if ($user->didSendRequest())

                              <input class="btn btn-secondary" type="" name='' value="Request already sent" >


                              @elseif($user->didReceiveRequest())

                               <input class= "btn btn-success" type="submit" name='respondRequest' value="Respond to request" >


                              @elseif ($user->isFriend())

                               <input class="btn btn-danger" type="button"  value="Remove Affiliate" data-toggle="modal" data-target="#exampleModal" >


                              @else


                                <input class='btn btn-primary' type="submit" name='sendRequest' value="Add Affiliate" />

                            @endif


                        @endif

                    {{-- <input class='btn btn-danger' type="submit" name= 'IgnoreRequest' value="Ignore Request" /> --}}



                {{-- Modal --}}
                 <!-- Button trigger modal -->
                    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Launch demo modal
                    </button> --}}

                    <!-- Modal -->
                    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered " role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Remove Friend</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cancel">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                              Are you sure you want to remove {{$user->firstName." ". $user->lastName}} as an afflilite?
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" name ='removeFriend' class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                        </div>
                    </div>




                </form>




                </div>

            </div>


            {{-- Sucess message  --}}

           @if (isset($message))
                <div class="col-sm-12">
                    <div class="alert  alert-danger alert-dismissible fade show" role="alert">
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif






        </div>
    </div>
</div>

    </body>

    @include('includes.footer')


    </html>

