@include('includes.header')
<header>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</header>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Accept Adashi Request') }}</div>

                <div class="card-body">


                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Members</th>
                                <th scope="col">Monthly value</th>
                                <th scope="col">Work Place</th>
                                <th scope="col">Position</th>
                                <th scope="col">Status</th>


                            </tr>
                        </thead>
                        <tbody>


                            <?php $j = 1; ?>
                            @foreach ($members as $member)
                            <tr id="tableRow{{$member->id}}">
                                <th scope="row">{{$j}}</th>
                                <td class="firstLastName">{{$member->getFirstAndLastName()}}</td>
                                <td class="monthlyValue">{{$member->lastName}}</td>
                                <td class="workPlace">{{$member->workPlace}}</td>
                                <td class="jobTitle">{{$member->jobTitle}}</td>
                                <?php   echo ($statuses[$j-1] == 0)? "<td class='status' >Pending</td>": "<td class='status'>Accepted</td>"  ?>
                                <?php $j = $j + 1; ?>

                            </tr>

                            @endforeach


                            </tr>
                        </tbody>
                    </table>




                    <button class="btn btn-success" id="accept_button"> Accept </button>

                    <button class="btn btn-danger" href="#" id="reject_button"> Reject</button>



                </div>
            </div>
        </div>
    </div>
</div>



{{-- The java script --}}

<script type="text/javascript">
    $(document).ready(function(){
        

        $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });


        $("#accept_button").click(function (e) { 
            e.preventDefault();              
           


            $.ajax({
                type: 'POST',
                url: "{{url('/contri/request/accept')}}",               

                success: function (result) {                               

                    var tableRowId = "tableRow"+ result.userId;                  
                      $("#" + tableRowId).find('.status').html( 'Accepted');

                


            }

    });
});

});


</script>


@include('includes.footer')


</html>