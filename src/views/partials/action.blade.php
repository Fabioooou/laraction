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
          <span class="action-name-method action-{{$laraction['request']['method'] ?? 'get'}}">{{$laraction['request']['method'] ?? 'get'}}</span>

        </div>
      </div>
      <div class="input-group-prepend">
        <div class="input-group-text">
        {{$config->getEntity()}}
        </div>
      </div>

      <input name="actions[{{$action}}][name]" type="text" class="form-control action-name" value="{{$action}}">
      <div class="input-group-append action-item-http" data-open="0">
        <span class="input-group-text">
            {{$laraction['app']['type'] ?? 'mono'}}
        </span>
      </div>
      <div class="input-group-append action-item-open-close" data-open="0">
        <span class="input-group-text"><i class="las la-database"></i></span>
      </div>
      <div class="input-group-append action-item-remove">
        <span class="input-group-text"><i class="las la-trash"></i></span>
      </div>
    </div>

    <div class="action-details">

        <div class="use-case-box">
            <div class="row">
                <div class="col-md-12">
                <h5>Use Case</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label>Description</label>
                    <input type="text" name="actions[{{$action}}][description]" class="form-control action-description" value="{{$laraction['description'] ?? ''}}" />
                </div>

                <div class="col-md-3">
                    <label>Operation</label>
                    <select name="actions[{{$action}}][business][operation]" class="form-control  operation-method">
                        @foreach($operations as $key => $operation)
                        <option {{($editable and $laraction['business']['operation'] == $key) ? 'selected' : ''}} value="{{$key}}">{{$operation['name']}}</option>
                        @endforeach
                    </select>
                  </div>

            </div>
        </div>


      <div class="request">
        <div class="row">
          <div class="col-md-12">
            <h5>Application layer</h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <label>Method</label>
            <select name="actions[{{$action}}][request][method]" class="form-control action-method">
              <option {{($editable and $laraction['request']['method'] == 'get') ? 'selected' : ''}} value="get">GET</option>
              <option {{($editable and $laraction['request']['method'] == 'post') ? 'selected' : ''}}  value="post">POST</option>
              <option {{($editable and $laraction['request']['method'] == 'put') ? 'selected' : ''}}  value="put">PUT</option>
              <option {{($editable and $laraction['request']['method'] == 'delete') ? 'selected' : ''}}  value="delete">DELETE</option>
            </select>
          </div>
          <div class="col-md-2">
            <label>Route Params:</label>
            <input type="text" name="actions[{{$action}}][request][route_params]" class="form-control route-params" value="{{ (!empty($laraction['request']['route_params'])) ? $laraction['request']['route_params'] : '' }}" />
          </div>

          <div class="col-md-2">
            <label>Application Type</label>
            <select name="actions[{{$action}}][app][type]" class="form-control action-apptype">
              <option {{($editable and $laraction['app']['type'] == 'mono') ? 'selected' : ''}}  value="mono">Monolithic (view)</option>
              <option {{($editable and $laraction['app']['type'] == 'api') ? 'selected' : ''}} value="api">API - REST (json)</option>
            </select>
          </div>


          <div class="col-md-2">
            <label>Layout</label>
            <input type="text" name="actions[{{$action}}][view][layout_name]" class="form-control" value="{{ (!empty($laraction['view']['layout_name'])) ? $laraction['view']['layout_name'] : strtolower($config->getSubSystem()) }}" />
          </div>

          <!--
          <div class="col-md-1">
            <label>Body</label>
            <select name="actions[{{$action}}][request][body]" class="form-control">
              <option value="form-data">Multipart Form</option>
            </select>
          </div>
          <div class="col-md-2">
            <label>Middlewares</label>
            <input type="text" name="actions[{{$action}}][request][middlewares]" class="form-control" />
          </div>
        -->

        </div>
      </div>
      <br />
      <div class="row">
        <div class="col-md-12">
            <h5>Entity Fields</h5>
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


      <div class="row" style="display: none">


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
