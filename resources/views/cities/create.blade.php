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
						<input hidden type="text" name="state_id" value="{{ $stateId }}">

						<div id="cityFields">
							<div class="city-group">
								<div class="city-field">
									<div class="row">
										<div class="col-md-5">
											<label for="name_en[]">{{ __('adminstaticword.English Name') }}:</label>
											<input class="form-control" type="text" name="name_en[]" required>
										</div>
										<div class="col-md-7">
											<label for="name_ar[]">{{ __('adminstaticword.Arabic Name') }}:</label>
											<div class="row">
												<div class="col-md-10">
													<input class="form-control" type="text" name="name_ar[]" required>
												</div>
												<div class="col-md-2">
													<button class="btn btn-primary" type="button" onclick="addCityGroup(this)">+</button>
													<button class="btn btn-danger" type="button" onclick="removeCityGroup(this)">-</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<br>
						<div class="">
							<button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
						</div>
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
	var count = 1;

	function addCityGroup(button) {
		var cityFields = document.getElementById('cityFields');
		var newCityGroup = document.createElement('div');
		newCityGroup.className = 'city-group';

		newCityGroup.innerHTML = `
        <div class="city-field">
            <div class="row">
                <div class="col-md-5">
                    <label for="name_en[]">{{ __('adminstaticword.English Name') }}:</label>
                    <input class="form-control" type="text" name="name_en[]" required>
                </div>
                <div class="col-md-7">
                    <label for="name_ar[]">{{ __('adminstaticword.Arabic Name') }}:</label>
                    <div class="row">
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="name_ar[]" required>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" type="button" onclick="addCityGroup(this)">+</button>
                            <button class="btn btn-danger" type="button" onclick="removeCityGroup(this)">-</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;

		cityFields.appendChild(newCityGroup);
		count++
	}

	function removeCityGroup(button) {
		var cityFields = document.getElementById('cityFields');
		var cityGroups = document.getElementsByClassName('city-group');

		// Make sure there is more than one city group before removal
		if (count > 1) {
			button.parentNode.parentNode.parentNode.parentNode.parentNode.removeChild(button.parentNode.parentNode
				.parentNode.parentNode);
			count = count - 1
		}
	}
</script>
