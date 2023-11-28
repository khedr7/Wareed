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
							<h3 class="card-title">{{ __('adminstaticword.Banners') }}</h3>
						</div>
						<div class="col-6 text-right">
							<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal">
								{{ __('adminstaticword.AddBanner') }}</a>
							<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#bulk_delete">
								{{ __('adminstaticword.Delete selected') }}</a>
						</div>
					</div>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<table id="example2" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>
									<label for='checkboxAll' class="form-check form-check-label material-checkbox">
										<input type='checkbox' id="checkboxAll" class='form-check-input check filled-in material-checkbox'
											name='checked[]' value="all">
										<span class="form-check-sign">
											<span class="check"></span>
										</span>
									</label>
									<span style="margin-left: 25px;">#</span>
								</th>
								<th>{{ __('adminstaticword.Image') }}</th>
								<th>{{ __('adminstaticword.Link') }}</th>
								<th>{{ __('adminstaticword.StartDate') }}</th>
								<th>{{ __('adminstaticword.ExpiryDate') }}</th>
								<th>{{ __('adminstaticword.Status') }}</th>
								<th>{{ __('adminstaticword.Action') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($banners as $banner)
								<?php $i++; ?>
								<tr>
									<td>
										<label for='checkbox{{ $banner->id }}' class="form-check form-check-label">
											<input type='checkbox' form='bulk_delete_form'
												class='check form-check-input filled-in material-checkbox-input' name='checked[]'
												value="{{ $banner->id }}" id='checkbox{{ $banner->id }}'>
											<span class="form-check-sign">
												<span class="check"></span>
											</span>
										</label>
										<span style="margin-left: 25px;"><?php echo $i; ?></span>
									</td>

									<td>
										<img style="vertical-align: bottom;" width="75%" height="75%" src="{{ $banner->image }}" alt="">
									</td>

									<td>
										<a href="{{ $banner->link }}">
											@if (strlen($banner->link) > 30)
												{{ substr($banner->link, 0, 30) }}...
											@else
												{{ $banner->link }}
											@endif
										</a>
									</td>

									<td>
										{{ $banner->start_date->format('d/m/Y') }}
									</td>

									<td>
										@if (isset($banner->expiration_date))
											{{ $banner->expiration_date->format('d/m/Y') }}
										@else
											-
										@endif
									</td>

									<td>
										<div class="custom-control custom-switch">
											<input id="status_{{ $banner->id }}" type="checkbox" data-id="{{ $banner->id }}" name="status"
												onchange="bannerstatus('{{ $banner->id }}')" class="custom-control-input"
												{{ $banner->status == '1' ? 'checked' : '' }}>
											<label class="custom-control-label" for="status_{{ $banner->id }}"></label>
										</div>
									</td>

									<td>
										<button type="button" data-toggle="modal" data-target="#edit-banner" data-banner-id="{{ $banner->id }}"
											data-link="{{ $banner->link }}" data-start_date="{{ $banner->start_date->format('Y-m-d') }}"
											data-expiration_date="{{ isset($banner->expiration_date) ? $banner->expiration_date->format('Y-m-d') : null }}"
											data-status="{{ $banner->status }}" rel="tooltip" class="btn btn-success btn-sm btn-icon edit-banner">
											<i class="fa fa-pen" aria-hidden="true"></i>
										</button>

										<button type="button" data-toggle="modal" data-target="#delete-banner" data-banner-id="{{ $banner->id }}"
											rel="tooltip" class="btn btn-danger btn-sm btn-icon del-banner">
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
					<h5 class="modal-title" id="myModal">{{ __('adminstaticword.AddBanner') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>

				</div>
				<div class="modal-body">
					<form id="demo-form2" method="post" action="{{ route('banners.admin.store') }}" data-parsley-validate
						class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="row">
							<div class="col-md-12">
								<label for="link">{{ __('adminstaticword.Link') }}:<sup style="color: red">*</sup></label>
								<input placeholder="https://example.com" type="url" class="form-control" name="link" required
									value="{{ old('link') }}">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.StartDate') }} <sup style="color: red">*</sup></label>
									<input required type="date" name="start_date"
										class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}"
										onchange="updateExpirationDateMin(this.value)">
									@include('alerts.feedback', ['field' => 'start_date'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group{{ $errors->has('expiration_date') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.ExpiryDate') }} <sup style="color: red">*</sup></label>
									<input type="date" name="expiration_date"
										class="form-control{{ $errors->has('expiration_date') ? ' is-invalid' : '' }}"
										value="{{ old('expiration_date') }}" id="expiration_date_1">
									@include('alerts.feedback', ['field' => 'expiration_date'])
								</div>
							</div>
						</div>

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
						<div class="row">
							<div class="col-md-12 form-group">
								<label>{{ __('adminstaticword.Status') }}</label> <br>
								<div class="custom-switch">
									<input type="checkbox" name="status" value="1" class="custom-control-input">
									<label class="custom-control-label" for="status"></label>
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
				</div>
				</form>
			</div>
		</div>
	</div>
	</div>
	{{-- create Modal end --}}

	{{-- edit Modal start --}}
	<div class="modal fade" id="edit-banner" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ __('adminstaticword.EditBanner') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>

				</div>
				<div class="modal-body">
					<form id="edit-b-form" method="post" action="" data-parsley-validate
						class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="row">
							<div class="col-md-12">
								<label for="link">{{ __('adminstaticword.Link') }}:<sup style="color: red">*</sup></label>
								<input id="link" placeholder="https://example.com" type="url" class="form-control" name="link"
									required value="{{ old('link') }}">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group{{ $errors->has('start_date') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.StartDate') }} <sup style="color: red">*</sup></label>
									<input id="start_date" required type="date" name="start_date"
										class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}"
										onchange="updateExpirationDateMin2(this.value)">
									@include('alerts.feedback', ['field' => 'start_date'])
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group{{ $errors->has('expiration_date') ? ' has-danger' : '' }}">
									<label>{{ __('adminstaticword.ExpiryDate') }} <sup style="color: red">*</sup></label>
									<input id="expiration_date" type="date" name="expiration_date"
										class="form-control{{ $errors->has('expiration_date') ? ' is-invalid' : '' }}"
										value="{{ old('expiration_date') }}" id="expiration_date">
									@include('alerts.feedback', ['field' => 'expiration_date'])
								</div>
							</div>
						</div>

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
						<div class="row">
							<div class="col-md-12 form-group">
								<label>{{ __('adminstaticword.Status') }}</label> <br>
								<div class="custom-switch">
									<input id="status" type="checkbox" name="status" value="1" class="custom-control-input">
									<label class="custom-control-label" for="status"></label>
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
	<div class="modal fade bd-example-modal-sm" id="delete-banner" tabindex="-1" role="dialog" aria-hidden="true">
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

	{{-- bulk delete Modal start --}}
	<div id="bulk_delete" class="delete-modal modal fade" role="dialog">
		<div class="modal-dialog modal-sm">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleSmallModalLabel">
						{{ __('Delete selected') }}</h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="delete-icon"></div>
				</div>

				<div class="modal-body">
					<p>{{ __('Do you really want to delete') }} ?<br>
						{{ __('This process cannot be undone.') }}</p>
				</div>
				<div class="modal-footer">
					<form id="bulk_delete_form" method="post" action="{{ route('banners.admin.bulkDelete') }}">
						@csrf
						@method('POST')
						<button type="reset" class="btn btn-secondary translate-y-3"
							data-dismiss="modal">{{ __('No') }}</button>
						<button type="submit" class="btn btn-danger">{{ __('Yes') }}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	{{-- bulk delete Model ended --}}

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
					"width": "20%"
				},
				{
					"width": "20%"
				},
				{
					"width": "15%"
				},
				{
					"width": "15%"
				},
				{
					"width": "10%"
				},
				{
					"width": "10%"
				},
			]
		});
	});
</script>

<script>
	$(document).ready(function() {
		$("#checkboxAll").on('click', function() {
			$('input.check').not(this).prop('checked', this.checked);
		});
	});

	$(document).on('click', '.del-banner', function() {
		var bannerId = $(this).data('banner-id');
		$('#del-s-form').attr('action', "{{ url('banners') }}/" + bannerId);
		$('#delete-banner').modal('show');
	});

	$(document).on('click', '.edit-banner', function() {
		var bannerId = $(this).data('banner-id');
		var link = $(this).data('link');
		var start_date = $(this).data('start_date');
		var expiration_date = $(this).data('expiration_date');
		var status = $(this).data('status');

		$('#banner-id').val(bannerId);
		$('#link').val(link);
		$('#start_date').val(start_date);
		$('#expiration_date').val(expiration_date);
        document.getElementById('expiration_date').min = start_date;

		$('#status').val(status);

		if (status == 1) {
			$('#status').prop('checked', true);
		} else {
			$('#status').prop('checked', false);
		}

		$('#edit-b-form').attr('action', "{{ url('banners') }}/" + bannerId);
		$('#edit-banner').modal('show');
	});

	function bannerstatus(id) {
		var status = $(this).prop('checked') == true ? 1 : 0;

		$.ajax({
			type: "GET",
			dataType: "json",
			url: "{{ url('/banners/status/') }}/" + id,
			data: {
				'status': status,
				'id': id
			},

			success: function(data) {
				var notification = new PNotify({
					title: 'success',
					text: 'Status Update Successfully',
					type: 'success',
					styling: 'bootstrap3', // Use Bootstrap 3 styling
					addclass: 'bg-success', // Add a class for custom styling
					desktop: {
						desktop: true,
						icon: 'feather icon-thumbs-down'
					}
				});
				setTimeout(function() {
					notification.remove();
				}, 5000);
				notification.get().click(function() {
					notification.remove();
				});
			}
		});
	};
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

	function updateExpirationDateMin(startDate) {
		// Get the current value of expiration_date
		var expirationDate = document.getElementById('expiration_date_1').value;

		// Set the minimum value of expiration_date to the selected start date
		document.getElementById('expiration_date_1').min = startDate;

		// Reset the value of expiration_date only if the selected start date is after the current value
		if (new Date(startDate) > new Date(expirationDate)) {
			document.getElementById('expiration_date_1').value = "";
		}
	}

	function updateExpirationDateMin2(startDate) {
		// Get the current value of expiration_date
		var expirationDate = document.getElementById('expiration_date').value;

		// Set the minimum value of expiration_date to the selected start date
		document.getElementById('expiration_date').min = startDate;

		// Reset the value of expiration_date only if the selected start date is after the current value
		if (new Date(startDate) > new Date(expirationDate)) {
			document.getElementById('expiration_date').value = "";
		}
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
