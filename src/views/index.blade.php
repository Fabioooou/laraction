@extends('laraction::layout.app')
@section('content')
<div class="content-header">
	<div class="container">
			<div class="row">
				<div class="col-md-10">
					<h2>Create
						<small></small>
					</h2>
				</div>
			</div>
	</div>
</div>
<div class="container" style="margin-top: 50px;">
	<form id="frmSubSystem" action="/laraction/step2" method="POST" style="display:none">
		@csrf
		<div class="row">
			<div class="col-md-12">
				
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<label class="input-group-text" for="inputSubSystem">Sub System</label>
					</div>
					<input type="text" class="form-control" name="subsystem" id="inputSubSystem" placeholder="ex: Admin" value="{{old('subsystem')}}">

					<div class="input-group-prepend">
						<label class="input-group-text" for="inputDomain">Domain</label>
					</div>
					<input type="text" class="form-control" name="domain" id="inputDomain" placeholder="ex: Catalog" value="{{old('domain')}}">

					<div class="input-group-prepend">
						<label class="input-group-text" for="inputEntity">Entity</label>
					</div>
					<select name="entity" class="custom-select" id="inputEntity">
						@foreach($tables as $name => $table)
						<option value="{{ucfirst(Str::singular($name))}}">{{ucfirst(Str::singular($name))}}</option>
						@endforeach
					</select>
				</div>
			
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 text">
				<input class="btn btn-outline-secondary" type="submit" name="" value="Next >>">
			</div>
		</div>

	</form>
</div>
@endsection

@section('script')
<script type="text/javascript">
$('#frmSubSystem').fadeIn(800);
	$('#frmSubSystem').submit(function(e){
		$('#frmSubSystem').fadeOut(200);

		subsystem = $('#inputSubSystem').val().toLowerCase();
		domain = $('#inputDomain').val().toLowerCase();
		entity = $('#inputEntity').val().toLowerCase();

		location.href = '/laraction/edit/'+ subsystem + '.' + domain + '.' + entity;

		e.preventDefault();

	});
</script>
@endsection
