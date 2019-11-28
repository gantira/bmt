@extends('admin.layouts.app')

@section('content')
<div class="container">
	<div class="row">
		@include('admin.layouts.sidebar', ['linkrole' => ' active'])

	    <div class="col-md-9">
	        <div class="card">
	            <div class="card-header">Edit Role #{!! $role->id !!}</div>
				<div class="card-body">

		            {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method'=>'PATCH',]) !!}

		            @include('admin.role.form')

		            <div class="form-group">
		            	<div class="col-md-4 offset-md-4">
			            	{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
			            </div>
		            </div>
		            {!! Form::close() !!}

				</div>
	        </div>
	    </div>
	    
	</div>
</div>
@endsection
