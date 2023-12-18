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
							<a href="{{ route('users.admin.allReviews') }}" class="btn btn-sm btn-primary">
								{{ __('adminstaticword.All Reviews') }}</a>
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
								<th>{{ __('adminstaticword.Users') }}</th>
								<th>{{ __('adminstaticword.Details') }}</th>
								<th>{{ __('adminstaticword.Reviews') }}</th>
							</tr>
						</thead>
						<tbody>
							<?php $i = 0; ?>
							@foreach ($users as $user)
								<?php $i++; ?>
								<tr>
									<td>

										<span style="margin-left: 25px;"><?php echo $i; ?></span>
									</td>
									<td>
										@if ($user->profile)
											<img width="75px" height="75px" src="{{ $user->profile }}" alt="">
										@elseif ($user->gender == 'female')
											<img width="75px" height="75px" src="{{ asset('') }}img/female-user.jpg" alt="">
										@else
											<img width="75px" height="75px" src="{{ asset('') }}img/male-user.jpg" alt="">
										@endif
									</td>
									<td>
										<p>
											<b>{{ __('Name') }}</b>: {{ $user->name }} <br>
											<b>{{ __('Email') }}</b>: {{ $user->email }} <br>
											<b>{{ __('Phone') }}</b>: {{ $user->phone }}
										</p>
									</td>

									<td>
										<button type="button" data-toggle="modal" data-target="#show-user" data-user-id="{{ $user->id }}"
											data-user-name="{{ $user->name }}" data-user-role="{{ $user->role }}"
											data-user-email="{{ $user->email }}" data-user-phone="{{ $user->phone }}"
											data-user-gender="{{ $user->gender }}" data-user-address="{{ $user->address }}"
											data-user-city="{{ $user->city ? $user->city->name : null }}"
											data-user-state="{{ $user->city ? $user->city->state->name : null }}"
											data-user-birthday="{{ $user->birthday }}" data-user-details="{{ $user->details }}" rel="tooltip"
											class="btn btn-primary btn-sm btn-icon show-user">
											<i class="fa fa-eye" aria-hidden="true"></i>
										</button>
									</td>

									<td>
                                        <a type="button"href="{{ route('users.admin.providerReviews', $user->id) }}" class="btn btn-sm btn-primary">
											<i class="fa fa-eye" aria-hidden="true"></i></a>
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
	<div class="modal fade" id="show-user" tabindex="-1" role="dialog" aria-labelledby="show-userLabel"
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
															{{ __('adminstaticword.Name') }} :</th>
														<td class="p-1 col-md-6" id="user-name">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1 col-md-6">
															{{ __('adminstaticword.Role') }} :</th>
														<td class="p-1 col-md-6" id="user-role">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Email') }} :</th>
														<td class="p-1" id="user-email">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Phone') }} :</th>
														<td class="p-1" id="user-phone">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Gender') }} :</th>
														<td class="p-1" id="user-gender">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.Address') }} :</th>
														<td class="p-1" id="user-address">
														</td>
													</tr>
													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.City') }} :</th>
														<td class="p-1" id="user-city">
														</td>
													</tr>

													<tr>
														<th scope="row" class="p-1">
															{{ __('adminstaticword.DateofBirth') }} :</th>
														<td class="p-1" id="user-birthday">
														</td>
													</tr>

													<tr>
														<td class="p-1" colspan="2">
															<div style="display: flex; justify-content: flex-end; flex-direction: column;">
																<div><b>{{ __('adminstaticword.Details') }} :</b></div>
																<div id="user-details" class="mb-0">
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
		});
	});
</script>

<script>
	$(document).ready(function() {
		$("#checkboxAll").on('click', function() {
			$('input.check').not(this).prop('checked', this.checked);
		});
	});

	$(document).on('click', '.show-user', function() {
		var userId = $(this).data('user-id');
		var userName = $(this).data('user-name');
		var userRole = $(this).data('user-role');
		var userEmail = $(this).data('user-email');
		var userPhone = $(this).data('user-phone');
		var userGender = $(this).data('user-gender');
		var userAddress = $(this).data('user-address');
		var userCity = $(this).data('user-city');
		var userState = $(this).data('user-state');
		var userBirthday = $(this).data('user-birthday');
		var userDetails = $(this).data('user-details');

		var city = userState + ' - ' + userCity

		$('#user-name').text(userName);
		$('#user-role').text(userRole);
		$('#user-email').text(userEmail);
		$('#user-phone').text(userPhone);
		$('#user-gender').text(userGender);
		$('#user-address').text(userAddress);
		$('#user-city').text(city);
		$('#user-birthday').text(userBirthday);
		$('#user-details').text(userDetails);

		$('#show-user').modal('show');
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

	$(document).on('click', '.del-user', function() {
		var userId = $(this).data('user-id');
		$('#del-u-form').attr('action', "{{ url('users') }}/" + userId);
		$('#delete-user').modal('show');
	});

	$(document).on('click', '.add-points', function() {
		var userId = $(this).data('user-id');
		var points = $(this).data('points');

		$('#user-id').val(userId);
		// $('#points').val(points);
		$('#current-points').text('{{ __('adminstaticword.CurrentPoints') }} : ' + points);


		$('#add-points-form').attr('action', "{{ url('users/add-points') }}/" + userId);
		$('#add-points').modal('show');
	});

	function userstatus(id) {
		var status = $(this).prop('checked') == true ? 1 : 0;

		$.ajax({
			type: "GET",
			dataType: "json",
			url: "{{ url('/users/status/') }}/" + id,
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
