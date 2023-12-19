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
							<h3 class="card-title">{{ __('adminstaticword.Requests') }}</h3>
						</div>
						<div class="col-6 text-right">
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
								<th>{{ __('adminstaticword.User') }}</th>
								<th>{{ __('adminstaticword.Title') }}</th>
								<th>{{ __('adminstaticword.Detail') }}</th>
								<th>{{ __('adminstaticword.Action') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($requests as $request)
								<?php $i++; ?>
								<tr>
									<td>
										<label for='checkbox{{ $request->id }}' class="form-check form-check-label">
											<input type='checkbox' form='bulk_delete_form'
												class='check form-check-input filled-in material-checkbox-input' name='checked[]' value="{{ $request->id }}"
												id='checkbox{{ $request->id }}'>
											<span class="form-check-sign">
												<span class="check"></span>
											</span>
										</label>
										<span style="margin-left: 25px;"><?php echo $i; ?></span>
									</td>
									<td>
										<p>
											{{ $request->user->name }}
										</p>
									</td>
									<td>
										<p>
											{{ $request->title }}
										</p>
									</td>
									<td>
										@if (strlen($request->details) > 50)
											<p>
												<span class="short-text">{{ substr($request->details, 0, 50) }}...</span>
												<span class="full-text" style="display: none;">{{ $request->details }}</span>

												<a href="#" class="read-more-link">{{ __('adminstaticword.Read More') }}</a>
												<a href="#" class="read-less-link" style="display: none;">{{ __('adminstaticword.Read Less') }}</a>
											</p>
										@else
											<p>{{ $request->details }}</p>
										@endif
									</td>
									<td>
										<button type="button" data-toggle="modal" data-target="#delete-request" data-request-id="{{ $request->id }}"
											rel="tooltip" class="btn btn-danger btn-sm btn-icon del-request">
											<i class="fa fa-times" aria-hidden="true"></i>
										</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
		</div>
		<!-- /.col -->
	</div>

	{{-- delete Modal start --}}
	<div class="modal fade bd-example-modal-sm" id="delete-request" tabindex="-1" role="dialog" aria-hidden="true">
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
					<form id="del-u-form" method="post" action="" class="pull-right">
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
					<form id="bulk_delete_form" method="post" action="{{ route('serviceRequests.admin.bulkDelete') }}">
						@csrf
						@method('POST')
						<button type="reset" class="btn btn-secondary translate-y-3" data-dismiss="modal">{{ __('No') }}</button>
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
					"width": "15%"
				},
				{
					"width": "20%"
				},
				{
					"width": "45%"
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

	$(document).on('click', '.del-request', function() {
		var requestId = $(this).data('request-id');
		$('#del-u-form').attr('action', "{{ url('service-requests') }}/" + requestId);
		$('#delete-request').modal('show');
	});
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const readMoreLink = document.querySelector('.read-more-link');
		const readLessLink = document.querySelector('.read-less-link');
		const shortText = document.querySelector('.short-text');
		const fullText = document.querySelector('.full-text');

		readMoreLink.addEventListener('click', function(event) {
			event.preventDefault();
			shortText.style.display = 'none';
			fullText.style.display = 'inline';
			readMoreLink.style.display = 'none';
			readLessLink.style.display = 'inline';
		});

		readLessLink.addEventListener('click', function(event) {
			event.preventDefault();
			shortText.style.display = 'inline';
			fullText.style.display = 'none';
			readMoreLink.style.display = 'inline';
			readLessLink.style.display = 'none';
		});
	});
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
