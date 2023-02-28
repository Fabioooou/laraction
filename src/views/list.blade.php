@extends('laraction::layout.app')
@section('content')
<div class="content-header">
	<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2>Laraction List
						<small></small>
					</h2>
				</div>
			</div>
	</div>
</div>
<div class="container" style="margin-top: 50px;">
	<div class="row">
		<div class="col-md-12">
			<h2>List</h2>
			<table class="table table-sm table-dark">
				<thead>
					<tr>
						<th>Name</th>
						<th>Last modified</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($laractions as $laraction)
					<tr>
						<td>{{$laraction['name']}}</td>
						<td>{{date('Y-m-d H:i:s',$laraction['updated_at'])}}</td>
						<td>
							<a href="/laraction/generate/{{$laraction['name']}}" class="btn btn-primary">generate</a>
							<a href="/laraction/edit/{{$laraction['name']}}" class="btn btn-primary">edit</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

</script>
@endsection
