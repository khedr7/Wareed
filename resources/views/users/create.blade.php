@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<h1 class="m-0 text-dark">{{ __('adminstaticword.Dashboard') }}</h1>
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
									<label>{{ __('adminstaticword.Name') }}<sup style="color: red">*</sup></label>
									<input required type="text" name="name"
										class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Name') }}" value="{{ old('name') }}">
									@include('alerts.feedback', ['field' => 'name'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Email') }} <sup style="color: red">*</sup></label>
									<input required type="email" name="email"
										class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Email') }}" value="{{ old('email') }}">
									@include('alerts.feedback', ['field' => 'email'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Phone') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="phone"
										class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Phone') }}" pattern="[0-9]{9,10}" value="{{ old('phone') }}">
									@include('alerts.feedback', ['field' => 'phone'])
								</div>
							</div>

							<div class="col-md-6">

								<div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Password') }} <sup style="color: red">*</sup></label>
									<input required type="password" name="password"
										class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
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
										class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }} form-control select2bs4">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($states as $state)
											<option value="{{ $state->id }}" {{ $state->id == old('state') ? 'selected' : '' }}>
												{{ $state->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'city_id'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('city_id') ? ' has-danger' : '' }} form-group">
									<label>{{ __('adminstaticword.City') }} <sup style="color: red">*</sup></label>
									<select name="city_id" id="city_id"
										class="form-control{{ $errors->has('city_id') ? ' is-invalid' : '' }} form-control select2bs4">
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



						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
									<label for="role">{{ __('adminstaticword.Role') }} <sup style="color: red">*</sup></label>
									<select required name="role" id="role"
										class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }} select2bs4">
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

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Address') }}</label>
									<input type="text" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Address') }}" value="{{ old('address') }}">
									@include('alerts.feedback', ['field' => 'address'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('birthday') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.DateofBirth') }} <sup style="color: red">*</sup></label>
									<input type="date" name="birthday" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}"
										value="{{ old('birthday') }}" max="{{ date('Y-m-d') }}">
									@include('alerts.feedback', ['field' => 'birthday'])
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

						{{-- <div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('points') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Points') }} <sup style="color: red">*</sup></label>
									<input required type="number" step="0.001" name="points"
										class="form-control{{ $errors->has('points') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Points') }}" min="0" value="{{ old('points') }}">
									@include('alerts.feedback', ['field' => 'points'])
								</div>
							</div>
						</div> --}}

						<div class="row">

							<div class="col-md-6 form-group">
								<label>{{ __('adminstaticword.Status') }}</label> <br>
								<div class="custom-switch">
									<input id="status" type="checkbox" name="status" value="1" class="custom-control-input">
									<label class="custom-control-label" for="status"></label>
								</div>
							</div>

							<div class="col-md-6 form-group">
								<label>{{ __('adminstaticword.Residence') }}</label> <br>
								<div class="custom-switch">
									<input id="has_residence" type="checkbox" value="1" name="has_residence" class="custom-control-input">
									<label class="custom-control-label" for="has_residence"></label>
								</div>
							</div>
						</div>
						<br>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Gender') }} <sup style="color: red">*</sup></label> <br>

									<div class="form-check form-check-radio form-check-inline">
										<label class="form-check-label">
											<input required class="form-check-input" type="radio" name="gender" id="gender-male" value="male"
												{{ old('gender') == 'male' ? 'checked' : '' }}>
											{{ __('adminstaticword.Male') }}
											<span class="form-check-sign"></span>
										</label>
									</div>
									<div class="form-check form-check-radio form-check-inline">
										<label class="form-check-label">
											<input required class="form-check-input" type="radio" name="gender" id="gender-female" value="female"
												{{ old('gender') == 'female' ? 'checked' : '' }}>
											{{ __('adminstaticword.Female') }}
											<span class="form-check-sign"></span>
										</label>
									</div>
									@include('alerts.feedback', ['field' => 'gender'])
								</div>
							</div>

							<div class="col-md-6" style="display: none;" id="rolebox">
								<div class="form-group{{ $errors->has('days[]') ? ' has-danger' : '' }}">
									<label for="days">{{ __('adminstaticword.Days') }} <sup style="color: red">*</sup></label>
									<select class="select2bs4" multiple name="days[]" id="days"
										class="form-control{{ $errors->has('days') ? ' is-invalid' : '' }}">
										@foreach ($days as $day)
											<option value="{{ $day->id }}" {{ $day->id == old('day[]') ? 'selected' : '' }}>
												{{ $day->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'days'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 form-group">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.MapLatitude') }}</label>
									<input type="text" name="latitude" id="latitude"
										class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" value="{{ old('latitude') }}">
									@include('alerts.feedback', ['field' => 'latitude'])
								</div>
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.MapLongitude') }}</label>
									<input type="text" name="longitude" id="longitude"
										class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" value="{{ old('longitude') }}">
									@include('alerts.feedback', ['field' => 'longitude'])
								</div>
							</div>

							<div class="col-md-6 form-group">
								<div class="map" id="map"></div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group{{ $errors->has('details') ? ' has-danger' : '' }}">
									<label for="details">{{ __('adminstaticword.Details') }}</label>
									<textarea id="summernote" class="form-control{{ $errors->has('details') ? ' is-invalid' : '' }}" name="details"
									 rows="10">{{ old('details') }}</textarea>
									@include('alerts.feedback', ['field' => 'details'])
								</div>
							</div>
						</div>
						<div class="">
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
<style>
	.map {
		height: 250px;
		width: 350px;
	}
</style>

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/additional-methods.min.js') }}"></script>

<style>
	.map {
		height: 250px;
		width: 350px;
	}
</style>


<script>
	$(function() {
		//Initialize Select2 Elements
		$('.select2').select2()

		//Initialize Select2 Elements
		$('.select2bs4').select2({
			theme: 'bootstrap4'
		})
	});
</script>

<script>
	function displayFileName() {
		var input = document.getElementById('profile');
		var fileName = input.files[0].name;
		var label = document.querySelector('.custom-file-label');
		label.innerText = fileName;
	}

	$(function() {
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

	$(function() {
		$('#role').on('change', function() {
			var opt = $(this).val();

			if (opt == 'provider') {
				$('#rolebox').show();

			} else {
				$('#rolebox').hide('fast');
			}
		});
	});
</script>

{{-- map --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCPsxZeXKcSYK1XXw0O0RbrZiI_Ekou5DY&callback=initMap" async
	defer></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Wait for the DOM to be fully loaded
		initMapAfterLoad();
	});

	function initMapAfterLoad() {
		// Check if the map element is available
		const mapElement = document.getElementById('map');
		if (mapElement) {
			// Initialize the map
			initMap();
		} else {
			// If the map element is not available, wait and try again
			setTimeout(initMapAfterLoad, 100);
		}
	}

	// تهيئة الخريطة
	function initMap() {
		const map = new google.maps.Map(document.getElementById('map'), {
			center: {
				lat: 33.510414,
				lng: 36.278336
			},
			zoom: 8,
		});

		// إضافة حدث النقر على الخريطة
		google.maps.event.addListener(map, 'click', function(event) {
			// الحصول على الإحداثيات عند النقر
			const lat = event.latLng.lat();
			const lng = event.latLng.lng();

			$('#latitude').val(lat);
			$('#longitude').val(lng);

			// يمكنك استخدام lat وlng كما تشاء (مثلاً: تخزينها في متغيرات أو إرسالها إلى خادم)
			console.log('Latitude: ' + lat + ' , Longitude: ' + lng);
		});
	}
</script>
