<!DOCTYPE html>
<html>
<head>
	<title>Laraction - Manager</title>

	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@forevolve/bootstrap-dark@1.0.0/dist/css/bootstrap-dark.min.css" />

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="https://unpkg.com/emodal@1.2.69/dist/eModal.min.js"></script>

	<style>
		.content-header{
			/* background: rgb(220 227 224); */
			padding-top:15px;
			padding-bottom:10px
		}
		.content-header h2{
			/* color: #28a745; */
		}
		body{
			/* background: #e6e7e6 */
		}
		.header{
			border-bottom: 1px solid #303030;
		}
	</style>
	
	@yield('style')

	<script type="text/javascript">
		$.ajaxSetup({
				headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		});
	</script>
</head>
<body>
	<div class="header">
		<div class="container">
			<div class="row">
	    		<div class="col-md-12" style=" height:60px;">
	    			<h1>Laraction</h1>
	    			
	    		</div>
	    	</div>
    	</div>
  </div>

    @yield('content')

		@if(session('success'))
		<script>
				toastr.success('{{session('success')}}', 'Sucesso');
		</script>
		@endif

		@if(session('error'))
		<script>
				toastr.error('{{session('error')}}', 'Ops..');
		</script>
		@endif

		@if(isset($error) and (is_string($error)))
		<script>
				toastr.error('{{$error}}', 'Ops..');
		</script>
		@endif

		@if(isset($error) and (is_array($error)))
			@foreach($error as $msg)
			<script>
					toastr.error('{{$msg}}', 'Ops..');
			</script>
			@endforeach
		@endif

		@if(session('info'))
		<script>
				toastr.info('{{session('info')}}');
		</script>
		@endif


		@yield('script')
</body>
</html>