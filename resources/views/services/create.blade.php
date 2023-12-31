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
							<h3 class="card-title">{{ __('adminstaticword.AddService') }}</h3>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<form id="create-service" method="post" action="{{ route('services.admin.store') }}" autocomplete="off"
					enctype="multipart/form-data">
					<div class="card-body">
						@csrf

						@include('alerts.success')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.English Name') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="name_en"
										class="form-control{{ $errors->has('name_en') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.English Name') }}" value="{{ old('name_en') }}">
									@include('alerts.feedback', ['field' => 'name_en'])
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.Arabic Name') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="name_ar"
										class="form-control{{ $errors->has('name_ar') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Arabic Name') }}" value="{{ old('name_ar') }}">
									@include('alerts.feedback', ['field' => 'name_ar'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('category_id') ? ' has-danger' : '' }} form-group">
									<label>{{ __('adminstaticword.Category') }} <sup style="color: red">*</sup></label>
									<select name="category_id" id="category_id"
										class="form-control{{ $errors->has('category_id') ? ' is-invalid' : '' }} form-control select2bs4">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($categories as $category)
											<option value="{{ $category->id }}" {{ $category->id == old('category_id') ? 'selected' : '' }}>
												{{ $category->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'category_id'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('price') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.Price') }} <sup style="color: red">*</sup></label>
									<input required type="number" step="0.001" name="price"
										class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Price') }}" min="0" value="{{ old('price') }}">
									@include('alerts.feedback', ['field' => 'price'])
								</div>
							</div>

							{{-- <div class="col-md-6">
								<div class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.User') }} <sup style="color: red">*</sup></label>
									<select required name="user_id" id="user_id"
										class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }} select2bs4">
										<option selected disabled value="none">{{ __('select') }}</option>
										@foreach ($users as $user)
											<option value="{{ $user->id }}" {{ $user->id == old('user_id') ? 'selected' : '' }}>
												{{ $user->name }}
											</option>
										@endforeach
									</select>
									@include('alerts.feedback', ['field' => 'user'])
								</div>
							</div> --}}
						</div>

						<div class="row">

							<div class="col-md-6">
								<div class="form-group"{{ $errors->has('image') ? ' has-danger' : '' }}>
									<label>{{ __('adminstaticword.Image') }}</label>
									<div class="input-group mb-3">
										<div class="custom-file">
											<input required type="file" name="image" class="custom-file-input" id="image" accept="image/*"
												aria-describedby="inputGroupFileAddon01" onchange="displayFileName()">
											<label class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											@include('alerts.feedback', ['field' => 'image'])

										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6 form-group">
								<label>{{ __('adminstaticword.Keywords') }}:</span></label>
								<select class="form-control" id="keys" name="keys[]" multiple="multiple"
									placeholder="">
									<option></option>
								</select>
							</div>

						</div>
						<div class="row">

							<div class="col-md-6 form-group">
								<label>{{ __('adminstaticword.Status') }}</label> <br>
								<div class="custom-switch">
									<input id="status" type="checkbox" name="status" value="1" class="custom-control-input">
									<label class="custom-control-label" for="status"></label>
								</div>
							</div>

							<div class="col-md-6 form-group">
								<label>{{ __('adminstaticword.Featured') }}</label> <br>
								<div class="custom-switch">
									<input id="featured" type="checkbox" value="1" name="featured" class="custom-control-input">
									<label class="custom-control-label" for="featured"></label>
								</div>
							</div>

						</div>
						<br>

						{{-- <div class="row">
							<div class="col-md-6 form-group">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.MapLatitude') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="latitude" id="latitude"
										class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" value="{{ old('latitude') }}">
									@include('alerts.feedback', ['field' => 'latitude'])
								</div>
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.MapLongitude') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="longitude" id="longitude"
										class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" value="{{ old('longitude') }}">
									@include('alerts.feedback', ['field' => 'longitude'])
								</div>
							</div>

							<div class="col-md-6 form-group">
								<div class="map" id="map"></div>

							</div>
						</div> --}}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('details_en') ? ' has-danger' : '' }}">
									<label for="details_en">{{ __('adminstaticword.English Detail') }}</label>
									<textarea id="summernote" class="form-control{{ $errors->has('details_en') ? ' is-invalid' : '' }}" name="details_en"
									 rows="10">{{ old('details_en') }}</textarea>
									@include('alerts.feedback', ['field' => 'details_en'])
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('details_ar') ? ' has-danger' : '' }}">
									<label for="details">{{ __('adminstaticword.Arabic Detail') }}</label>
									<textarea id="summernote" class="form-control{{ $errors->has('details_ar') ? ' is-invalid' : '' }}" name="details_ar"
									 rows="10">{{ old('details_ar') }}</textarea>
									@include('alerts.feedback', ['field' => 'details_ar'])
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

<script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/additional-methods.min.js') }}"></script>

<script>
	$(function() {
		//Initialize Select2 Elements
		$('.select2').select2()

		//Initialize Select2 Elements
		$('.select2bs4').select2({
			theme: 'bootstrap4'
		})
		$("#keys").select2({
			tags: true,
			tokenSeparators: [','],
			theme: 'bootstrap4'
		});
	});
</script>

<script>
	function displayFileName() {
		var input = document.getElementById('image');
		var fileName = input.files[0].name;
		var label = document.querySelector('.custom-file-label');
		label.innerText = fileName;
	}
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
