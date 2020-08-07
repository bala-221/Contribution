@include('includes.header')
<header>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</header>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Create new contribution') }}</div>

                <div class="card-body">


                    {{-- added here  --}}
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    {{-- Added --}}


                    <form id="create" action="javascript:void(0)" method="post"> @csrf </form>
                    <form id="searchForm" action="javascript:void(0)" method="post"> @csrf </form>

                    <div class="form-group row">

                        <label for="title" class="col-md-4 col-form-label text-md-left">{{ __('Title') }}</label>

                        <div class="col-md-4">

                            <input id="title" type="text" form="create"
                                class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}" autocomplete="title" autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row">

                        <label for="valContri"
                            class="col-md-4 col-form-label text-md-left">{{ __('Monthly value') }}</label>

                        <div class="col-md-4">

                            <input id="valContri" type="text" form="create"
                                class="form-control @error('valContri') is-invalid @enderror" name="valContri"
                                value="{{ old('valContri') }}" required autocomplete="transaction-amount">

                            @error('valContri')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>




                    <div class="form-group row">

                        <label for="dateContri"
                            class="col-md-4 col-form-label text-md-left">{{ __('Proposed start date') }}</label>

                        <div class="col-md-4">

                            <input id="dateContri" type="date" form="create"
                                class="form-control @error('dateContri') is-invalid @enderror" name="dateContri"
                                value="{{ old('dateContri') }}" required autocomplete="date">

                            @error('dateContri')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>




                    {{-- Search members of adashi --}}


                    <input class="form-control mr-sm-2 mb-2" type="search" name="search" id="search" form="searchForm"
                        placeholder="Search Affliate" value="{{ old('search') }}" aria-label="Search"> <br>



                    <button class="btn btn-outline-success my-2 my-sm-2" id="ajaxSubmitSearch"> Search </button>
                    <br>



                    {{-- for displaying search results --}}
                    <div id="searchResults">
                    </div>


                    <div id="selectedAffs" style="display:none">
                        <h3>Selected Affiliates</h3>
                    </div>

                    <div id="inputElementsForAffs" style="display:none">
                    </div>




                    <div id='modalAffliates'></div>


                    <button class="btn btn-success" id="createButton" type="button" form="create">Create</button>

                    <button class="btn btn-danger" type="reset">Clear</button>



                </div>
            </div>
        </div>
    </div>
</div>






{{-- <div id="alert_box" class="alert alert-success" style="display:none"> --}}

{{-- modal for user already added --}}
<div class="modal fade" tabindex="-1" role="dialog" id="userAlreadyAdded">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"> User already added. Please add another user </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <div class="modal-body"> --}}
            {{-- </div> --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




</div>




</body>





{{-- The java script --}}

<script type="text/javascript">
    $(document).ready(function(){
       
        $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });


        $("#ajaxSubmitSearch").click(function (e) { // for searh menu
            e.preventDefault();

            $('input').removeClass('border');
            $('input').removeClass('border-danger');
            $('.errorMessage.text-danger').remove();   

            var search =  document.getElementById("search").value;


            $.ajax({
                type: 'POST',
                url: "{{url('searchContri')}}",
                data: {search: search },

                success: function (result) {


                        document.getElementById('searchResults').innerHTML = result.htmlLinks;
                        document.getElementById('modalAffliates').innerHTML = result.htmlModal;





                    //if add affiliate is clicked
                           $("[id^=buttonModal]").click(function(e){
                                    var userId = event.target.id.slice(11); //11 because we have eleven characters in buttonModal
                                   

                            //getting the present User from the result.arrayUsers array from ajax call
                                    var presentUser = result.arrayUsers.filter(function(user){
                                        return user.userId == userId;
                                    });

                             var userFirstName = presentUser[0].firstName;
                             var userLastName = presentUser[0].lastName;
                             var userWorkPlace = presentUser[0].workPlace;
                             var id =  presentUser[0].userId;
                             var localId = "selectedAffs"+id;


                             if(!($('#'+ localId).length))   { //if it does'nt exist we add

                             var $html2 = $('<input/>', {
                                    'type': 'hidden',
                                    'name':'aff' + id,
                                    'value':'aff' + id,
                                    'id' :  'selectedAffsInput' + id,
                                    'form': 'create'
                                })

                                $('#inputElementsForAffs').append($html2);

                            //  var html2 = "<input type = 'hidden' id =" + "selectedAffsInput"+id + "name = 'selectedWith' value = 'aff' >";


                             var miniHtml = "<div id = " + localId  + ">" + "<p class= 'd-inline'>" + userFirstName + " " + userLastName + " from" + " "+ userWorkPlace+ "</p>" +
                             "<button class = 'btn d-inline' id= " + "remove" + id + " ><i style = 'color:red !important' class='fas fa-user-minus fa-lg'></i> </button> <br>  </div>";

                             $('#selectedAffs').append(miniHtml);
                             $('#selectedAffs').show();



                            //  $('#inputElementsForAffs').show();

                             }else{ // we show error modal: already added pls


                             $('[id^=affliateDetails]').modal('hide');
                             $('#userAlreadyAdded').modal('show');

                             }



                             //now action on remove button
                             $('[id^=remove]').click(function(){
                                var removeId = this.id.slice(6);

                                //remove item
                                $('#selectedAffs'+removeId).remove();

                                //  Remember if you click remove also remove the hidden inputs
                                $('#selectedAffsInput'+ removeId).remove();
                                

                                                         
                             });






                            });





                    //$('#alert_box').html(result.users);
                    //$('#alert_box').show();







                },
///////////////////////////////////////////////////////////

error: function (err) {

        if (err.status == 422) { // when status code is 422, it's a validation issue
            console.log(err.responseJSON);    
                        
            
                // you can loop through the errors object and show it to the user
                //console.warn(err.responseJSON.errors);
                // display errors on each form field
                $.each(err.responseJSON.errors, function (i, error) {        
                    var domName = document.getElementById(i); 
                
                //scroll to the error message
                domName.scrollIntoView({behavior:'smooth'});

                //remove all previous errorr  
                                            
                    domName.insertAdjacentHTML('afterend', '<span class= "errorMessage text-danger"> <strong>' + error[0] + '</strong> </span>');

                    //highlighting the text box

                    domName.classList.add('border', 'border-danger');

                    
                });
        }

}




                ///////////////////////////////////////////////////






                
            });


        });



        //ajax for submitting the form
        
        $("#createButton").click(function(e){
            e.preventDefault();

            // if(!$("#createButton").hasClass("submitted")){
                
            //        $("#createButton").addClass("submitted");
            //        $("#createButton").submit();

                        $('input').removeClass('border');
                        $('input').removeClass('border-danger');
                        $('.errorMessage.text-danger').remove();             
                
           

                            var title = $("input[name='title']").val();
                            var valContri = $("input[name='valContri']").val();
                            var dateContri = $("input[name='dateContri']").val();
                            //var _token = $("input[name='_token']").val();

                
                
                            var arrayAffiliates = Array();
                            var i = 0;

                            $('input[name^="aff"]').each(function() {
                             arrayAffiliates[i] = $(this).val();
                              i++;                   
                              });


               
              
                $.ajax({
                url: "{{url('contri')}}",
                type:'POST',
                data: { title:title, valContri:valContri, dateContri:dateContri, 
                    arrayAffiliates: arrayAffiliates},

                success: function(data) {

                     window.location = data.url;
                    
                   
                },

                error: function (err) {

                    if (err.status == 422) { // when status code is 422, it's a validation issue
                           // console.log(err.responseJSON); 
                           
                                      
                           
                            // you can loop through the errors object and show it to the user
                            //console.warn(err.responseJSON.errors);
                            // display errors on each form field
                            $.each(err.responseJSON.errors, function (i, error) {
                                //var $el = $(document).find('[name="'+i+'"]');  

                                

                                if (i === 'arrayAffiliates'){

                               

                                $('#ajaxSubmitSearch').after('<span class = "errorMessage text-danger"> <strong>' + error[0] + '</strong> </span>');
                                 

                                }else{                              
                                
                                
                                var domName = document.getElementById(i);  
                               

                               //scroll to the error message
                               domName.scrollIntoView({behavior:'smooth'});

                               //remove all previous errorr   
                              
                           
                                                              
                                domName.insertAdjacentHTML('afterend', '<span class= "errorMessage text-danger"> <strong>' + error[0] + '</strong> </span>');

                                //highlighting the text box

                                domName.classList.add('border', 'border-danger');

                                }


                            });
                    }


                }
          
       
        }); 
       
   // }   

    });

});



    

</script>

@include('includes.footer')


</html>