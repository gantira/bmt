<div class="form-group row">
	{!! Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label text-md-right']) !!}

	<div class="col-md-5">
    	{!! Form::text('name', null, ['class' => $errors->has('name') ? 'form-control is-invalid' : $errors->has('name') ? 'form-control is-invalid' : 'form-control']) !!}
    	@if ($errors->has('name'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>