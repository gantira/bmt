<div class="form-group row">
	{!! Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label text-md-right']) !!}

	<div class="col-md-4">
    	{!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control is-invalid' : $errors->has('name') ? 'form-control is-invalid' : 'form-control']) !!}
    	@if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    {!! Form::label('permissions', 'Permission', ['class' => 'col-md-4 col-form-label text-md-right']) !!}

    <div class="col-md-4">
        {!! Form::select('permissions[]', $permissions, isset($role) ? $role->permissions->pluck('name','name') : null, ['class' => $errors->has('permissions') ? 'form-control is-invalid' : $errors->has('permissions') ? 'form-control is-invalid' : 'form-control', 'multiple']) !!}
    	@if ($errors->has('permissions'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('permissions') }}</strong>
            </span>
        @endif
    </div>
</div>