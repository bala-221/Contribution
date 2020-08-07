@php
use \App\Notification;
use App\FriendRequest;
use APP\User;



@endphp


@auth

<?php

    $user = auth()->user();
    $userId =auth()->user()->id;

    $num_requests = $user->getNumberOfFriendRequests();  

    $notification = new Notification;
     $num_notifications = $notification->getUnreadNumber($userId);
    ?>
@endauth




<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <link href="{{ asset('css/style.css') }}" rel="stylesheet">

  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  {{-- fontawesome --}}
  <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">


  {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> --}}



  <script src="{{ asset('js/app.js') }}"> </script>

  {{-- <script src="{{ asset('js/bootstrap.min.js') }}"> </script> --}}



  {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css"> --}}


  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

  {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
  </script> --}}

  {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
  </script> --}}

</head>

<body>



  <nav class="navbar navbar-expand-lg navbar-light py-3" style="background-color: #7DCEA0;">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">


        <li class="nav-item active">

          <a class="nav-link" href="/home">

            <i class="fa fa-home fa-2x"> </i>

            <span class="sr-only">(current)</span>
          </a>


        </li>






        <li class="nav-item dropdown" id="navbarDropdownNoti">

          <a class="nav-link dropdown" href="#" id='anchorNotifLink' aria-haspopup="true" aria-expanded="false"
            data-toggle='dropdown'>
            <i class="fa fa-bell fa-2x "> </i>
            <?php            
              if(isset($num_notifications)){
                if($num_notifications > 0){
               echo '<span class="badge" id="unread_notifications">' . $num_notifications . '</span>';
                }
              }
              ?>
          </a>

          <div class="dropdown-menu" id='dropDownNotifix' aria-labelledby="navbarDropdown">


          </div>

      




        </li>


        <li class="nav-item">

          <form action="{{route('logout')}}" method="POST">
            @csrf
            <button class="btn" data-toggle="tooltip" title="logout" type="submit">
              <i class="fas fa-sign-out-alt fa-2x"> </i>
            </button>
          </form>

        </li>


        <li class="nav-item">

          <form action="{{route('createContri')}}" method="get">

            <button class="btn btn-info mr-2" data-toggle="tooltip" title="create new contribution" type="submit">
              Create <br> Contribution
            </button>
          </form>

        </li>





        <li class="nav-item">
          <a class="nav-link " href="{{route('requestDecision')}}">

            <i class="fa fa-users fa-2x"> </i>
            <?php
              if($num_requests ?? '' > 0)
               echo '<span class="badge" id="unread_requests">' . $num_requests ?? '' . '</span>';
              ?>
          </a>
        </li>




        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Dropdown
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>


        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
      </ul>

      <form class="form-inline my-2 my-lg-0" action="/search" method="GET">

        <input class="form-control mr-sm-2" type="search" placeholder="Search Affliate" aria-label="Search">


        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>





  {{-- The java script --}}

  <script type="text/javascript">
    $(document).ready(function(){    
      
      //disable drop down for notification
      //$('#navbarDropdownNoti').removeAttr('data-toggle');

      $('#anchorNotifLink').click(function () {     

        //call ajax  
        

            $.ajax({
                type: 'get',
                url: "{{url('notification/dropDown')}}",
               

                success: function (result) {                
              
                  document.getElementById('dropDownNotifix').innerHTML = result.htmlLinks;  
                   
                  $('#anchorNotifLink').attr('data-toggle', 'dropdown');                   
                             
                   //$('#navbarDropdownNoti #dropDownNotifix').addClass('show');                 

                        //document.getElementById('searchResults').innerHTML = result.htmlLinks;
                        //document.getElementById('modalAffliates').innerHTML = result.htmlModal;
                        
                        // $('#anchorNotifLink').click(function () { 

                        //   $('#navbarDropdownNoti #dropDownNotifix').addClass('show'); 

                        // });





               },
           });

        


        //display the results in ajax


        //results are also links

        //each link goes to adashi request dashboard

        
        
       



     });

});

  </script>