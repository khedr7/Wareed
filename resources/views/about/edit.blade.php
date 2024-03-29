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
							<h3 class="card-title">{{ __('adminstaticword.About') }}</h3>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<form id="edit-terms" method="post" action="{{ route('about.admin.update') }}" autocomplete="off"
					enctype="multipart/form-data">
					<div class="card-body">
						@csrf

						@include('alerts.success')

						<div class="row">
							<div class="col-md-12">
								<label class="text-dark">{{ __('adminstaticword.English About') }}:
									<span class="text-danger">*</span></label>
								<input type="hidden" name="details_en" id="detail1">

								<!-- Container for CKEditor toolbar -->
								<div id="toolbar-container"></div>

								<!-- CKEditor content container -->
								<div name="details_en" id="editor" class="@error('terms') is-invalid @enderror"
									style="border: 1px solid #c4c4c4">
									@if ($about)
										{!! $about->getTranslation('details', 'en', false) !!}
									@else
										{{ __('adminstaticword.Enter') }}
									@endif
								</div>

								@error('terms')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						<br>

						<div class="row">
							<div class="col-md-12">
								<label class="text-dark">{{ __('adminstaticword.Arabic About') }}:
									<span class="text-danger">*</span></label>
								<input type="hidden" name="details_ar" id="detail2">

								<!-- Container for CKEditor toolbar -->
								<div id="toolbar-container2"></div>

								<!-- CKEditor content container -->
								<div name="details_ar" id="editor2" class="@error('terms') is-invalid @enderror"
									style="border: 1px solid #c4c4c4">
									@if ($about)
										{!! $about->getTranslation('details', 'ar', false) !!}
									@else
										{{ __('adminstaticword.Enter') }}
									@endif
								</div>

								@error('terms')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
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
