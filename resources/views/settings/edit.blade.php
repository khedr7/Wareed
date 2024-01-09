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
							<h3 class="card-title">{{ __('adminstaticword.Setting') }}</h3>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<form id="edit-terms" method="post" action="{{ route('settings.admin.update') }}" autocomplete="off"
					enctype="multipart/form-data">
					<div class="card-body">
						@csrf

						@include('alerts.success')

						<div class="row">
							<div class="col-md-6">
								<div class="form-group{{ $errors->has('point_price') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.point_price') }} <sup style="color: red">*</sup></label>
									<input required type="number" step="0.001" name="point_price"
										class="form-control{{ $errors->has('point_price') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.point_price') }}" min="0"
										@if ($setting) value="{{ old('point_price', $setting->point_price) }}"
                                        @else
										value="{{ old('point_price') }}" @endif>
									@include('alerts.feedback', ['field' => 'point_price'])
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group{{ $errors->has('wareed_service_percent') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.wareed_service_percent') }} <sup style="color: red">*</sup></label>
									<input required type="number" step="0.001" name="wareed_service_percent" max="100"
										class="form-control{{ $errors->has('wareed_service_percent') ? ' is-invalid' : '' }}"
										placeholder="{{ __('adminstaticword.wareed_service_percent') }}" min="0"
										@if ($setting) value="{{ old('wareed_service_percent', $setting->wareed_service_percent) }}"
                                        @else
                                         value="{{ old('wareed_service_percent') }}" @endif>
									@include('alerts.feedback', ['field' => 'wareed_service_percent'])
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
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/decoupled-document/ckeditor.js"></script>


<script>
	document.addEventListener('DOMContentLoaded', (event) => {
		// Initialize CKEditor
		DecoupledEditor
			.create(document.querySelector('#editor'))
			.then(editor => {
				// Get the toolbar container and CKEditor toolbar element
				const toolbarContainer = document.querySelector('#toolbar-container');

				// Check if both elements exist before appending
				if (toolbarContainer && editor.ui.view.toolbar.element) {
					toolbarContainer.appendChild(editor.ui.view.toolbar.element);
				} else {
					console.error('Either toolbarContainer or editor.ui.view.toolbar.element is null.');
				}

				// Override createUploadAdapter to use the custom adapter
				class Base64UploadAdapter {
					constructor(loader) {
						this.loader = loader;
					}
					upload() {
						return this.loader.file
							.then(file => this.base64(file))
							.then(base64 => {
								return new Promise((resolve, reject) => {
									resolve({
										default: base64
									});
								});
							});
					}
					base64(file) {
						return new Promise((resolve, reject) => {
							const reader = new FileReader();
							reader.onloadend = () => resolve(reader.result);
							reader.onerror = reject;
							reader.readAsDataURL(file);
						});
					}
				}

				editor.plugins.get('FileRepository').createUploadAdapter = loader => {
					return new Base64UploadAdapter(loader);
				};

				// Form submission logic
				const form = document.querySelector('#edit-terms');
				const editorContentInput = document.querySelector('#detail1');

				form.addEventListener('submit', function(event) {
					editorContentInput.value = editor.getData();
				});
			})
			.catch(error => {
				console.error(error);
			});
	});
</script>

<script>
	document.addEventListener('DOMContentLoaded', (event) => {
		// Initialize CKEditor
		DecoupledEditor
			.create(document.querySelector('#editor2'))
			.then(editor => {
				// Get the toolbar container and CKEditor toolbar element
				const toolbarContainer = document.querySelector('#toolbar-container2');

				// Check if both elements exist before appending
				if (toolbarContainer && editor.ui.view.toolbar.element) {
					toolbarContainer.appendChild(editor.ui.view.toolbar.element);
				} else {
					console.error('Either toolbarContainer or editor.ui.view.toolbar.element is null.');
				}

				// Override createUploadAdapter to use the custom adapter
				class Base64UploadAdapter {
					constructor(loader) {
						this.loader = loader;
					}
					upload() {
						return this.loader.file
							.then(file => this.base64(file))
							.then(base64 => {
								return new Promise((resolve, reject) => {
									resolve({
										default: base64
									});
								});
							});
					}
					base64(file) {
						return new Promise((resolve, reject) => {
							const reader = new FileReader();
							reader.onloadend = () => resolve(reader.result);
							reader.onerror = reject;
							reader.readAsDataURL(file);
						});
					}
				}

				editor.plugins.get('FileRepository').createUploadAdapter = loader => {
					return new Base64UploadAdapter(loader);
				};

				// Form submission logic
				const form = document.querySelector('#edit-terms');
				const editorContentInput = document.querySelector('#detail2');

				form.addEventListener('submit', function(event) {
					editorContentInput.value = editor.getData();
				});
			})
			.catch(error => {
				console.error(error);
			});
	});
</script>
