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
							<h3 class="card-title">{{ __('adminstaticword.Edit') }} {{ __('adminstaticword.Profile') }}</h3>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<form method="post" action="{{ route('users.admin.updateProfile', $user->id) }}" autocomplete="off"
					enctype="multipart/form-data">
					<div class="card-body">
						@csrf

						@include('alerts.success')
						<input hidden type="text" name="old_phone" value="{{ $user->phone }}">
						<input hidden type="text" name="old_email" value="{{ $user->email }}">

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
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Phone') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="phone"
										class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Phone') }}" pattern="[0-9]{9,10}"
										value="{{ old('phone', $user->phone) }}">
									@include('alerts.feedback', ['field' => 'phone'])
								</div>
							</div>

							{{-- <div class="col-md-6">
								<div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
									<label for="role">{{ __('adminstaticword.Role') }} <sup style="color: red">*</sup></label>
									<select required name="role" id="role"
										class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }} select2bs4">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($roles as $role)
											<option value="{{ $role->name }}" {{ $role->name == $user->role ? 'selected' : '' }}>
												{{ $role->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'role'])
								</div>
							</div> --}}

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
										class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }} form-control select2bs4">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($states as $state)
											<option value="{{ $state->id }}"
												{{ $user->city ? ($state->id == $user->city->state_id ? 'selected' : '') : '' }}>
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
										class="form-control{{ $errors->has('city_id') ? ' is-invalid' : '' }} form-control select2bs4">
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

                            <div class="col-md-3 form-group">
								<label>{{ __('adminstaticword.Status') }}</label> <br>
								<div class="custom-switch">
									<input value="1" id="status" type="checkbox" name="status" class="custom-control-input"
										{{ $user->status == '1' ? 'checked' : '' }}>
									<label class="custom-control-label" for="status"></label>
								</div>
							</div>

							<div class="col-md-3    ">
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
							<div class="col-md-6" @if ($user->role != 'provider') style="display: none;" @endif id="rolebox">
								<div class="form-group{{ $errors->has('days[]') ? ' has-danger' : '' }}">
									<label for="days">{{ __('adminstaticword.Days') }} <sup style="color: red">*</sup></label>
									<select class="select2bs4 form-control{{ $errors->has('days[]') ? ' is-invalid' : '' }}" multiple
										name="days[]" id="days">
										@foreach ($days as $day)
											<option value="{{ $day->id }}"
												{{ in_array($day->id, $user->days->pluck('id')->toArray()) ? 'selected' : '' }}>
												{{ $day->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'days'])
								</div>
							</div>
						</div>
						<br>

						<div class="row">

							<div class="col-md-6 form-group">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.MapLatitude') }} <sup style="color: red">*</sup></label>
									<input type="text" name="latitude" id="latitude"
										class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}"
										value="{{ old('latitude', $user->latitude) }}">
									@include('alerts.feedback', ['field' => 'latitude'])
								</div>
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.MapLongitude') }} <sup style="color: red">*</sup></label>
									<input type="text" name="longitude" id="longitude"
										class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}"
										value="{{ old('longitude', $user->longitude) }}">
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
									 rows="10">{{ $user->details }}</textarea>
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
		const mapElement = document.getElementById('map');

		const latt = {{ $user->latitude !== null ? $user->latitude : 33.510414 }};
		const long = {{ $user->longitude !== null ? $user->longitude : 36.278336 }};

		const mapOptions = {
			center: {
				lat: latt,
				lng: long,
			},
			zoom: 15,
		};

		const map = new google.maps.Map(mapElement, mapOptions);

		// Add click event listener to the map
		google.maps.event.addListener(map, 'click', function(event) {
			const lat = event.latLng.lat();
			const lng = event.latLng.lng();

			// Update form fields with the clicked coordinates
			$('#latitude').val(lat);
			$('#longitude').val(lng);

			console.log('Latitude: ' + lat + ', Longitude: ' + lng);
		});

	}
</script>

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

<script type="text/javascript">
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
