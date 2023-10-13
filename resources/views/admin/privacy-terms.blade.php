@extends('admin.layouts.app')

@section('content')
 <div id="layoutSidenav_content" class="bg-dark">
    
                <main class="" >
                    <div class="container-fluid px-4">
                      
                        <h3 class="mt-3 text-white page-ttl pb-3 mb-4">
                        @if($privacy->id==1)
                         Model Privacy Policy
                        @elseif($privacy->id==2)
                         Model Terms and conditions
                        @elseif($privacy->id==3)
                         Billing
                        @elseif($privacy->id==4)
                         Law Enforcement
                        @elseif($privacy->id==5)
                         Security Center
                        @elseif($privacy->id==6)
                         Customer Terms and conditions
                        @elseif($privacy->id==7)
                         Customer Privacy Policy
                        @endif </h3>
                       
                        <div class="row">
                             @if( Session::has('message')) 

                                  <?php echo Session::get('message') ?>


                                @endif
                                 <div class="col-sm-12 bg-light pt-4 pb-3 data-t">
                                  <form method="post" onsubmit="return addCategory()" id="addCategory" >
                                   @csrf
                            
                                      <input type="hidden"class="form-control" value="{{$privacy->id}}" name="id">
                                    
                                 
                                  <div class="form-group">
                                    <label class="control-label"> Description</label>
                                     <textarea class="form-control textarea" id="mytextarea" name="description">{{$privacy->content}}</textarea>
                                  </div>
                                 
                                    <button type="submit" class="btn btn-primary" id="addEmpJobsBtn">Update</button>
                                  
                            </form>
                           </div>
                        </div>
                    </div>
                </main>
            </div>
            @endsection
@section('script')
<script src="https:////cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>

<script type="text/javascript">
        
    CKEDITOR.replace( 'mytextarea');
    CKEDITOR.editorConfig = function( config ){

    }

     
</script>
<script type="text/javascript">
  
  
  function addCategory() {
        event.preventDefault();
    $('.alert-danger').remove();
        var data = new FormData($('#addCategory')[0]);
        //var img_val_id =$("#img_val_id").val();
         var description = CKEDITOR.instances['mytextarea'].getData();
         //var footer_description = CKEDITOR.instances['mytextarea2'].getData();
         data.append("description", description);
       //  data.append('footer_description',footer_description);
        $.ajax({
              url: "{{route('admin.update-privacy')}}",
              data: data,
              processData: false,
              contentType: false,
              type: 'POST',
             dataType:'json',
        beforeSend: function() {        
            $('#addbtn').prop('disabled' , true);
            $('#addbtn').text('Processing..');
          },
              success: function(result){
            $('#addbtn').prop('disabled' , false);
            $('#addbtn').text('Update');
            if(result.status == 1)
            {
            
                 //console.log(result.message);
              window.location.reload();
            }
            else
            {
               // $('#img_err').html(result.message);
              console.log(result.message);
              for (var err in result.message) {
            
              $("[name='" + err + "']").after("<div  class='label alert-danger'>" + result.message[err] + "</div>");
              }
            }
        }
        });
    return false;
  } 


</script>
@endsection
