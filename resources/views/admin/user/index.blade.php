@extends('admin.layouts.app')

@section('content')
<div class="container">


	<div class="row">
		@include('admin.layouts.sidebar', ['linkuser' => ' active'])

	    <div class="col-md-9">
	        <div class="card">
	            <div class="card-header">User</div>
	            <div class="card-body">
		            	<a href="{{ route('users.create') }}"><button class="btn btn-success btn-sm">Add New</button></a>
		            <br><br>
		            <table class="table">
		            	<thead>
		            		<tr>
			            		<th>#</th>
			            		<th>Name</th>
			            		<th>Email</th>
			            		<th>Status</th>
			            		<th>Actions</th>
		            		</tr>
		            	</thead>
		            	<tbody>
		            		@foreach ($users as $key => $row)
		            		<tr>
		            			<td>{!! $key+1 !!}</td>
		            			<td>{!! $row->name !!}</td>
		            			<td>{!! $row->email !!}</td>
		            			<td>{!! $row->status !!}</td>
		            			<td><a href="{{ route('users.show', $row->id) }}" title='View Role'><button class="btn btn-info btn-sm">View</button></a>
		            				<a href="{{ route('users.edit', $row->id) }}" title='Edit Role'><button class="btn btn-primary btn-sm">Edit</button></a>

									{!! Form::open([
			                            'method'=> 'DELETE',
			                            'route' => ['users.destroy', $row->id],
			                            'style' => 'display:inline'
			                        	]) !!}
			                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
			                                    'type' => 'submit',
			                                    'class' => 'btn btn-danger btn-sm',
			                                    'title' => 'Delete Role',
			                                    'onclick'=>'return confirm("Confirm delete?")'
			                            )) !!}
			                        {!! Form::close() !!}
				          		</td>
		            		</tr>
		            		@endforeach
		            	</tbody>
		            </table>
	            </div>
	        </div>
	    </div>
	    
	</div>
</div>
@endsection
