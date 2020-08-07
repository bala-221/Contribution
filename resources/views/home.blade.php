@include('includes.header')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card">

                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}

                    </div>
                    @endif

                    You are logged in {{auth()->user()->userName}}



                </div>

            </div>
        </div>


        {{-- search for other users --}}
        <div class="col-md-4">

            <div class="card">

                <div class="card-header">Find friends</div>

                <div class="card-body">

                    @if(isset($users))

                    @foreach ($users as $user)

                    <a href="/profile/{{$user->id}}"> {{$user->firstName}} </a> <br>

                    @endforeach

                    @endif

                </div>

            </div>
        </div>



        {{--display friend lists --}}
        <div class="col-md-4">

            <div class="card">

                <div class="card-header">Affiliates</div>

                <div class="card-body">

                    <?php  $affiliates= auth()->user()->getAffiliates() ?>

                    @if(isset($affiliates))

                    @foreach ($affiliates as $affiliate)

                    <a href="/profile/{{$affiliate->id}}"> {{$affiliate->firstName." ". $affiliate->lastName}} </a> <br>

                    @endforeach

                    @endif

                </div>

            </div>
        </div>







    </div>
</div>


</body>

@include('includes.footer')


</html>