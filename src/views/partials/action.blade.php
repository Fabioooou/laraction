@php
$validation = function($col)
{

  if(!empty($col['validate'])){
    return $col['validate'];
  }

  $validate = [];
  ($col['notnull']) ? array_push($validate, 'required') : array_push($validate, 'nullable');
  ($col['name'] == 'email') ? array_push($validate,'email') : '';
  ($col['type'] == 'string' and $col['length'] > 0) ? array_push($validate, 'string' , 'min:1' ,'max:'.$col['length']) : '';
  ($col['type'] == 'boolean') ? array_push($validate, 'boolean') : '';  
  ($col['type'] == 'integer' and $col['precision']) ? array_push($validate, 'numeric', 'digits_between:'.$col['scale'].','.$col['precision']) : '';   
  return implode('|', $validate);

}
@endphp
@php
  
  if(!empty($col['name'])){
    //$action = $col['name'];
  }

@endphp
<div class="col-md-12 action-col"> 
  <div class="action-item">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <div class="input-group-text action-name-icon">
          <span class="action-name-method action-get">get</span>
          
        </div>
      </div>
      <div class="input-group-prepend">
        <div class="input-group-text">
        {{$config['entity']}}
        </div>
      </div>
      
      <input name="actions[{{$action}}][name]" type="text" class="form-control action-name" value="{{$action}}">
      <div class="input-group-append action-item-http" data-open="0">
        <span class="input-group-text"><i class="las la-plug"></i></span>
      </div>
      <div class="input-group-append action-item-open-close" data-open="0">
        <span class="input-group-text"><i class="las la-database"></i></span>
      </div>
      <div class="input-group-append action-item-remove">
        <span class="input-group-text"><i class="las la-trash"></i></span>
      </div>
    </div>
    
    <div class="action-details">

      <div class="request">
        <div class="row">
          <div class="col-md-12">
            <h5>Request</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-5">
            <label>Use Case (Description - Swagger)</label>
            <input type="text" name="actions[{{$action}}][description]" class="form-control action-description" />
          </div>

          <div class="col-md-2">
            <label>Method</label>
            <select name="actions[{{$action}}][request][method]" class="form-control action-method">
              <option value="get">GET</option>
              <option value="post">POST</option>
              <option value="put">PUT</option>
              <option value="delete">DELETE</option>
            </select>
          </div>
          <div class="col-md-1">
            <label>Auth ?</label>
            <select name="actions[{{$action}}][request][auth_type]" class="form-control">
              <option value="no">No</option>
              <option value="bearer">Bearer</option>
            </select>
          </div>
          <div class="col-md-2">
            <label>Body</label>
            <select name="actions[{{$action}}][request][body]" class="form-control">
              <option value="form-data">Multipart Form</option>
            </select>
          </div>
          <div class="col-md-2">
            <label>Middlewares</label>
            <input type="text" name="actions[{{$action}}][request][middlewares]" class="form-control" />
          </div>
        </div>
      </div>
      <br />
     

      <table id="table-action-{{$action}}" class="table table-dark table-sm table-hover action-table">
        <thead class="">
          <tr>
            <th class=" text-center"><input id="action-{{$action}}" class="action-enabled" name="actions[{{$action}}][enabled]" value="1" type="checkbox" {{(!$editable) ? 'checked' : '' }}   /></th>
            <th>Field</th>
            <th>Type</th>
            <th>Not null</th>
            <th style="width:100px">Default</th>
            <th>Validate</th>
            <th style="width:30px"></th>
          </tr>
        </thead>
        <tbody id="tbody-action-{{$action}}">
        @foreach($columns as $name => $col)
        <tr class="drag text-center">
          <td><input class="action-column-enabled" name="actions[{{$action}}][column][{{$col['name']}}][enabled]" value="1"  type="checkbox" {{ ($editable and empty($col['enabled'])) ? '' : 'checked' }} /></td>
          <td>
            @if(!$col['primaryKey'])
              <input readonly name="actions[{{$action}}][column][{{$col['name']}}][name]"  type="text" value="{{$col['name']}}" class="form-control" />
            @else
              <div class="input-group">
                <input readonly name="actions[{{$action}}][column][{{$col['name']}}][name]"  type="text" value="{{$col['name']}}" class="form-control" />
                <div class="input-group-append action-item-remove">
                  <span class="input-group-text"><i class="las la-key"></i></span>
                </div>
              </div>
            @endif
            <input readonly name="actions[{{$action}}][column][{{$col['name']}}][primaryKey]"  type="hidden" value="{{$col['primaryKey']}}" />
            <input readonly name="actions[{{$action}}][column][{{$col['name']}}][length]"  type="hidden" value="{{$col['length']}}" />
            <input readonly name="actions[{{$action}}][column][{{$col['name']}}][origin]"  type="hidden" value="field" />
          </td>
          <td>
            <select name="actions[{{$action}}][column][{{$col['name']}}][type]" class="form-control">
              <option value="{{$col['type']}}">{{$col['type']}}</option>
            </select>
          </td>
          <td>
            <select name="actions[{{$action}}][column][{{$col['name']}}][notnull]" class="form-control">
              <option value="{{$col['notnull']}}">{{($col['notnull']) ? 'Yes' : 'No'}}</option>
            </select>
          </td>
          <td><input name="actions[{{$action}}][column][{{$col['name']}}][default]" type="text" class="form-control action-column-validate" value="{{$col['default']}}"></td>
          <td><input name="actions[{{$action}}][column][{{$col['name']}}][validate]" type="text" class="form-control action-column-validate" value="{!! $validation($col) !!}"></td>
          <td class="handle text-center"><i class="las la-arrows-alt"></i></td>
        </tr>
        @endforeach
        <tr class="action-newfields">
          <td colspan="6" class="text-right"><a id="newField" data-action="{{$action}}" class="btn btn-sm btn-outline-primary">Add field</a></td>
        </tr>
        </tbody>
      </table>

      <div class="row">
        <div class="col-md-12">
          <h5>Response</h5>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3">
          <label>Business operation</label>
          <select name="actions[{{$action}}][business][operation]" class="form-control">
            <option value="find">{{$config['entity']}}::find</option>
            <option value="paginate">{{$config['entity']}}::paginate</option>
            <option value="collection">Collection {{$config['entity']}}</option>
            <option value="create">{{$config['entity']}}::create</option>
            <option value="save">{{$config['entity']}}->save()</option>
            <option value="delete">{{$config['entity']}}->delete()</option>
          </select>
        </div>

        <div class="col-md-2">
          <label>Business Success</label>
          <select name="actions[{{$action}}][business][success][code]" class="form-control">
            <option value="200">200 Status Code</option>
            <option value="201">201 Status Code</option>
          </select>
        </div>  

        <div class="col-md-2">
          <label>Business Exception</label>
          <select name="actions[{{$action}}][business][exception][code]" class="form-control">
            <option value="400">400 Status Code</option>
            <option value="422">422 Status Code</option>
          </select>
        </div>  

        <div class="col-md-2">
          <label>Validate Exception</label>
          <select name="actions[{{$action}}][business][validate][code]" class="form-control">
            <option value="422">422 Status Code</option>
            <option value="400">400 Status Code</option>
          </select>
        </div>  

        <div class="col-md-2">
          <label>Type</label>
          <select name="actions[{{$action}}][response][type]" class="form-control">
            <option value="json">Json</option>
          </select>
        </div>  

      </div>
    </div>
  </div>

  </div>
</div> 