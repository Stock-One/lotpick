@extends('layouts.app')

@section('content')
<style>
.active{
	background-color:#d8341a;
	color: #ffffff;
}
</style>
<div class="container">
    <div class="row">
	 <div class="col-md-10 col-md-offset-1">
 <div class="pick" style="background-color:#ffffff;padding-bottom:15px;">
	 <div class="lat_location" style="background-color:#95959b;margin-bottom:20px;">
        <!-- Left Side Of Navbar -->
				<input type="hidden" class="form-control" name="token" id="token" value="{{csrf_token()}}" >
                <ul class="nav navbar-nav">
                   <li><a href="{{ url('/lat_location') }}">Scan To Pick</a></li>
                   <li class="active"><a href="{{ url('/pick_list') }}">Pick List</a></li>
                </ul>
            </div>


        <div class="col-md-12 ">
            <div class="panel panel-default" >
			<div style="background-color:#69c07a;color:#006400;padding-top:5px;padding-bottom:5px;text-align:center;display: none;" id="up_msg"> </div>
                <div class="panel-heading" style="background-color:#A9A9A9;color:#006400">Lot & Locations & GP  </div>

				{{Session::get('message')}}
			<div id="tab">
                 <table class="table table-bordered ">
    <thead>
				  <tr>
				    <th> S.No </th>
				    <th> Lot Id </th>
				    <th> GP </th>
				    <th> Location  </th>
				    <th> PICK  </th>
				  </tr>
				     </thead>
    <tbody>
				  @foreach($lotdata as $key=>$value)
				  <tr>
				    <td> {{$key+1}} </td>
				    <td> {{$value->lat_id}} </td>
				    <td> {{$value->gp_id}} </td>
				    <td> {{$value->location_id}} </td>
					@if($value->status =='1')
						  <td><div  onclick="update_pickup_status('{{$value->lat_id}}')" class="btn btn-primary" style="display: block; text-align: center; margin: auto;">Pick Up</div></td>
					@else
						  <td><div class="btn btn-danger">Picked</div></td>
					@endif

				  </tr>
				  @endforeach
				</tbody>
  </table>
  </div>
            </div>
        </div>
    </div>
	</div>
    </div>
</div>


<script type="text/javascript">
$("#lot_id").keypress(function(e) {
    if(e.which == 13) {
		var route="<?php echo url('update_lot_pickup/'); ?>";
      //var route="http://localhost:8000/update_lot_pickup";
	 var token=$("#token").val();
	 var lot_id=$("#lot_id").val();
	  var lotid =lot_id.split(" ").join("_");
	 if(lot_id !=''&& lot_id !='null')
		 {
			   $.ajax({
				type:"POST",
				url:route,
				headers:{'X-CSRF-TOKEN':token},
				data:{lot_id:lotid},
				dataType:'json',
				success: function(result){

					if(result.status=='1')
					{
						$("#tab").load('<?php echo url('update_pick_lot'); ?>');
					    $("#lot_id").val('');
					}
					else{
						alert(result.message);
					}

				  }
				});
		 }
		 else{
			 alert("Please enter lot number");
		 }
    }
	else{
		//console.log(e.which);
	}
});
function update_pickup_status(lot_id)
{
   console.log(lot_id);
    var lotid =lot_id.split(" ").join("_");
	var route="<?php echo url('update_lot_pickup/'); ?>";
	//var route="http://localhost:8000/update_lot_pickup";
	 var token=$("#token").val();
	 if(lotid !=''&& lotid !='null')
		 {
			   $.ajax({
				type:"POST",
				url:route,
				headers:{'X-CSRF-TOKEN':token},
				data:{lot_id:lotid},
				dataType:'json',
				success: function(result){
					$("#up_msg").show();
					$("#up_msg").html(result.message);

					$("#tab").load('<?php echo url('update_pick_lot'); ?>');
					 setTimeout(function(){
                         $("#up_msg").html('');
						$( "#up_msg" ).hide( "slow", function() {
						  });
					 }, 2000);

				  }
				});
		 }
		 else{
			 alert("Please enter lot number");
		 }
}
$(document ).ready(function() {
	$("#up_msg").hide();
// var auto_refresh=setInterval(
 // function(){

	// $("#tab").load('<?php echo url('update_pick'); ?>');

 // },100);
});
</script>
@endsection
