@extends('layouts.masterLayout')

@section('html_title', 'All Users')

@section('page_content')

<div class="row">

	<div class="col-md-5">
		<div class="box">
		<div class="box-header">
		    <h3 class="box-title">Add New User</h3>
		</div>

		  <div class="box-body table-responsive">

		  {{ Form::open(array('action' => 'UserController@postNewUser', 'class' => 'form-horizontal')) }}
		    <fieldset>

		    <div class="form-group">
		      <label class="col-md-4 control-label" for="email">Email Address</label>
		      <div class="col-md-4">
		        <div class="input-group">
		          <span class="input-group-addon"><i class="fa fa-lock"></i></span>
		          {{ Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Email Address'), 'required', 'autofocus') }}
		        </div>
		      </div>
		    </div>

		    <div class="form-group">
		      <label class="col-md-4 control-label" for="password">Password</label>
		      <div class="col-md-4">
		        <div class="input-group">
		          <span class="input-group-addon"><i class="fa fa-magic"></i></span>
		          {{ Form::password('password', array('id' => 'password', 'class' => ' form-control', 'placeholder' => 'Password'), 'required') }}
		        </div>
		      </div>
		    </div>

		    <div class="form-group">
		      <label class="col-md-4 control-label" for="first_name">First Name</label>
		      <div class="col-md-4">
		        <div class="input-group">
		          <span class="input-group-addon"><i class="fa fa-user"></i></span>
		          {{ Form::text('first_name', null, array('id' => 'first_name', 'class' => ' form-control', 'placeholder' => 'First Name')) }}
		        </div>
		      </div>
		    </div>

		    <div class="form-group">
		      <label class="col-md-4 control-label" for="last_name">Last Name</label>
		      <div class="col-md-4">
		        <div class="input-group">
		          <span class="input-group-addon"><i class="fa fa-user"></i></span>
		          {{ Form::text('last_name', null, array('id' => 'last_name', 'class' => ' form-control', 'placeholder' => 'Last Name')) }}
		        </div>
		      </div>
		    </div>

		    <div class="form-group">
		      <label class="col-md-4 control-label" for="is_admin">Superuser?</label>
		      <div class="col-md-4">
		        <div class="input-group">
		          {{ Form::checkbox('is_admin', 'yes') }}
		        </div>
		      </div>
		    </div>

		    <!-- Button -->
		    <div class="form-group">
		      <label class="col-md-4 control-label" for="singlebutton"></label>
		      <div class="col-md-4">
		        {{ Form::submit('Add User', array('class' => 'btn bg-olive btn-block')) }}
		      </div>
		    </div>

		    </fieldset>
		  {{ Form::close() }}

		  </div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>

	<div class="col-md-7">
		<div class="box">

			<div class="box-header">
				<h3 class="box-title">Existing Users @if (count($users) > 0) ({{ count($users) }}) @endif</h3>
			</div>

			<div class="box-body">
				<table class="table table-condensed table-hover" id="datatable">
					<thead>
						<tr>
							<th>Email</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Administrator</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						@foreach($users as $user)

							<tr>
								<td>{{ $user->email }}</td>
								<td>{{ $user->first_name }}</td>
								<td>{{ $user->last_name }}</td>
								<td>{{ $user->isSuperUser() ? "<span class='text-red'>Yes</span>" : "No" }}</td>
								<td>
									<a href="{{ action('UserController@getDetail', array('userID' => $user->getKey())) }}" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
									@if (count($users) > 1 && $user->getKey() != Sentry::getUser()->getKey())
										<a a-delete-user="{{ action('UserController@getDeleteUser', array('userID' => $user->getKey(), 'delete_all_info'=> true)) }}" a-user-name="{{ $user->email }}" class="btn btn-danger btn-xs delete-user">
											<i class="fa fa-times"></i> Delete
										</a>
									@endif
								</td>
							</tr>

						@endforeach

					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->		
	</div>
</div>

@stop

@section('javascript')
<script type="text/javascript">
    $(document).on("click", ".delete-user", function(e) {

      // Save the links
	  var delete_user = $(this).attr("a-delete-user");

      // Provide the user a option to keep the existing data, or delete everything we know about the key
    bootbox.dialog({
      message: "Please confirm whether you want to delete the user?",
      title: "Delete user " + $(this).attr("a-user-name"),
      buttons: {
        success: {
          label: "No Thanks",
          className: "btn-default"
        },
        danger: {
          label: "Delete User",
          className: "btn-danger",
          callback: function() {
            window.location = delete_user;
          }
        }
      }
    });
    });
</script>
@stop