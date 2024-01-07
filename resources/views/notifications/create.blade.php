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
							<h3 class="card-title">{{ __('adminstaticword.AddNotification') }}</h3>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<form id="create-user" method="post" action="{{ route('notifications.admin.store') }}" autocomplete="off"
					enctype="multipart/form-data">
					<div class="card-body">
						@csrf

						@include('alerts.success')
						<div class="row">
							<div class="col-md-4">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.English Title') }}<sup style="color: red">*</sup></label>
									<input required type="text" name="title_en"
										class="form-control{{ $errors->has('title_en') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.English Title') }}" value="{{ old('title_en') }}">
									@include('alerts.feedback', ['field' => 'title_en'])
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group @error('code') is-invalid @enderror">
									<label>{{ __('adminstaticword.Arabic Title') }}<sup style="color: red">*</sup></label>
									<input required type="text" name="title_ar"
										class="form-control{{ $errors->has('title_ar') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.Arabic Title') }}" value="{{ old('title_ar') }}">
									@include('alerts.feedback', ['field' => 'title_ar'])
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group{{ $errors->has('to_type') ? ' has-danger' : '' }}">
									<label for="to_type">{{ __('adminstaticword.To') }} <sup style="color: red">*</sup></label>
									<select required name="to_type" id="to_type"
										class="form-control{{ $errors->has('to_type') ? ' is-invalid' : '' }} select2bs4">
										<option selected disabled value="none">{{ __('select') }}</option>
										<option value="provider" {{ 'provider' == old('to_type') ? 'selected' : '' }}>
											{{ __('adminstaticword.Providers') }}
										</option>
										<option value="user" {{ 'user' == old('to_type') ? 'selected' : '' }}>
											{{ __('adminstaticword.Users') }}
										</option>
										<option value="user_provider" {{ 'user_provider' == old('to_type') ? 'selected' : '' }}>
											{{ __('adminstaticword.Providers') }} - {{ __('adminstaticword.Users') }}
										</option>
									</select>
									@include('alerts.feedback', ['field' => 'role'])
								</div>
							</div>
						</div>

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
									<label for="details_ar">{{ __('adminstaticword.Arabic Detail') }}</label>
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


<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

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
	});
</script>
