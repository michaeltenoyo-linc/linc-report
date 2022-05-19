<!DOCTYPE html>
<html>
<head>
	<title>PDF HTML Sales Report {{ $period }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>
		.header-top-bar {
			background: #9c0a16;
			font-size: 14px;
			padding: 10px 10px;
			box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
			color: #fff;
		}

		#loader {
			position: fixed;
			display: none;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			padding-top: 35%;	
			background-color: rgba(0, 0, 0, 0.685);
			color: white;
			z-index: 2;
			cursor: pointer;
		}

		@page {
			size: A4 landscape;
    		margin: 10mm 0 0 0;  /* this affects the margin in the printer settings */
		}

		@media print {
			body {-webkit-print-color-adjust: exact;}
		}
	</style>
</head>
<body>
	
	<!--Loader Spinner-->
	<div id="loader">
		<center>
			<h1>Please wait for all graphs to be loaded (<span id="loader-index"></span>/{{ count($performance) }})...</h1>
			<div class="spinner-grow text-primary" role="status">
			<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-secondary" role="status">
			<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-success" role="status">
			<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-danger" role="status">
			<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-warning" role="status">
			<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-info" role="status">
			<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-light" role="status">
			<span class="sr-only">Loading...</span>
			</div>
			<div class="spinner-grow text-dark" role="status">
			<span class="sr-only">Loading...</span>
			</div>
		</center>
	</div>

	<header>
		<div class="row header-top-bar px-5 py-3">
			&copy; Linc Group Surabaya
		</div>
		
		<div class="container">
			<div class="row py-4">
				<div class="col-12 mt-5 mb-5">
					<center>
						<img width="40%" src="{{ asset('assets/novena/images/logo.png') }}" alt="No image found" class="img-fluid">
					</center>
				</div>	
				<div class="col-12 mt-2">
					<center>
						<h1>Trucking Performance Report</h1>
						<h5 class="font-weight-normal">{{ $period }}</h5>
					</center>
				</div>
			</div>
		</div>

		<div>
			<br>
		</div>
	</header>
	
	<section class="table-data">
		<div class="container">
			<div class="mb-4 mt-5 text-danger text-xs">
				<br>
				<small>*All the calculation is based on realtime blujay's data (billable total rate)</small>
				<br>
				<small>*The values in the table are sorted by current month's actual rates</small>
			</div>
			<div class="row">
				<table class="table" style="width: 100%; font-size: 9pt;">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Truck Detail</th>
							<th scope="col">Rate Performance</th>
							<th scope="col">Load Detail</th>
						</tr>
					</thead>
					<tbody>
						@php
							$index = 1;
						@endphp
						@foreach($performance as $p)
						<tr>
							<th scope="row">{{ $index }}</th>
							<td style="width: 30%;">
								<div style="background-color: lightcoral; padding-left: 3%; margin-bottom: 1%;border-radius: 5px; ">
									<span class="font-weight-bold" style="color:white; background-color:darkred; padding: 1% 5%; border-radius: 5px;">{{ $p->carrier_name }}</span><br>
									<div class="font-weight-bold pt-2 px-2 h5">{{ $p->vehicle_number }}</div>
									<div class="font-weight-bold py-2 px-2">UNIT : {{ $p->unit_type }}</div>
								</div>
								<div class="py-2 pl-2">Current Driver : {{ $p->current_driver }}</div>
							</td>
							<td style="width: 50%;">
								<div>
									<div class="row my-2">
										<div class="col">
											<span style="color:white; background-color:darkred; padding: 2%; margin-right: 1%; border-radius: 50px; font-size: 10pt;">Payable</span><span> IDR. {{ $p->cost_format }}</b></span>
										</div>
										<div class="col text-right">
											<span>IDR. {{ $p->revenue_format }} </b></span><span style="color:white; background-color:#067d00; padding: 2%; margin-left: 1%; border-radius: 50px; font-size: 10pt;">Billable</span>
										</div>
									</div>
									
									<!-- Margin Percentage -->
									<div class="row px-4">
										<div class="progress mt-1 justify-content-end" style="width: 50%;">
											<div class="progress-bar" role="progressbar" style="background-color: darkred; width: {{ $p->mNay }}%" aria-valuenow="{{ $p->mNay }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<div class="progress mt-1" style="width: 50%;">
											<div class="progress-bar" role="progressbar" style="background-color: #067d00; width: {{ $p->mYay }}%" aria-valuenow="{{ $p->mYay }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>

									<!-- Net Profit -->
									<div class="row mt-1 px-4">
										<div class="col">
											<div class="row justify-content-center">
												<span>Net Profit : IDR. {{ $p->net_format }}</span>
											</div>
											<div class="row justify-content-center" style="font-size: 24pt; font-weight:bold;">
												@if ($p->totalRevenue - $p->totalCost > 0)
													<span style="color: green;">{{ $p->margin_percentage }} %</span>
												@elseif ($p->totalRevenue - $p->totalCost < 0)
													<span style="color: red;">{{ $p->margin_percentage }} %</span>
												@else
													<span>{{ $p->margin_percentage }} %</span>
												@endif
												
											</div>
										</div>
									</div>
								</div>
							</td>
								
							<td>
								<div class="row">
									<div class="col">
										<div class="row">
											<canvas id={{ $p->vehicle_number }} value={{ $p->vehicle_number }} class='table-container-graph' height='75px'><input type='hidden' name='budgetId' value={{ $p->vehicle_number }}></canvas>
										</div>
										<div class="row justify-content-center">
											<button type="button" class="btn btn-outline-info btn-sm">Customer Detail</button>
										</div>
									</div>
								</div>
							</td>
						</tr>
						@php
							$index++;
						@endphp
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>
</body>
</html>
<!--Alert Instruction-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
	Swal.fire(
		'How to save as PDF?',
		'Right Click -> Print -> Save as PDF',
		'question'
	)
	
	window.onload = async function(e){
		@php
			$indexLoader = 0;
		@endphp
		@foreach ($performance as $p)
			@php
				$indexLoader++;
			@endphp
			var elementId = "{{ $p->vehicle_number }}";
			var ctx = $('#'+elementId);
			console.log(ctx);
			
			try {
				//Draw chart
				const customerData = await $.get('/sales/truck/get-monthly-customers/'+elementId);

				const labels = customerData['customers'];
				
				const data = {
					labels: labels,
					datasets: [
					{
						label: 'Actual',
						data: blujayData['yearly_revenue'],
						borderColor: 'rgb(31, 48, 156)',
						backgroundColor: 'rgb(31, 48, 156)',
						type: 'bar',
						order: 1,
					},
					{
						label: 'Budget',
						data: blujayData['yearly_budget'],
						borderColor: 'rgb(81, 214, 58)',
						backgroundColor: 'rgb(81, 214, 58)',
						type: 'line',
						order: 0,
					}
					]
				};

				const config = {
					type: 'line',
					data: data,
					options: {
					plugins: {
						legend: {
						display: false,
						},
						title: {
						display: false,
						text: 'Chart.js Stacked Line/Bar Chart'
						}
					},
					scales: {
						y: {
						stacked: true,
						ticks: {
							display: false,
						}
						},
						x: {
						ticks: {
							display: false,
						}
						}
					}
					},
				};

				const newChart = new Chart(ctx, config);


			} catch (error) {
				console.log(error);
			}




		@endforeach
	}
		
</script>