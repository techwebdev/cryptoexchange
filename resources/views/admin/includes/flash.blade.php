@if(Session::has('success'))
<div class="alert alert-success alert-block" style="background-color: #2ed8b6;border-color: #2ed8b6;color: #ffffff;">
	<button type="button" class="close" data-dismiss="alert" style="color: white;">×</button>
	{!! Session::get('success') !!}
</div>
@endif

@if(Session::has('error'))
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>
	{!! Session::get('error') !!}
</div>
@endif