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
							<h3 class="card-title">{{ __('adminstaticword.AddCity') }}</h3>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<form id="create-city" method="post" action="{{ route('cities.admin.store') }}" autocomplete="off"
					enctype="multipart/form-data">
					<div class="card-body">
						@csrf

						@include('alerts.success')
						<div class="row">
							<input hidden type="text" name="state_id" value="{{ $stateId }}">

							{{-- <div class="col-md-6">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('English Name') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="name_en"
										class="form-control{{ $errors->has('name_en') ? ' is-invalid' : '' }}" placeholder="{{ __('English Name') }}"
										value="{{ old('name_en') }}">
									@include('alerts.feedback', ['field' => 'name_en'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('Arabic Name') }} <sup style="color: red">*</sup></label>
									<input required type="text" name="name_ar"
										class="form-control{{ $errors->has('name_ar') ? ' is-invalid' : '' }}" placeholder="{{ __('Arabic Name') }}"
										value="{{ old('name_ar') }}">
									@include('alerts.feedback', ['field' => 'name_ar'])
								</div>
							</div> --}}

							<div id="cityFields">
								<div class="city-group">
									<div class="city-field">
										<label for="name_en[]">Name (English):</label>
										<input type="text" name="name_en[]" required>

										<label for="name_ar[]">Name (Arabic):</label>
										<input type="text" name="name_ar[]" required>
										<button type="button" onclick="addCityGroup(this)">+</button>
										<button type="button" onclick="removeCityGroup(this)">-</button>
									</div>
								</div>
							</div>

						</div>

						<br>
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

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- jquery-validation -->
<script src="{{ asset('vendor/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-validation/additional-methods.min.js') }}"></script>

<script>
	function addCityGroup(button) {
		var cityFields = document.getElementById('cityFields');
		var newCityGroup = document.createElement('div');
		newCityGroup.className = 'city-group';

		newCityGroup.innerHTML = `
            <div class="city-field">
                <label for="name_en[]">Name (English):</label>
                <input type="text" name="name_en[]" required>

                <label for="name_ar[]">Name (Arabic):</label>
                <input type="text" name="name_ar[]" required>
                <button type="button" onclick="addCityGroup(this)">+</button>
                <button type="button" onclick="removeCityGroup(this)">-</button>
            </div>
        `;

		cityFields.appendChild(newCityGroup);
	}

	function removeCityGroup(button) {
		var cityFields = document.getElementById('cityFields');
		var cityGroups = document.getElementsByClassName('city-group');

		// Make sure there is more than one city group before removal
		if (cityGroups.length > 1) {
			button.parentNode.parentNode.removeChild(button.parentNode);
		}
	}
</script>
