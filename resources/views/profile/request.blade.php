
@include('includes.header')

@php
    use \APP\Http\Controllers\profilesController;
    use App\FriendRequest;
    use APP\User;

@endphp





<div class="container">
    <div class="row justify-content-right">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header"> Friend Request</div>

                    <div class="card-body">




                @if ($query->isempty())
                    <p> You have no affliate request at the moment </p>


                @else

                   @foreach ($query as $row)
                                <?php
                                $user_from = $row->user_from;
                                $userFromObj = User::where('userName', $user_from)->first();
                                ?>


                                <p class="mb-3">

                                <?php echo  $userFromObj->getFirstAndLastName() . " sent you a friend request!" ;?>

                                </p>


                                            <form action="/profile/accept_reject/{{$user_from}}" method="POST">
                                                @csrf
                                                <input class = "btn btn-success" type="submit" name="accept_request{{$user_from}}" id="accept_button" value="Accept">
                                                <input class = "btn btn-danger" type="submit"  name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="Ignore">


                                            </form>



                     @endforeach

                @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>











   </body>

@include('includes.footer')


 </html>
























