@include('includes.header')

<header>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</header>

<div class="container">

    <div class="row">

        <div class="col-md-12">

            {{-- for flash message --}}
            @if(Session::has('message'))
            <div class="alert alert-{{ Session::get('message-type') }} alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <i class="glyphicon glyphicon-{{ Session::get('message-type') == 'success' ? 'ok' : 'remove'}}"></i>
                {{ Session::get('message') }}
            </div>
            @endif

            <p> We are back and strong</p>

        </div>



        </>

    </div>

</div>


@include('includes.footer')


</html>