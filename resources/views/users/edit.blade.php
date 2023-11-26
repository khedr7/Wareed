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
							<h3 class="card-title">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.User') }}</h3>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<form method="post" action="{{ route('users.admin.update', $user->id) }}" autocomplete="off"
					enctype="multipart/form-data">
					<div class="card-body">
						@csrf

						@include('alerts.success')
						{{-- <input hidden type="text" name="old_phone" value="{{ $user->phone }}"> --}}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Name') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="name"
										class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Name') }}" value="{{ old('name', $user->name) }}">
									@include('alerts.feedback', ['field' => 'name'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Email') }} <sup style="color: red">*</sup></label>
									<input required type="email" name="email"
										class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Email') }}" value="{{ old('email', $user->email) }}">
									@include('alerts.feedback', ['field' => 'email'])
								</div>
							</div>
						</div>

						<div class="row">
							{{-- <div class="col-md-6">
								<div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Phone') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="phone"
										class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Phone') }}" pattern="[0-9]{9,10}"
										value="{{ old('phone', $user->phone) }}">
									@include('alerts.feedback', ['field' => 'phone'])
								</div>
							</div> --}}

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Role') }} <sup style="color: red">*</sup></label>
									<select required name="role" id="role"
										class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($roles as $role)
											<option value="{{ $role->name }}" {{ $role->name == $user->role ? 'selected' : '' }}>
												{{ $role->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'role'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Password') }}</label>
									<input type="text" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Password') }}" value="{{ old('password') }}">
									@include('alerts.feedback', ['field' => 'password'])
									<small class="form-text text-muted">
										Your password must be at least 6 characters long and contain a mix of letters, numbers, and special characters.
									</small>
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }} form-group">
									<label>{{ __('adminstaticword.Country') }}</label>
									<select name="state" id="state"
										class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }} form-control select2">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($states as $state)
											<option value="{{ $state->id }}" {{ $state->id == $user->city->state_id ? 'selected' : '' }}>
												{{ $state->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'city_id'])
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('city_id') ? ' has-danger' : '' }} form-group">
									<label>{{ __('adminstaticword.City') }}</label>
									<select name="city_id" id="city_id"
										class="form-control{{ $errors->has('city_id') ? ' is-invalid' : '' }} form-control select2">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($cities as $city)
											<option value="{{ $city->id }}" {{ $city->id == $user->city_id ? 'selected' : '' }}>
												{{ $city->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'city_id'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('birthday') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.DateofBirth') }}</label>
									<input type="date" name="birthday" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}"
										value="{{ old('birthday', $user->birthday ? $user->birthday->format('Y-m-d') : '') }}"
										max="{{ date('Y-m-d') }}">
									@include('alerts.feedback', ['field' => 'birthday'])
								</div>
							</div>

							{{-- <div class="col-md-6">
								<div class="form-group{{ $errors->has('points') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Points') }} <sup style="color: red">*</sup></label>
									<input required type="number" step="0.001" name="points"
										class="form-control{{ $errors->has('points') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Points') }}" min="0" value="{{ old('points', $user->points) }}">
									@include('alerts.feedback', ['field' => 'points'])
								</div>
							</div> --}}

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Address') }}</label>
									<input type="text" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Address') }}" value="{{ old('address', $user->address) }}">
									@include('alerts.feedback', ['field' => 'address'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>{{ __('adminstaticword.Image') }}</label>
									<div class="input-group mb-3">
										<div class="custom-file">
											<input type="file" name="profile" class="custom-file-input" id="profile" accept="image/*"
												aria-describedby="inputGroupFileAddon01" onchange="displayFileName()">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
										</div>
									</div>
									@if ($user->profile)
										<img width="75px" height="75px" src="{{ $user->profile }}" alt="">
									@elseif ($user->gender == 'female')
										<img width="75px" height="75px" src="{{ asset('') }}img/female-user.jpg" alt="">
									@else
										<img width="75px" height="75px" src="{{ asset('') }}img/male-user.jpg" alt="">
									@endif
								</div>
							</div>

                            <div class="col-md-6">
								<div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Gender') }}<sup style="color: red">*</sup></label> <br>

									<div class="form-check form-check-radio form-check-inline">
										<label class="form-check-label">
											<input required class="form-check-input" type="radio" name="gender" id="gender-male" value="male"
												{{ $user->gender == 'male' ? 'checked' : '' }}>
											{{ __('adminstaticword.Male') }}
											<span class="form-check-sign"></span>
										</label>
									</div>
									<div class="form-check form-check-radio form-check-inline">
										<label class="form-check-label">
											<input required class="form-check-input" type="radio" name="gender" id="gender-female" value="female"
												{{ $user->gender == 'female' ? 'checked' : '' }}>
											{{ __('adminstaticword.Female') }}
											<span class="form-check-sign"></span>
										</label>
									</div>
									@include('alerts.feedback', ['field' => 'gender'])
								</div>
							</div>

						</div>

						<div class="row">
							<div class="col-md-6 form-group">
								<label>{{ __('adminstaticword.Status') }}</label> <br>
								<div class="custom-switch">
									<input value="1" id="status" type="checkbox" name="status" class="custom-control-input"
										{{ $user->status == '1' ? 'checked' : '' }}>
									<label class="custom-control-label" for="status"></label>
								</div>
							</div>

							<div class="col-md-6 form-group">
								<label>{{ __('adminstaticword.Residence') }}</label> <br>
								<div class="custom-switch">
									<input value="1" id="has_residence" type="checkbox" name="has_residence" class="custom-control-input"
										{{ $user->has_residence == '1' ? 'checked' : '' }}>
									<label class="custom-control-label" for="has_residence"></label>
								</div>
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group{{ $errors->has('details') ? ' has-danger' : '' }}">
									<label for="details">{{ __('adminstaticword.Details') }}</label>
									<textarea id="summernote" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" name="details"
									 rows="10">{{ $user->details }}</textarea>
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

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>

<script>
	//Initialize Select2 Elements
	// $('.select2').select2()

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

	$(function() {
		var urlLike = '{{ url('admin/dropdown') }}';
		$('#state').change(function() {
			var up = $('#city_id').empty();
			var state_id = $(this).val();
			if (state_id) {
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: "GET",
					url: "{{ url('states/cities-dropdown') }}/" + state_id,
					success: function(data) {
						// console.log(data);
						up.append(
							'<option selected disabled value="0">{{ __('select') }}</option>'
						);
						$.each(data, function(id, name) {
							up.append($('<option>', {
								value: id,
								text: name
							}));
						});
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						console.log(XMLHttpRequest);
					}
				});
			}
		});
	});
</script>
<!-- Summernote -->
{{-- <script src="{{ asset('vendor/summernote/summernote-bs4.min.js') }}"></script> --}}
<script type="text/javascript">
	//$(document.ready(function() {
	//	$('#summernote').summernote()
	//}));
	$(function() {
		// Summernote
		// $('#summernote').summernote()
	})
</script>
