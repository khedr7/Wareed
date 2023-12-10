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
							<h3 class="card-title">{{ __('adminstaticword.Complaints') }}</h3>
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
								<th>{{ __('adminstaticword.User') }}</th>
								<th>{{ __('adminstaticword.Title') }}</th>
								<th>{{ __('adminstaticword.Details') }}</th>
								<th>{{ __('adminstaticword.Action') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($complaints as $complaint)
								<?php $i++; ?>
								<tr>
									<td>
										<span style="margin-left: 25px;"><?php echo $i; ?></span>
									</td>
									<td>
										{{-- <a href="{{ route('users.admin.edit', $complaint->user->id) }}"> --}}
										{{ $complaint->user->name }}
										{{-- </a> --}}
									</td>
									<td>
										{{ $complaint->title }}
									</td>
									<td>
										{{ $complaint->details }}
									</td>
									<td>
										<button type="button" data-toggle="modal" data-target="#show-complaint"
											data-complaint-id="{{ $complaint->id }}" rel="tooltip"
											class="btn btn-primary btn-sm btn-icon show-complaint">
											<i class="fa fa-eye" aria-hidden="true"></i>
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


	{{-- show complaint Modal start --}}
	<div class="modal fade" id="show-complaint" tabindex="-1" role="dialog" aria-labelledby="show-complaintLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">
						{{ __('adminstaticword.Details') }}
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-lg-12">
						<div class="card m-b-30">
							{{-- <div class="card-body py-5 message-scroll"> --}}
							<div class="card-body message-scroll">
								<div id="complaint-details">
									<!-- Content will be dynamically populated here -->
								</div>
								<div id="loader" style="display: none; text-align: center;">
									<img src="{{ asset('') }}img/heartbeat-loader.gif" alt="Loading...">
								</div>
							</div>
						</div>
						<div class="col-lg-3">
							<button type="button" data-toggle="modal" data-target="#myModal" data-complaint-id=""
								rel="tooltip" class="btn btn-success btn-sm btn-icon">
								{{ __('adminstaticword.Reply') }}
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- show complaint Modal end --}}


	{{-- create Modal start --}}
	<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-dialog-centered modal-v2" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<form id="demo-form2" method="post" action="{{ route('replies.admin.store') }}" data-parsley-validate
						class="form-horizontal form-label-left" autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="row">
							<div class="col-md-12">
								<textarea rows="4" type="text" class="form-control" name="details" required style="resize: none;"></textarea>
							</div>
						</div>
						<div class="form-group" style="margin-top:5px">
							<button type="button" class="btn btn-success" onclick="submitForm()">
								{{ __('Send') }}
							</button>
						</div>
						<div class="clear-both"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	{{-- create Modal end --}}

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
					"width": "10"
				},
				{
					"width": "20%"
				},
				{
					"width": "20%"
				},
				{
					"width": "30%",
				},
				{
					"width": "20%",
				},
			],
		});
	});
</script>

<script>
	var complaintData;

	$(document).on('click', '.show-complaint', function() {
		var complaintId = $(this).data('complaint-id');
		$('#show-complaint').modal('show');

		getDate(complaintId);

	});

	function getDate(complaintId) {

		$('#loader').show();

		$.ajax({
			url: '{{ url('complaints') }}/' + complaintId,
			method: 'GET',
			dataType: 'json',
			success: function(data) {
				complaintData = data;

				var detailsHtml =
					"<div class='row'>" +
					"<div class='col-lg-3'></div>" +
					"<div class='col-lg-9 text-right'>" +
					"<button class='btn btn-default' style='display: flex;flex-direction: column;'>" +
					"<span  style='color: blue'>" + data.complaint.user.name +
					" : </span>" +
					data.complaint.details +
					"</button>" +
					"<small >" + formatDate(data.complaint.created_at) + "</small>" +
					"</div>" +
					"</div> <br>";

				data.complaint.replies.forEach(element => {

					if (element.user_id == data.complaint.user_id) {
						detailsHtml +=
							"<div class='row'>" +
							"<div class='col-lg-3'></div>" +
							"<div class='col-lg-9 text-right'>" +
							"<button class='btn btn-default' style='display: flex;flex-direction: column;'>" +
							"<span  style='color: blue'>" + element.user
							.name + " : </span>" +
							element.details +
							"</button>" + "<small>" + formatDate(data.complaint
								.created_at) + "</small>" +
							"</div>" +
							"</div> <br>";
					} else {
						detailsHtml +=
							"<div class='row'>" +
							"<div class='col-lg-9'>" +
							"<button class='btn btn-primary' style='display: flex;flex-direction: column;'>" +
							"<span >" + element.user
							.name + " : </span>" +
							element.details +
							"</button>" + "<small class='text-left'>" + formatDate(data.complaint
								.created_at) + "</small>" +
							"</div>" +
							"<div class='col-lg-3'></div>" +
							"</div> <br>";
					}
				});

				$('#loader').hide();

				$('#complaint-details').html(detailsHtml);
			},
			error: function(error) {
				console.error('Error fetching data:', error);
				$('#loader').hide();
			}
		});
	}

	function submitForm() {
		// Serialize the form data
        console.log(complaintData.complaint.id);
		var formData = $("#demo-form2").serialize();
        formData += "&complaint_id=" + complaintData.complaint.id;
        console.log(formData);

		// Make an AJAX request
		$.ajax({
			type: "POST",
			url: $("#demo-form2").attr("action"),
			data: formData,
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

                $('#myModal').hide();
                getDate(complaintId);
			},
			error: function(data) {
				var notification = new PNotify({
					title: 'error',
					text: 'there is an error occured.',
					type: 'error',
					styling: 'bootstrap3', // Use Bootstrap 3 styling
					addclass: 'bg-error', // Add a class for custom styling
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
	}


	function formatDate(date) {
		// Convert to JavaScript Date object
		var date = new Date(date);

		// Format date without seconds using toLocaleString()
		var options = {
			year: 'numeric',
			month: 'numeric',
			day: 'numeric',
			hour: 'numeric',
			minute: 'numeric'
		};
		return date.toLocaleString('en-US', options);
	}

    $(document).on('click', '.edit-category', function() {
		var categoryId = $(this).data('category-id');

		$('#category-id').val(categoryId);

		$('#myModal').modal('show');
	});
</script>

<style>
	.message-scroll {
		overflow-y: scroll !important;
		max-height: 450px !important;

		&::-webkit-scrollbar {
			width: 5px;
		}

		&::-webkit-scrollbar-track {
			background-color: #eee;
		}

		&::-webkit-scrollbar-thumb {
			background-color: rgb(165, 160, 160);
		}
	}
</style>
<style>
	.modal-v2 {
		width: 490px;
		margin-left: 5px;
		top: 126px;
		padding: 0;
	}
</style>

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
