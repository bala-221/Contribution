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

  <script src="{{ asset('js/bootstrap.min.js') }}"> </script>

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

          <a class="nav-link" href="\login">

            <i class="fa fa-sign-in fa-2x" data-toggle="tooltip" title="login"> </i>

            <span class="sr-only">(current)</span>
          </a>


        </li>


        <li class="nav-item">
          <a class="nav-link" href="{{route('register')}}">
            <i class="fa fa-user-plus fa-2x"> </i>
          </a>
        </li>


        <li class="nav-item">



        </li>


        <li class="nav-item">
          <a class="nav-link notification" href="">

            <i class="fa fa-users fa-2x"> </i>

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

    </div>
  </nav>