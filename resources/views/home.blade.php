@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<h1 class="m-0 text-dark">{{ __('adminstaticword.Dashboard') }}</h1>
@stop

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-6">
				<div class="small-box bg-info">
					<div class="inner">
						<h3>{{ $counts['users'] }}</h3>

						<p>{{ __('adminstaticword.Users') }}</p>
					</div>
					<div class="icon">
						<i class="fas fa-fw fa-users"></i>
					</div>
					<a href="{{ route('users.admin.index') }}" class="small-box-footer">{{ __('adminstaticword.Moreinfo') }} <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>

			<div class="col-lg-3 col-6">
				<div class="small-box bg-success">
					<div class="inner">
						<h3>{{ $counts['providers'] }}</h3>

						<p>{{ __('adminstaticword.Providers') }}</p>
					</div>
					<div class="icon">
						<i class="fas fa-fw fa-users"></i>
					</div>
					<a href="{{ route('users.admin.index') }}" class="small-box-footer">{{ __('adminstaticword.Moreinfo') }} <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>

			<div class="col-lg-3 col-6">
				<div class="small-box bg-warning">
					<div class="inner">
						<h3>{{ $counts['categoris'] }}</h3>

						<p>{{ __('adminstaticword.Categories') }}</p>
					</div>
					<div class="icon">
						<i class="fas fa-fw fa-heartbeat"></i>
					</div>
					<a href="{{ route('categories.admin.index') }}" class="small-box-footer">{{ __('adminstaticword.Moreinfo') }} <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>

			<div class="col-lg-3 col-6">
				<div class="small-box bg-danger">
					<div class="inner">
						<h3>{{ $counts['services'] }}</h3>

						<p>{{ __('adminstaticword.Services') }}</p>
					</div>
					<div class="icon">
						<i class="fas fa-fw fa-medkit"></i>
					</div>
					<a href="{{ route('services.admin.index') }}" class="small-box-footer">{{ __('adminstaticword.Moreinfo') }} <i
							class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 col-12">
				<div class="card">
					<div class="card-header border-0">
						<div class="d-flex justify-content-between">
							<h3 class="card-title">{{ __('adminstaticword.Orders') }}</h3>
							<p>{{ (new DateTime())->format('Y') }}</p>
						</div>
					</div>
					<div class="card-body">
						{{-- <div class="d-flex">
							<p class="d-flex flex-column">
								<span class="text-bold text-lg">$18,230.00</span>
								<span>Sales Over Time</span>
							</p>
							<p class="ml-auto d-flex flex-column text-right">
								<span class="text-success">
									<i class="fas fa-arrow-up"></i> 33.1%
								</span>
								<span class="text-muted">Since last month</span>
							</p>
						</div> --}}
						<!-- /.d-flex -->

						<div class="position-relative mb-4">
							<canvas id="orders-chart" height="200"></canvas>
						</div>

						{{-- <div class="d-flex flex-row justify-content-end">
							<span class="mr-2">
								<i class="fas fa-square text-primary"></i> {{ (new DateTime())->format('Y') }}
							</span>
						</div> --}}
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-12">
				<div class="card">
					<div class="card-header border-0">
						<div class="d-flex justify-content-between">
							<h3 class="card-title">{{ __('adminstaticword.Top Countries') }}</h3>
						</div>
					</div>
					<div class="card-body">
						<div class="position-relative mb-4">
							@if (count($country_counts) != 0)
								<div id="apex-pie-chart" height="200"></div>
							@endif

						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6 col-12">
				<div class="card">
					<div class="card-header border-0">
						<h3 class="card-title">{{ __('adminstaticword.Most ordered categories') }}</h3>
					</div>
					<div class="card-body table-responsive p-0">
						<table class="table table-striped table-valign-middle">
							<thead>
								<tr>
									<th>{{ __('adminstaticword.Category') }}</th>
									<th>{{ __('adminstaticword.Orders') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($topFiveCategories as $category)
									<tr>
										<td>
											<img src="{{ $category->image }}" alt="Product 1" class="img-circle img-size-32 mr-2">
											{{ $category->name }}
										</td>
										<td>
											@if ($category->sum_orders_count <= 1)
												{{ $category->sum_orders_count }} {{ __('adminstaticword.Order') }}
											@else
												{{ $category->sum_orders_count }} {{ __('adminstaticword.Orders') }}
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-lg-6 col-12">
				<div class="card">
					<div class="card-header border-0">
						<h3 class="card-title">{{ __('adminstaticword.Most ordered services') }}</h3>
					</div>
					<div class="card-body table-responsive p-0">
						<table class="table table-striped table-valign-middle">
							<thead>
								<tr>
									<th>{{ __('adminstaticword.Service') }}</th>
									<th>{{ __('adminstaticword.Orders') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($topFiveservices as $service)
									<tr>
										<td>
											<img src="{{ $service->image }}" alt="Product 1" class="img-circle img-size-32 mr-2">
											{{ $service->name }}
										</td>
										<td>
											@if ($service->orders_count <= 1)
												{{ $service->orders_count }} {{ __('adminstaticword.Order') }}
											@else
												{{ $service->orders_count }} {{ __('adminstaticword.Orders') }}
											@endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
	$(function() {
		'use strict'

		var annual_orders_count = @json($annual_orders_count);
		var country_counts = @json($country_counts);
		var country_names = @json($country_names);

		var ticksStyle = {
			fontColor: '#495057',
			fontStyle: 'bold'
		}

		var mode = 'index'
		var intersect = true

		var $salesChart = $('#orders-chart')
		// eslint-disable-next-line no-unused-vars
		var salesChart = new Chart($salesChart, {
			type: 'bar',
			data: {
				labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV',
					'DEC'
				],
				datasets: [{
						backgroundColor: '#007bff',
						borderColor: '#007bff',
						data: annual_orders_count
					},
					// {
					// 	backgroundColor: '#ced4da',
					// 	borderColor: '#ced4da',
					// 	data: [700, 1700, 2700, 2000, 1800, 700, 1700, 2700, 2000, 1800, 1500, 2000]
					// }
				]
			},
			options: {
				maintainAspectRatio: false,
				tooltips: {
					mode: mode,
					intersect: intersect
				},
				hover: {
					mode: mode,
					intersect: intersect
				},
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						// display: false,
						gridLines: {
							display: true,
							lineWidth: '4px',
							color: 'rgba(0, 0, 0, .2)',
							zeroLineColor: 'transparent'
						},
						ticks: $.extend({
							beginAtZero: true,

							// Include a dollar sign in the ticks
							// callback: function(value) {
							// 	if (value >= 1000) {
							// 		value /= 1000
							// 		value += 'k'
							// 	}

							// 	return '$' + value
							// }
						}, ticksStyle)
					}],
					xAxes: [{
						display: true,
						gridLines: {
							display: false
						},
						ticks: ticksStyle
					}]
				}
			}
		})

		var $visitorsChart = $('#visitors-chart')
		// eslint-disable-next-line no-unused-vars
		var visitorsChart = new Chart($visitorsChart, {
			data: {
				labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
				datasets: [{
						type: 'line',
						data: [100, 120, 170, 167, 180, 177, 160],
						backgroundColor: 'transparent',
						borderColor: '#007bff',
						pointBorderColor: '#007bff',
						pointBackgroundColor: '#007bff',
						fill: false
						// pointHoverBackgroundColor: '#007bff',
						// pointHoverBorderColor    : '#007bff'
					},
					{
						type: 'line',
						data: [60, 80, 70, 67, 80, 77, 100],
						backgroundColor: 'tansparent',
						borderColor: '#ced4da',
						pointBorderColor: '#ced4da',
						pointBackgroundColor: '#ced4da',
						fill: false
						// pointHoverBackgroundColor: '#ced4da',
						// pointHoverBorderColor    : '#ced4da'
					}
				]
			},
			options: {
				maintainAspectRatio: false,
				tooltips: {
					mode: mode,
					intersect: intersect
				},
				hover: {
					mode: mode,
					intersect: intersect
				},
				legend: {
					display: false
				},
				scales: {
					yAxes: [{
						// display: false,
						gridLines: {
							display: true,
							lineWidth: '4px',
							color: 'rgba(0, 0, 0, .2)',
							zeroLineColor: 'transparent'
						},
						ticks: $.extend({
							beginAtZero: true,
							suggestedMax: 200
						}, ticksStyle)
					}],
					xAxes: [{
						display: true,
						gridLines: {
							display: false
						},
						ticks: ticksStyle
					}]
				}
			}
		})


		"use strict";
		var options = {
			chart: {
				type: 'pie',
				width: 300,
			},

			dataLabels: {
				enabled: true
			},
			theme: {
				monochrome: {
					enabled: true
				}
			},
			series: country_counts,
			labels: country_names,
			legend: {
				show: true,
				position: 'right'
			},
		}

		var chart = new ApexCharts(
			document.querySelector("#apex-pie-chart"),
			options
		);
		chart.render();
	})
</script>
