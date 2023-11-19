@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<!-- /.card -->
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-6">
							<h3 class="card-title">{{ __('adminstaticword.AddUser') }}</h3>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<form id="create-user" method="post" action="{{ route('users.admin.store') }}" autocomplete="off"
					enctype="multipart/form-data">
					<div class="card-body">
						@csrf

						@include('alerts.success')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('Name') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="name"
										class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}"
										value="{{ old('name') }}">
									@include('alerts.feedback', ['field' => 'name'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
									<label>{{ __('Email address') }} <sup style="color: red">*</sup></label>
									<input required type="email" name="email"
										class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email address') }}"
										value="{{ old('email') }}">
									@include('alerts.feedback', ['field' => 'email'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
									<label>{{ __('Phone') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="phone"
										class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" placeholder="{{ __('Phone') }}"
										pattern="[0-9]{9,10}" value="{{ old('phone') }}">
									@include('alerts.feedback', ['field' => 'phone'])
								</div>
							</div>

							<div class="col-md-6">
								
								<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
									<label>{{ __('Password') }} <sup style="color: red">*</sup></label>
									<input required type="password" name="password"
										class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}"
										value="{{ old('password') }}">
									@include('alerts.feedback', ['field' => 'password'])

									<small class="form-text text-muted">
										Your password must be at least 6 characters long and contain a mix of letters, numbers, and special characters.
									</small>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('city_id') ? ' has-danger' : '' }} form-group">
									<label>{{ __('City') }} <sup style="color: red">*</sup></label>
									<select name="city_id" id="city_id"
										class="form-control{{ $errors->has('city_id') ? ' is-invalid' : '' }} form-control select2">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($cities as $city)
											<option value="{{ $city->id }}" {{ $city->id == old('city_id') ? 'selected' : '' }}>
												{{ $city->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'city_id'])
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
									<label>{{ __('Role') }} <sup style="color: red">*</sup></label>
									<select required name="role" id="role"
										class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($roles as $role)
											<option value="{{ $role->name }}" {{ $role->name == old('role') ? 'selected' : '' }}>
												{{ $role->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'role'])
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
									<label>{{ __('address') }}</label>
									<input type="text" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
										placeholder="{{ __('address') }}" value="{{ old('address') }}">
									@include('alerts.feedback', ['field' => 'address'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group"{{ $errors->has('profile') ? ' has-danger' : '' }}>
									<label>{{ __('adminstaticword.Image') }}</label>
									<div class="input-group mb-3">
										<div class="custom-file">
											<input type="file" name="profile" class="custom-file-input" id="profile" accept="image/*"
												aria-describedby="inputGroupFileAddon01" onchange="displayFileName()">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											@include('alerts.feedback', ['field' => 'profile'])

										</div>
									</div>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('birthday') ? ' has-danger' : '' }}">
									<label>{{ __('birth date') }}  <sup style="color: red">*</sup></label>
									<input type="date" name="birthday" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}"
										value="{{ old('birthday') }}" max="{{ date('Y-m-d') }}">
									@include('alerts.feedback', ['field' => 'birthday'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
									<label>{{ __('Gender') }} <sup style="color: red">*</sup></label> <br>

									<div class="form-check form-check-radio form-check-inline">
										<label class="form-check-label">
											<input required class="form-check-input" type="radio" name="gender" id="gender-male" value="male"
												{{ old('gender') == 'male' ? 'checked' : '' }}>
											{{ __('male') }}
											<span class="form-check-sign"></span>
										</label>
									</div>
									<div class="form-check form-check-radio form-check-inline">
										<label class="form-check-label">
											<input required class="form-check-input" type="radio" name="gender" id="gender-female" value="female"
												{{ old('gender') == 'female' ? 'checked' : '' }}>
											{{ __('female') }}
											<span class="form-check-sign"></span>
										</label>
									</div>
									@include('alerts.feedback', ['field' => 'gender'])
								</div>
							</div>
						</div>

						<div class="row">

							<div class="col-md-6 form-group">
								<label>{{ __('status') }}</label> <br>
								<div class="custom-switch">
									<input id="status" type="checkbox" name="status" value="1" class="custom-control-input">
									<label class="custom-control-label" for="status"></label>
								</div>
							</div>

							<div class="col-md-6 form-group">
								<label>{{ __('Residence') }}</label> <br>
								<div class="custom-switch">
									<input id="has_residence" type="checkbox" value="1" name="has_residence" class="custom-control-input">
									<label class="custom-control-label" for="has_residence"></label>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group{{ $errors->has('details') ? ' has-danger' : '' }}">
									<label for="details">{{ __('Details') }}</label>
									<textarea id="summernote" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" name="details"
									 rows="10">{{ old('details') }}</textarea>
									@include('alerts.feedback', ['field' => 'details'])
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
						</div>
					</div>
				</form>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- /.col -->
	</div>



@stop

{{-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script> --}}

<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/additional-methods.min.js') }}"></script>

<script>
	//Initialize Select2 Elements
	$('.select2').select2()

	//Initialize Select2 Elements
	// $('.select2bs4').select2({
	// 	theme: 'bootstrap4'
	// })
</script>

<script>
	function displayFileName() {
		var input = document.getElementById('profile');
		var fileName = input.files[0].name;
		var label = document.querySelector('.custom-file-label');
		label.innerText = fileName;
	}
</script>
<!-- Summernote -->
<script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script>
<script type="text/javascript">
	//$(document.ready(function() {
	//	$('#summernote').summernote()
	//}));
	$(function() {
		// Summernote
		$('#summernote').summernote()
	})
</script>

{{-- <script>
	document.getElementById('create-user').addEventListener('submit', function(event) {
		var password = document.getElementById('password').value;
		var passwordRegex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/;

		if (!passwordRegex.test(password)) {
			alert('Password does not meet the requirements.');
			event.preventDefault(); // Prevent form submission
		}
	});
</script> --}}


{{-- <script>
	$(function() {
		$.validator.setDefaults({
			submitHandler: function() {
				alert("Form successful submitted!");
			}
		});
		$('#create-user').validate({
			rules: {
				name: {
					required: true,
					minlength: 2
				},
				email: {
					required: true,
					email: true,
				},
				password: {
					required: true,
					minlength: 6
				},
				city_id: {
					required: true
				},
				role: {
					required: true
				},
				profile: {
					image: true
				},

				gender: {
					required: true
				},

			},
			messages: {
				name: {
					required: "Please enter a email address",
					minlength: "The name must be at least 3 characters long"
				},
				email: {
					required: "Please enter a email address",
					email: "Please enter a valid email address"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 6 characters long"
				},
				city_id: {
					required: "Please provide a city",
				},
				role: {
					required: "Please provide a role",
				},

				birthday: {
					required: "Please provide a birthday",
				},
				gender: {
					required: "Please provide a gender",
				},
			},
			errorElement: 'span',
			errorPlacement: function(error, element) {
				error.addClass('invalid-feedback');
				element.closest('.form-group').append(error);
			},
			highlight: function(element, errorClass, validClass) {
				$(element).addClass('is-invalid');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).removeClass('is-invalid');
			}
		});
	});
</script> --}}
