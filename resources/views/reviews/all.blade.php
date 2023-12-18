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
							<h3 class="card-title">{{ __('adminstaticword.Reviews') }}</h3>
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
								<th>{{ __('adminstaticword.Provider') }}</th>
								<th>{{ __('adminstaticword.User') }}</th>
								<th>{{ __('adminstaticword.Title') }}</th>
								<th>{{ __('adminstaticword.Rating') }}</th>
								<th>{{ __('adminstaticword.Approved') }}</th>
								<th>{{ __('adminstaticword.Action') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($reviews as $review)
								<?php $i++; ?>
								<tr>
									<td>
										<label for='checkbox{{ $review->id }}' class="form-check form-check-label">
											<input type='checkbox' form='bulk_delete_form'
												class='check form-check-input filled-in material-checkbox-input' name='checked[]'
												value="{{ $review->id }}" id='checkbox{{ $review->id }}'>
											<span class="form-check-sign">
												<span class="check"></span>
											</span>
										</label>
										<span style="margin-left: 25px;"><?php echo $i; ?></span>
									</td>
									<td>
										<p>
											{{ $review->reviewrateable->name }}
										</p>
									</td>
									<td>
										<p>
											{{ $review->author->name }}
										</p>
									</td>

									<td>
										<p>
											{{ $review->title }}
										</p>
									</td>
									<td>
										<p>
											{{ $review->rating }}
										</p>
									</td>
									<td>
										<div class="custom-control custom-switch">
											<input id="approved_{{ $review->id }}" type="checkbox" data-id="{{ $review->id }}" name="approved"
												onchange="reviewstatus('{{ $review->id }}')" class="custom-control-input"
												{{ $review->approved == '1' ? 'checked' : '' }}>
											<label class="custom-control-label" for="approved_{{ $review->id }}"></label>
										</div>
									</td>
									<td>
										<button type="button" data-toggle="modal" data-target="#show-review" data-user-id="{{ $review->reviewrateable->id }}"
											data-user-name="{{ $review->reviewrateable->name }}" data-provider-name="{{ $review->author->name }}"
											data-title="{{ $review->title }}" data-rating="{{ $review->rating }}" data-body="{{ $review->body }}"
											data-approved="{{ $review->approved }}" data-created_at="{{ $review->created_at }}" rel="tooltip"
											class="btn btn-primary btn-sm btn-icon show-review">
											<i class="fa fa-eye" aria-hidden="true"></i>
										</button>

										<button type="button" data-toggle="modal" data-target="#delete-review" data-review-id="{{ $review->id }}"
											rel="tooltip" class="btn btn-danger btn-sm btn-icon del-review">
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

	{{-- show user Modal start --}}
	<div class="modal fade" id="show-review" tabindex="-1" role="dialog" aria-labelledby="show-reviewLabel"
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
							<div class="card-body py-5 message-scroll">
								<div class="row">
									<div class="col-lg-12">
										<h4 class="text-center">
										</h4>
										<div class="table-responsive">
											<table class="table table-borderless mb-0 user-table table-striped">
												<tbody>
													<tr>
														<th scope="row" class="p-1 col-md-6">
															{{ __('adminstaticword.User') }} :</th>
														<td class="p-1 col-md-6" id="user-name">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1 col-md-6">
															{{ __('adminstaticword.Provider') }} :</th>
														<td class="p-1 col-md-6" id="provider-name">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Rating') }} :</th>
														<td class="p-1" id="review-Rating">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Approved') }} :</th>
														<td class="p-1" id="review-approved">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.CreatedAt') }} :</th>
														<td class="p-1" id="review-Created_at">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Title') }} :</th>
														<td class="p-1" id="review-title">
														</td>
													</tr>
													<tr>
														<td class="p-1" colspan="2">
															<div style="display: flex; justify-content: flex-end; flex-direction: column;">
																<div><b>{{ __('adminstaticword.Details') }} :</b></div>
																<div id="review-body" class="mb-0">
																</div>
															</div>
														</td>
													</tr>

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- show user Modal end --}}

	{{-- delete Modal start --}}
	<div class="modal fade bd-example-modal-sm" id="delete-review" tabindex="-1" role="dialog" aria-hidden="true">
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
					<form id="bulk_delete_form" method="post" action="{{ route('users.admin.reviewsBulkDelete') }}">
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
	crossorigin="anonymous">
</script>


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
					"width": "5%"
				},
				{
					"width": "20%"
				},
				{
					"width": "20%"
				},
				{
					"width": "20%"
				},
				{
					"width": "10%"
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

	$(document).on('click', '.show-review', function() {
		var userId = $(this).data('user-id');
		var userName = $(this).data('user-name');
		var providerName = $(this).data('provider-name');
		var rating = $(this).data('rating');
		var createdAt = $(this).data('created_at');
		var title = $(this).data('title');
		var body = $(this).data('body');
		var approved = $(this).data('approved');



		$('#user-name').text(userName);
		$('#provider-name').text(providerName);
		$('#review-Rating').text(rating);
		$('#review-Created_at').text(createdAt);
		$('#review-title').text(title);
		$('#review-body').text(body);

		if (approved == 1) {
			$('#review-approved').text('{{ __('adminstaticword.Yes') }}');
		} else {
			$('#review-approved').text('{{ __('adminstaticword.No') }}');
		}

		$('#show-review').modal('show');
	});

	$(document).on('click', '.show-services', function() {
		var userServices = $(this).data('user-services');
		var detailsHtml = '';
		var counter = 1;

		if (userServices.length == 0) {
			detailsHtml +=
				"<tr>" +
				"<th scope='row' class='p-1 col-md-12'>" +
				'There is no services' +
				"</th>" +
				"/td> </tr>"
		} else {
			userServices.forEach(element => {
				detailsHtml +=
					"<tr>" +
					"<th scope='row' class='p-1 col-md-12'>" +
					counter + ". " + element.name +
					"</th>" +
					"/td> </tr>"
			});
			counter++;
		}
		$('#show-service').html(detailsHtml);
		$('#show-services').modal('show');
	});

    $(document).on('click', '.del-review', function() {
		var reviewId = $(this).data('review-id');
		$('#del-u-form').attr('action', "{{ url('users/reviews') }}/" + reviewId);
		$('#delete-review').modal('show');
	});

	function reviewstatus(id) {
		var status = $(this).prop('checked') == true ? 1 : 0;

		$.ajax({
			type: "GET",
			dataType: "json",
			url: "{{ url('/users/reviews/approved/') }}/" + id,
			data: {
				'approved': status,
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
