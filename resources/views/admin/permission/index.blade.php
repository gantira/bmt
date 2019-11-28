@extends('admin.layouts.app')

@section('content')
<div class="container">
	<div class="row">
		@include('admin.layouts.sidebar', ['linkpermission' => ' active'])

	    <div class="col-md-9">
	        <div class="card">
	            <div class="card-header">Permission</div>
	            <div class="card-body">
		            <a href="{{ route('permissions.create') }}"><button class="btn btn-success btn-sm">Add New</button></a>
		            <br><br>
		            <table class="table">
		            	<thead>
		            		<tr>
			            		<th>#</th>
			            		<th>Name</th>
			            		<th>Actions</th>
		            		</tr>
		            	</thead>
		            	<tbody>
		            		@foreach ($permissions as $row)
		            		<tr>
		            			<td>{!! $row->id !!}</td>
		            			<td>{!! $row->name !!}</td>
		            			<td><a href="{{ route('permissions.show', $row->id) }}" title='View Permission'><button class="btn btn-info btn-sm">View</button></a>
		            				<a href="{{ route('permissions.edit', $row->id) }}" title='Edit Permission'><button class="btn btn-primary btn-sm">Edit</button></a>

									{!! Form::open([
			                            'method'=> 'DELETE',
			                            'route' => ['permissions.destroy', $row->id],
			                            'style' => 'display:inline'
			                        	]) !!}
			                            {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> Delete', array(
			                                    'type' => 'submit',
			                                    'class' => 'btn btn-danger btn-sm',
			                                    'title' => 'Delete Permission',
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
