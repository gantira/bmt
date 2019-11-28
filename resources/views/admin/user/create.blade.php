@extends('admin.layouts.app')

@section('content')
<div class="container">
	{{ $errors }}
	<div class="row">
		@include('admin.layouts.sidebar', ['linkuser' => ' active'])

	    <div class="col-md-9">
	        <div class="card">
	            <div class="card-header">Create New User</div>
				<div class="card-body">
					
		            {!! Form::open(['route' => 'users.store', 'method'=>'POST', 'files' => true]) !!}

		            @include('admin.user.form')

		            <div class="form-group">
		            	<div class="col-md-4 offset-md-4">
			            	{!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
			            </div>
		            </div>
		            {!! Form::close() !!}

				</div>
	        </div>
	    </div>
	    
	</div>
</div>
@endsection
