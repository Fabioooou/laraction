@extends('laraction::layout.app')
@section('content')
<form id="frmSubSystem" action="/laraction/step3/{{$config->getRoute()}}" method="POST">
@csrf
<div class="content-header">
	<div class="container">
			<div class="row">
				<div class="col-md-10">
					<h2>{{$config->getRoute()}}
						<small>{{implode('/', $config->getCapitalizePath())}}</small>
					</h2>
				</div>
				<div class="col-md-2 text-right">
					<input type="submit" value="Save actions" class="btn btn-outline-secondary">
				</div>
			</div>
	</div>
</div>

<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h4  class="display-4">Actions
					<small>Select your action</small>
				</h4>
			</div>
		</div>
</div>

<div class="container">
		<div class="row">

				<div id="action-news"></div>
		</div>
</div>

<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<br />
				<br />
					<a id="action-add" href="javascript:void(0)" class="btn btn-primary"> <i class="las la-plus"></i> Add Action</a>
			</div>
		</div>
</div>
</form>
@endsection
@section('style')
<style>
	.table, .table input, .table select{
		font-size: 11px;
		font-family: arial;
	}
	h2 small{
		font-size: 16px;
		clear: both;
	}
	h4 small{
		font-size: 16px;
		clear: both;
	}
	.action-col{
		padding-top: 10px;

	}
	.action-details{ display: none}
	.action-details .form-control{
		font-size: 12px;
	}


	.action-name-method{
		font-size: 10px !important;
		text-transform: uppercase;
	}
	.action-get{
		color: #a65dd6
	}
	.action-post{
		color: #5dd671
	}
	.action-put{
		color: #d67f5d
	}
	.action-delete{
		color: #eb4c4c
	}
    .use-case-box{
        padding-bottom:15px;

    }

</style>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script type="text/javascript">
$(function(){

	$(document).on('click', '.action-enabled' ,function()
	{
		$action_item = $(this).parent().parent().parent();
		if(!$(this).is(":checked")){
			$('#table-'+$(this).attr('id')+' input:checked').prop("checked", false);
		}else{
			$('#table-'+$(this).attr('id')).fadeIn(500);
			$('#table-'+$(this).attr('id')+' input').prop("checked", true);
		}
		$action_item.find('.action-item-open-close').click();
	});

	$(document).on('click', '.action-item-open-close', function()
	{
		$action_item = $(this).parent().parent();
		if($(this).attr('data-open') == '0'){
			$action_item.find('.action-details').fadeIn(500);
			$(this).attr('data-open', 1);
			$(this).find('i').removeClass('la-angle-up').addClass('la-angle-down');
		}else{
			$(this).find('i').removeClass('la-angle-down').addClass('la-angle-up');
			$(this).attr('data-open', 0);
			$action_item.find('.action-details').fadeOut(500);
		}
	})

	$(document).on('click', '.action-item-remove', function()
	{
		$action_item = $(this).parent().parent().parent();
		$action_item.fadeOut(800, function(){
			$action_item.remove();
		});
	});

	$(document).on('change', '.action-method', function()
	{
		$action_item = $(this).parent().parent().parent().parent().parent();
		$action_item.find('.action-name-method').removeClass('action-get').removeClass('action-post').removeClass('action-put').removeClass('action-delete').addClass('action-'+$(this).val());
		$action_item.find('.action-name-method').html($(this).val());
	});

    $(document).on('change', '.operation-method', function()
	{
        $operation = $(this).val();
        $action_method = $(this).parent().parent().parent().parent().find('.action-method');
        $route_params = $(this).parent().parent().parent().parent().find('.route-params');

        if($operation == 'create' || $operation == 'save'){
            $action_method.val('post');
        }else{
            $action_method.val('get');
        }
        $action_method.trigger('change');

        if($operation == 'save' || $operation == 'save_form' || $operation == 'delete'){
            $route_params.val('id');
        }else{
            $route_params.val('');
        }

    });

	$(document).on('change', '.action-apptype', function()
	{
        /**
		$action_item = $(this).parent().parent().parent().parent().parent();
		$action_item.find('.action-name-method').removeClass('action-get').removeClass('action-post').removeClass('action-put').removeClass('action-delete').addClass('action-'+$(this).val());
		$action_item.find('.action-name-method').html($(this).val());
        **/
	});


	$(document).on('click', '#newField', function()
	{
		$name = 'newfield_'+Math.random();
		$action = $(this).attr('data-action');
		$tbody = $(this).parent().parent().parent().parent();
		$tr = '<tr>'+
							'<td><input class="action-column-enabled" name="actions['+$action+'][column]['+$name+'][enabled]"  value="1"  type="checkbox" checked /></td>'+
							'<td><input type="text" name="actions['+$action+'][column]['+$name+'][name]" value="'+$name+'" class="form-control" />'+
									'<input type="hidden" name="actions['+$action+'][column]['+$name+'][primaryKey]" value="0" class="form-control" />'+
									'<input type="hidden" name="actions['+$action+'][column]['+$name+'][length]" value="" class="form-control" />'+
									'<input readonly name="actions['+$action+'][column]['+$name+'][origin]"  type="hidden" value="virtual" />'+
							'</td>'+
							'<td><select name="actions['+$action+'][column]['+$name+'][type]" class="form-control">'+
									'<option value="string">string</option><option value="integer">integer</option><option value="boolean">boolean</option><option value="json">json</option>'+
									'</select>'+
							'</td>'+
							'<td><select name="actions['+$action+'][column]['+$name+'][notnull]" class="form-control">'+
									'<option value="1">Yes</option><option value="0">No</option>'+
									'</select>'+
							'</td>'+
							'<td><input type="text" name="actions['+$action+'][column]['+$name+'][default]" value="" class="form-control" /></td>'+
							'<td><input name="actions['+$action+'][column]['+$name+'][validate]" type="text" class="form-control action-column-validate" value=""></td>'+
					'</tr>';
		$tbody.find('.action-newfields').before($tr);
	});

	$(document).on('click', '#action-add', function()
	{
		newAction();
	});

	function newAction(action = 'Example')
	{
		if(action == 'Example'){
			action = action +''+ $('.action-name').length;
		}
		$.post('/laraction/action/{{$config->getRoute()}}/'+action, {}, function(data){
			$('#action-news').before(data);
			$('.action-name:last').focus();

			new Sortable(document.getElementById('tbody-action-'+action),
			{
				animation: 150,
				draggable: ".drag",
				handle: '.handle',
			});

		});
	}

	@foreach($actions as $action)
		newAction('{{$action}}');
	@endforeach

});
</script>
@endsection
