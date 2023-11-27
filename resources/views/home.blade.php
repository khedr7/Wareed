@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
	<h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Welcom ..</h3>
				</div>
				<!-- /.card-header -->
				{{-- <div class="card-body">
					<table id="example1" class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Rendering engine</th>
								<th>Browser</th>
								<th>Platform(s)</th>
								<th>Engine version</th>
								<th>CSS grade</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 5.0
								</td>
								<td>Win 95+</td>
								<td>5</td>
								<td>C</td>
							</tr>

						</tbody>
						<tfoot>
							<tr>
								<th>Rendering engine</th>
								<th>Browser</th>
								<th>Platform(s)</th>
								<th>Engine version</th>
								<th>CSS grade</th>
							</tr>
						</tfoot>
					</table>
				</div> --}}
				<!-- /.card-body -->
			</div>
			<!-- /.card -->

			{{-- <div class="card">
				<div class="card-header">
					<h3 class="card-title">DataTable with default features</h3>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<table id="example2" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Rendering engine</th>
								<th>Browser</th>
								<th>Platform(s)</th>
								<th>Engine version</th>
								<th>CSS grade</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>
							<tr>
								<td>Trident</td>
								<td>Internet
									Explorer 4.0
								</td>
								<td>Win 95+</td>
								<td> 4</td>
								<td>X</td>
							</tr>

						<tfoot>
							<tr>
								<th>Rendering engine</th>
								<th>Browser</th>
								<th>Platform(s)</th>
								<th>Engine version</th>
								<th>CSS grade</th>
							</tr>
						</tfoot>
					</table>
				</div>
				<!-- /.card-body -->
			</div> --}}
			<!-- /.card -->
		</div>
		<!-- /.col -->
	</div>
@stop
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

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
