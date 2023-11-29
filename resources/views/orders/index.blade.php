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
							<h3 class="card-title">{{ __('adminstaticword.Orders') }}</h3>
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
								<th>{{ __('adminstaticword.Service') }}</th>
								<th>{{ __('adminstaticword.User') }}</th>
								<th>{{ __('adminstaticword.PaymentMethod') }}</th>
								<th>{{ __('adminstaticword.Status') }}</th>
								<th>{{ __('adminstaticword.Payment Status') }}</th>
								<th>{{ __('adminstaticword.Action') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($orders as $order)
								<?php $i++; ?>
								<tr>
									<td>
										<span style="margin-left: 25px;"><?php echo $i; ?></span>
									</td>

									<td>
										{{-- <a href="{{ route('services.admin.edit', $order->service->id) }}"> --}}
											{{ $order->service->name }}
                                        {{-- </a> --}}
									</td>
									<td>
										{{-- <a href="{{ route('users.admin.edit', $order->user->id) }}"> --}}
											{{ $order->user->name }}
                                        {{-- </a> --}}
									</td>
									<td>
										{{ $order->paymentMethod->name }}
									</td>
									<td>
										<button type="button"
											class="edit-order btn btn-rounded btn-xs
                                        {{ $order->status == 'Confirmed' ? 'btn-success' : ($order->status == 'Pending' ? 'btn-warning' : 'btn-danger') }}"
											data-toggle="modal" data-target="#edit-order" data-order-id="{{ $order->id }}" rel="tooltip"
											data-order-status="{{ $order->status }}">
											{{ $order->status }}

										</button>
									</td>
									<td>
										<div class="custom-control custom-switch">
											<input id="payment_status_{{ $order->id }}" type="checkbox" data-id="{{ $order->id }}"
												name="payment_status" onchange="payment_status('{{ $order->id }}')" class="custom-control-input"
												{{ $order->payment_status == '1' ? 'checked' : '' }}>
											<label class="custom-control-label" for="payment_status_{{ $order->id }}"></label>
										</div>
									</td>
									<td>
										<button type="button" data-toggle="modal" data-target="#show-order" data-order-id="{{ $order->id }}"
											data-user-name="{{ $order->user->name }}" data-service-name="{{ $order->service->name }}"
											data-service-user-name="{{ $order->service->user->name }}"
											data-payment-method-name ="{{ $order->paymentMethod->name }}" data-status="{{ $order->status }}"
											data-payment_status="{{ $order->payment_status }}" data-note="{{ $order->note }}" rel="tooltip"
											class="btn btn-primary btn-sm btn-icon show-order">
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

	{{-- edit status Modal start --}}
	<div class="modal fade" id="edit-order" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="edit-order">{{ __('adminstaticword.Update Status') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
							aria-hidden="true">&times;</span></button>

				</div>
				<div class="modal-body">
					<form id="edit-o-form" method="post" action="" data-parsley-validate class="form-horizontal form-label-left"
						autocomplete="off" enctype="multipart/form-data">
						{{ csrf_field() }}

						<div class="col-md-12">
							<div class="form-group{{ $errors->has('status') ? ' has-danger' : '' }} form-group">
								<label>{{ __('adminstaticword.Status') }} <sup style="color: red">*</sup></label>
								<select name="status" id="status"
									class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }} form-control select2">
									<option id="Confirmed" value="Confirmed">
										{{ __('adminstaticword.Confirmed') }}</option>
									<option id="Pending" value="Pending">
										{{ __('adminstaticword.Pending') }}</option>
									<option id="Cancelled" value="Cancelled">
										{{ __('adminstaticword.Cancelled') }}</option>
								</select>
							</div>
						</div>
						<br>
						<div class="form-group">
							{{-- <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
								{{ __('Reset') }}</button> --}}
							<button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
								{{ __('Submit') }}</button>
						</div>
						<div class="clear-both"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	{{-- edit status Modal end --}}

	{{-- show order Modal start --}}
	<div class="modal fade" id="show-order" tabindex="-1" role="dialog" aria-labelledby="show-orderLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">
						{{ __('adminstaticword.Order Details') }}
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="col-lg-12">
						<div class="card m-b-30">
							<div class="card-body py-5">
								<div class="row">
									{{-- <div class="user-modal">
										@if ($image = @file_get_contents('../public/images/user_img/' . $user_img))
											<img @error('photo') is-invalid @enderror src="{{ url('images/user_img/' . $user_img) }}"
												alt="profilephoto" class="img-responsive img-circle">
										@else
											<img @error('photo') is-invalid @enderror src="{{ Avatar::create($fname)->toBase64() }}" alt="profilephoto"
												class="img-responsive img-circle">
										@endif
									</div> --}}
									<div class="col-lg-12">
										<h4 class="text-center">
										</h4>
										<div class="table-responsive">
											<table class="table table-borderless mb-0 user-table table-striped">
												<tbody>
													<tr>
														<th scope="row" class="p-1 col-md-6">
															{{ __('adminstaticword.User') }} :</th>
														<td class="p-1 col-md-6" id="order-user-name">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Service') }} :</th>
														<td class="p-1" id="order-service-name">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __("adminstaticword.Service's user") }} :</th>
														<td class="p-1" id="order-service-user-name">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.PaymentMethod') }} :</th>
														<td class="p-1" id="order-payment-method-name">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Status') }} :</th>
														<td class="p-1" id="order-status">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Payment Status') }} :</th>
														<td class="p-1" id="order-payment_status">
														</td>
													</tr>
													<tr>
														<td class="p-1" colspan="2">
															<div style="display: flex; justify-content: flex-end; flex-direction: column;">
																<div><b>{{ __('adminstaticword.Note') }} :</b></div>
																<div id="order-note" class="mb-0">
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
	{{-- show order Modal end --}}

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
					"width": "5"
				},
				{
					"width": "20%"
				},
				{
					"width": "20%"
				},
				{
					"width": "15%",
				},
				{
					"width": "15%",
				},
				{
					"width": "15%"
				},
				{
					"width": "10%"
				},
			],
		});
	});
</script>

<script>
	$(document).on('click', '.edit-order', function() {
		var orderId = $(this).data('order-id');
		var status = $(this).data('order-status');

		$('#order-id').val(orderId);
		$('#status').val(status);

		$('#edit-o-form').attr('action', "{{ url('orders/status') }}/" + orderId);
		$('#edit-order').modal('show');
	});

	$(document).on('click', '.show-order', function() {
		var orderId = $(this).data('order-id');
		var userName = $(this).data('user-name');
		var serviceName = $(this).data('service-name');
		var serviceUserName = $(this).data('service-user-name');
		var paymentMethod = $(this).data('payment-method-name');
		var status = $(this).data('status');
		var payment_status = $(this).data('payment_status');
		var note = $(this).data('note');


		$('#order-user-name').text(userName);
		$('#order-service-name').text(serviceName);
		$('#order-service-user-name').text(serviceUserName);
		$('#order-payment-method-name').text(paymentMethod);
		$('#order-status').text(status);

		if (payment_status == 1) {
			$('#order-payment_status').text('{{ __('adminstaticword.Sent') }}');
		} else {
			$('#order-payment_status').text('{{ __('adminstaticword.Unsent') }}');
		}
		$('#order-note').text(note);

		$('#edit-o-form').attr('action', "{{ url('orders/status') }}/" + orderId);
		$('#show-order').modal('show');
	});

	function payment_status(id) {
		var payment_status = $(this).prop('checked') == true ? 1 : 0;

		$.ajax({
			type: "GET",
			dataType: "json",
			url: "{{ url('/orders/payment-status/') }}/" + id,
			data: {
				'payment_status': payment_status,
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
