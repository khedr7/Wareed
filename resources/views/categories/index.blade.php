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
							<h3 class="card-title">{{ __('adminstaticword.Categories') }}</h3>
						</div>
						<div class="col-6 text-right">
							<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">
								{{ __('adminstaticword.AddCategory') }}</a>

						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<table id="example2" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									<span style="margin-left: 25px;">#</span>
								</th>
								<th>{{ __('adminstaticword.Image') }}</th>
								<th>{{ __('adminstaticword.Title') }}</th>
								<th>{{ __('adminstaticword.Action') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($categories as $category)
								<?php $i++; ?>
								<tr>
									<td>
										<span style="margin-left: 25px;"><?php echo $i; ?></span>
									</td>

									<td>
										<img width="75px" height="75px" src="{{ $category->image }}" alt="">
									</td>
									<td>
										{{ $category->name }}
									</td>
									<td>
										<button type="button" data-toggle="modal" data-target="#edit-category" data-category-id="{{ $category->id }}"
											data-name_en="{{ $category->getTranslation('name', 'en', false) }}"
											data-name_ar="{{ $category->getTranslation('name', 'ar', false) }}" rel="tooltip"
											class="btn btn-success btn-sm btn-icon edit-category">
											<i class="fa fa-pen" aria-hidden="true"></i>
										</button>

										<button type="button" data-toggle="modal" data-target="#delete-category"
											data-category-id="{{ $category->id }}" rel="tooltip" class="btn btn-danger btn-sm btn-icon del-category">
											<i class="fa fa-times" aria-hidden="true"></i>

										</button>
									</td>
								</tr>
							@endforeach

					</table>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- /.col -->
	</div>

	{{-- create Modal start --}}
	<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myModal">{{ __('adminstaticword.AddCategory') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>

				</div>
				<div class="modal-body">
					<form id="demo-form2" method="post" action="{{ route('categories.admin.store') }}" data-parsley-validate
						class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="row">
							<div class="col-md-12">
								<label for="c_name">{{ __('adminstaticword.English Name') }}:<sup style="color: red">*</sup></label>
								<input placeholder="{{ __('adminstaticword.English Name') }}" type="text" class="form-control" name="name_en"
									required="">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<label for="c_name">{{ __('adminstaticword.Arabic Name') }}:<sup style="color: red">*</sup></label>
								<input placeholder=" {{ __('adminstaticword.Arabic Name') }}" type="text" class="form-control" name="name_ar"
									required="">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
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
						</div>
						<br>
						<div class="form-group">
							<button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
								{{ __('Reset') }}</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
								{{ __('Create') }}</button>
						</div>
						<div class="clear-both"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	{{-- create Modal end --}}


	{{-- edit Modal start --}}
	<div class="modal fade" id="edit-category" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="edit-category">{{ __('adminstaticword.EditCountry') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>

				</div>
				<div class="modal-body">
					<form id="edit-s-form" method="post" action="{{ route('categories.admin.create') }}" data-parsley-validate
						class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="row">
							<div class="col-md-12">
								<label for="name_en">{{ __('adminstaticword.English Name') }}:<sup style="color: red">*</sup></label>
								<input id='name_en' placeholder="{{ __('adminstaticword.English Name') }}" type="text"
									class="form-control" name="name_en" required="" value="">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<label for="name_ar">{{ __('adminstaticword.Arabic Name') }}:<sup style="color: red">*</sup></label>
								<input id='name_ar' placeholder=" {{ __('adminstaticword.Arabic Name') }}" type="text"
									class="form-control" name="name_ar" required="" value="">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group"{{ $errors->has('image') ? ' has-danger' : '' }}>
									<label>{{ __('adminstaticword.Image') }}</label>
									<div class="input-group mb-3">
										<div class="custom-file">
											<input type="file" name="image" class="custom-file-input" id="image2" accept="image/*"
												aria-describedby="inputGroupFileAddon01" onchange="displayFileName2()">
											<label id="image22" class="custom-file-label" for="inputGroupFile01">{{ __('Choose file') }}</label>
											@include('alerts.feedback', ['field' => 'image'])

										</div>
									</div>
								</div>
							</div>
						</div>
						<br>

						<div class="form-group">
							<button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
								{{ __('Reset') }}</button>
							<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
								{{ __('Create') }}</button>
						</div>
						<div class="clear-both"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	{{-- edit Modal end --}}

	{{-- delete Modal start --}}
	<div class="modal fade bd-example-modal-sm" id="delete-category" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleSmallModalLabel">
						{{ __('Delete') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					{{-- <h4>{{ __('Are You Sure ?') }}</h4> --}}
					<p>{{ __('Do you really want to delete') }} ?<br>
						{{ __('This process cannot be undone.') }}</p>
				</div>
				<div class="modal-footer">
					<form id="del-s-form" method="post" action="" class="pull-right">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}
						<button type="reset" class="btn btn-secondary" data-dismiss="modal">{{ __('No') }}</button>
						<button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	{{-- delete Model ended --}}


@stop
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Include PNotify library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css"
	integrity="sha512-7nl+p1joxw4BaxI37ELCqOphI6r6RqSyP99ODeAP2E6EuZ5+xBaBelC6YLQejPmHWhlF5U++odEx+6yhm/IVnw=="
	crossorigin="anonymous" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js"
	integrity="sha512-dDguQu7KUV0H745sT2li8mTXz2K8mh3mkySZHb1Ukgee3cNqWdCFMFsDjYo9vRdFRzwBmny9RrylAkAmZf0ZtQ=="
	crossorigin="anonymous"></script>


<script type="text/javascript">
	$(function() {
		$("#example1").DataTable({
			"responsive": true,
			"lengthChange": true,
			"autoWidth": false,
			"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
		}).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

		$('#example2').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
			"columns": [{
					"width": "10%"
				},
				{
					"width": "25%"
				},
				{
					"width": "45%"
				},
				{
					"width": "20%"
				},
			]
		});
	});
</script>

<script>
	// $(document).ready(function() {
	// 	$("#checkboxAll").on('click', function() {
	// 		$('input.check').not(this).prop('checked', this.checked);
	// 	});
	// });

	$(document).on('click', '.del-category', function() {
		var categoryId = $(this).data('category-id');
		$('#del-s-form').attr('action', "{{ url('categories') }}/" + categoryId);
		$('#delete-category').modal('show');
	});

	$(document).on('click', '.edit-category', function() {
		var categoryId = $(this).data('category-id');
		var nameEn = $(this).data('name_en');
		var nameAr = $(this).data('name_ar');

		$('#category-id').val(categoryId);
		$('#name_en').val(nameEn);
		$('#name_ar').val(nameAr);

		$('#edit-s-form').attr('action', "{{ url('categories') }}/" + categoryId);
		$('#edit-category').modal('show');
	});
</script>

<script>
	function displayFileName() {
		var input = document.getElementById('image');
		var fileName = input.files[0].name;
		var label = document.querySelector('.custom-file-label');
		label.innerText = fileName;
	}
	function displayFileName2() {
        var input = document.getElementById('image2');
		var fileName = input.files[0].name;
		var label = document.querySelector('#image22');
		label.innerText = fileName;
	}
</script>

@if (session('success'))
	<script>
		$(document).ready(function() {
			var notification = new PNotify({
				title: 'Success',
				text: '{{ session('success') }}',
				type: 'success',
				styling: 'bootstrap3',
				addclass: 'bg-success',
				desktop: {
					desktop: true,
					icon: 'feather icon-thumbs-up'
				}
			});
			setTimeout(function() {
				notification.remove();
			}, 5000);
			notification.get().click(function() {
				notification.remove();
			});
		});
	</script>
@endif

@if (session('error'))
	<script>
		$(document).ready(function() {
			var notification = new PNotify({
				title: 'error',
				text: '{{ session('error') }}',
				type: 'error',
				styling: 'bootstrap3',
				addclass: 'bg-error',
				desktop: {
					desktop: true,
					icon: 'feather icon-thumbs-up'
				}
			});
			setTimeout(function() {
				notification.remove();
			}, 5000);
			notification.get().click(function() {
				notification.remove();
			});
		});
	</script>
@endif
