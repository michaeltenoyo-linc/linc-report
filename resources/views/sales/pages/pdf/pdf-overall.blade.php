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
			<h1>Please wait for all graphs to be loaded (<span id="loader-index"></span>/{{ count($budgets) }})...</h1>
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
						<h1>Overall Sales Report</h1>
						<h5 class="font-weight-normal">{{ $period }}</h5>
					</center>
				</div>
			</div>
		</div>

		<div>
			<br>
		</div>
	</header>

	<section class="overview-data-1year">
		<!-- Big 1YEAR Chart-->
		<div class="row mt-4">
			<div class="col-12">
				<center>
					<div style="width: 1000px;">
						<canvas id="chartRevenueYearly" height="100%;"></canvas>
					</div>
				</center>
			</div>
		</div>

		<center class="mb-4">
			<h2>This Year Performance of {{ $period_year }}</h2>
		</center>

		<!-- Divisional Chart -->
		<div style="background-color: #9c0a16;">
			<div class="row">
				<div class="col-12 text-white pt-2">
					<center>
						<b>Achievement 1Y</b>
					</center>
				</div>
			</div>
			<div style="padding: 1% 0% 3% 0%;">
				<center>
					<div class="row text-white" style="width: 1000px; font-size: 9pt;">
						<div class="col-3">
							<div style="">
								<canvas id="chartYearlyTransport" height="100%;"></canvas>
							</div>
							<div>
								<br>
								IDR. {{ number_format($achievement_transport[0],0,',','.').' / '.number_format($achievement_transport[1],0,',','.') }}
							</div>
							<div>
								<b>({{  round(floatval($achievement_transport[0])/floatval($achievement_transport[1]) * 100 , 2) }}%)</b>
							</div>
						</div>
						<div class="col-3">
							<div style="">
								<canvas id="chartYearlyExim" height="100%;"></canvas>
							</div>
							<div>
								<br>
								IDR. {{ number_format($achievement_exim[0],0,',','.').' / '.number_format($achievement_exim[1],0,',','.') }}
							</div>
							<div>
								<b>({{  round(floatval($achievement_exim[0])/floatval($achievement_exim[1]) * 100, 2) }}%)</b>
							</div>
						</div>
						<div class="col-3">
							<div style="">
								<canvas id="chartYearlyBulk" height="100%;"></canvas>
							</div>
							<div>
								<br>
								IDR. {{ number_format($achievement_bulk[0],0,',','.').' / '.number_format($achievement_bulk[1],0,',','.') }}
							</div>
							<div>
								<b>({{  round(floatval($achievement_bulk[0])/floatval($achievement_bulk[1]) * 100, 2) }}%)</b>
							</div>
						</div>
						<div class="col-3">
							<div style="">
								<canvas id="chartYearlyWarehouse" height="100%;"></canvas>
							</div>
							<div>
								<br>
								IDR. {{ number_format($achievement_warehouse[0],0,',','.').' / '.number_format($achievement_warehouse[1],0,',','.') }}
							</div>
							<div>
								<b>({{  round(floatval($achievement_warehouse[0])/floatval($achievement_warehouse[1]) * 100, 2) }}%)</b>
							</div>
						</div>
					</div>
				</center>
			</div>
		</div>
	</section>

	<section class="overview-data-1month">
		<div class="row mt-4" style="height: 723px;">
			<div class="col-8 text-white p-5" style="background-color: #9c0a16;">
				<div class="row mb-4">
					<div class="col-12">
						<center>
							<h3>This Month Performance</h3>
							<h6>({{ $period }})</h6>
						</center>
					</div>
				</div>
				<div class="row" style="font-size: 10pt;">
					<div class="col-6 p-3">
						<b>Transport</b>
						<br>
						<div class="row">
							<div class="col-5">
								Revenue (CM)
								<br>
								Revenue (Ytd.)
								<br>
								Loads (CM)
								<br>
								Loads (Ytd.)
								<br>
								Achievement (CM)
								<br>
								Achievement (Ytd.)
							</div>
							<div class="col-7 text-right">
								IDR. <span id="transport-revenue-1m"></span>
								<br>
								IDR. <span id="transport-revenue-ytd"></span>
								<br>
								<span id="transport-transaction-1m"></span> Loads
								<br>
								<span id="transport-transaction-ytd"></span> Loads
								<br>
								<span id="transport-achievement-1m"></span>
								<br>
								<span id="transport-achievement-ytd"></span>
							</div>
						</div>
					</div>
					<div class="col-6 p-3">
						<b>Exim</b>
						<br>
						<div class="row">
							<div class="col-5">
								Revenue (CM)
								<br>
								Revenue (Ytd.)
								<br>
								Loads (CM)
								<br>
								Loads (Ytd.)
								<br>
								Achievement (CM)
								<br>
								Achievement (Ytd.)
							</div>
							<div class="col-7 text-right">
								IDR. <span id="exim-revenue-1m"></span>
								<br>
								IDR. <span id="exim-revenue-ytd"></span>
								<br>
								<span id="exim-transaction-1m"></span> Loads
								<br>
								<span id="exim-transaction-ytd"></span> Loads
								<br>
								<span id="exim-achievement-1m"></span>
								<br>
								<span id="exim-achievement-ytd"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="row" style="font-size: 10pt;">
					<div class="col-6 p-3">
						<b>Bulk</b>
						<br>
						<div class="row">
							<div class="col-5">
								Revenue (CM)
								<br>
								Revenue (Ytd.)
								<br>
								Loads (CM)
								<br>
								Loads (Ytd.)
								<br>
								Achievement (CM)
								<br>
								Achievement (Ytd.)
							</div>
							<div class="col-7 text-right">
								IDR. <span id="bulk-revenue-1m"></span>
								<br>
								IDR. <span id="bulk-revenue-ytd"></span>
								<br>
								<span id="bulk-transaction-1m"></span> Loads
								<br>
								<span id="bulk-transaction-ytd"></span> Loads
								<br>
								<span id="bulk-achievement-1m"></span>
								<br>
								<span id="bulk-achievement-ytd"></span>
							</div>
						</div>
					</div>
					<div class="col-6 p-3">
						<b>Warehouse</b>
						<br>
						Data is not available yet.
					</div>
				</div>
				<div class="row">
					
				</div>
			</div>
			<div class="col-4">
				
			</div>
		</div>
	</section>
	
	<section class="table-data">
		<div class="container">
			<div class="mb-4 mt-5 text-danger text-xs">
				<br>
				<small>*All the calculation is based on realtime blujay's data (billable total rate)</small>
				<br>
				<small>*The values in the table are sorted by current month's (closed date) actual rates</small>
			</div>
			<div class="row">
				<table class="table" style="width: 100%; font-size: 9pt;">
					<thead>
						<tr>
							<th scope="col">Customer Detail</th>
							<th scope="col">Achievement</th>
							<th scope="col">Trend</th>
						</tr>
					</thead>
					<tbody>
						@php
							$index = 1;
						@endphp
						@foreach($budgets as $b)
						<tr>
							<td style="width: 35%;">
								<div style="background-color: lightcoral; padding-left: 3%; margin-bottom: 1%;border-radius: 5px; ">
									<span class="font-weight-bold" style="color:white; background-color:darkred; padding: 1% 5%; border-radius: 5px;">{{ $b->customer_sap }}</span><br>
									<div class="row font-weight-bold pt-4 px-2 h5">
										<div class="col-3">
											<img style="max-height: 100px;" class="img-fluid img-thumbnail" src="{{ asset('assets/icons/customers/'.$b->customer_sap.'.png') }}" alt="">
										</div>
										<div class="col">{{ $b->customer_name }}</div>
									</div>
									<div class="row font-weight-bold py-2 px-2">
										<div class="col">Division : {{ $b->division }}</div>
									</div>
								</div>
								<div class="py-2 pl-2">Assigned to : {{ $b->sales }}</div>
							</td>
							<td style="width: 50%;">
								<div>
									<span style="color:white; background-color:darkred; padding: 1%; margin-right: 1%; border-radius: 50px; font-size: 6pt;">CM</span><span> IDR. {{ $b->achievement_1m_actual }} / <b>{{ $b->achievement_1m_budget }}</b></span>
									@if ($b->achievement_1m_percentage > 90)
										<span style="color:#067d00;" class='font-weight-bold'>({{ $b->achievement_1m_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #067d00; width: {{ $b->achievement_1m_percentage }}%" aria-valuenow="{{ $b->achievement_1m_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@elseif ($b->achievement_1m_percentage > 75)
										<span style="color:#6ca600;" class='font-weight-bold'>({{ $b->achievement_1m_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #6ca600; width: {{ $b->achievement_1m_percentage }}%" aria-valuenow="{{ $b->achievement_1m_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@elseif ($b->achievement_1m_percentage > 50)
										<span style="color:#a6a600;" class='font-weight-bold'>({{ $b->achievement_1m_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #a6a600; width: {{ $b->achievement_1m_percentage }}%" aria-valuenow="{{ $b->achievement_1m_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@elseif ($b->achievement_1m_percentage > 25)
										<span style="color:#a67a00;" class='font-weight-bold'>({{ $b->achievement_1m_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #a67a00; width: {{ $b->achievement_1m_percentage }}%" aria-valuenow="{{ $b->achievement_1m_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@elseif ($b->achievement_1m_percentage > 10)
										<span style="color:#a64b00;" class='font-weight-bold'>({{ $b->achievement_1m_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #a64b00; width: {{ $b->achievement_1m_percentage }}%" aria-valuenow="{{ $b->achievement_1m_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@else
										<span style="color:#a60000;" class='font-weight-bold'>({{ $b->achievement_1m_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #a60000; width: {{ $b->achievement_1m_percentage }}%" aria-valuenow="{{ $b->achievement_1m_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@endif
								</div>
								<br>
								<div style="margin-bottom: 0.1%;">
									<span style="color:white; background-color:darkred; padding: 1%; margin-right: 1%; border-radius: 50px; font-size: 6pt;">YTD</span><span> IDR. {{ $b->achievement_ytd_actual }} / <b>{{ $b->achievement_ytd_budget }}</b></span>
									@if ($b->achievement_ytd_percentage > 90)
										<span style="color:#067d00;" class='font-weight-bold'>({{ $b->achievement_ytd_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #067d00; width: {{ $b->achievement_ytd_percentage }}%" aria-valuenow="{{ $b->achievement_ytd_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@elseif ($b->achievement_ytd_percentage > 75)
										<span style="color:#6ca600;" class='font-weight-bold'>({{ $b->achievement_ytd_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #6ca600; width: {{ $b->achievement_ytd_percentage }}%" aria-valuenow="{{ $b->achievement_ytd_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@elseif ($b->achievement_ytd_percentage > 50)
										<span style="color:#a6a600;" class='font-weight-bold'>({{ $b->achievement_ytd_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #a6a600; width: {{ $b->achievement_ytd_percentage }}%" aria-valuenow="{{ $b->achievement_ytd_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@elseif ($b->achievement_ytd_percentage > 25)
										<span style="color:#a67a00;" class='font-weight-bold'>({{ $b->achievement_ytd_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #a67a00; width: {{ $b->achievement_ytd_percentage }}%" aria-valuenow="{{ $b->achievement_ytd_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@elseif ($b->achievement_ytd_percentage > 10)
										<span style="color:#a64b00;" class='font-weight-bold'>({{ $b->achievement_ytd_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #a64b00; width: {{ $b->achievement_ytd_percentage }}%" aria-valuenow="{{ $b->achievement_ytd_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@else
										<span style="color:#a60000;" class='font-weight-bold'>({{ $b->achievement_ytd_percentage }}%)</span>
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #a60000; width: {{ $b->achievement_ytd_percentage }}%" aria-valuenow="{{ $b->achievement_ytd_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									@endif
								</div>
							</td>
								
							<td><canvas id={{ $b->id }} value={{ $b->id }} class='table-container-graph' height='75px'><input type='hidden' name='budgetId' value={{ $b->id }}></canvas></td>
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
		//Chart Landing Yearly Revenue All

	//Dummy Data
	const labels = [
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
	];
	const revenueDataFetch = await $.get('/sales/data/get-yearly-revenue/all');
	var contYearlyRevenue =  document.getElementById('chartRevenueYearly').getContext('2d'), gradient = contYearlyRevenue.createLinearGradient(0, 0, 0, 450);

	gradient.addColorStop(0, 'rgba(8, 73, 252, 1)');
	gradient.addColorStop(0.5, 'rgba(8, 73, 252, 0.25)');
	gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');



	const data = {
		labels: labels,
		datasets: [
			{
				label: 'Surabaya',
				data: revenueDataFetch['overall'],
				borderColor: '#032ea3',
				backgroundColor: gradient,
				pointBackgroundColor: 'white',
				fill: true,
				cubicInterpolationMode: 'monotone',
				tension: 0.4
			},
		]
	};

	const configYearlyRevenue = {
		type: 'line',
		data: data,
		options: {
			responsive: true,
			plugins: {
				title: {
					display: true,
					text: 'Yearly Revenue Surabaya 2022'
				},
			},
			interaction: {
				intersect: false,
			},
			scales: {
			x: {
				display: true,
				title: {
					display: true
				},
			},
			y: {
				display: true,
				title: {
					display: true,
					text: 'Revenue (Bill.)'
				},
				suggestedMin: 0,
				suggestedMax: 3
			}
			}
		},
	};

	const chartRevenueYearly = new Chart(contYearlyRevenue, configYearlyRevenue);
		
		//Chart By Division
		//Transport
		const dataYearlyTransport = {
			labels: ['Yay', 'Nay'],
			datasets: [
				{
					label: 'Transport',
					data: [ {{ $achievement_transport[0] }}, {{ $achievement_transport[1]-$achievement_transport[0] }} ],
					backgroundColor: ['rgb(255, 169, 77)', 'rgb(255, 132, 0)'],
				},
			]
		};
		const contYearlyTransport = $('#chartYearlyTransport');
		const configYearlyTransport = {
			type: 'doughnut',
			data: dataYearlyTransport,
			options: {
				responsive: true,
				plugins: {
					legend: {
						display: false,
					},
					title: {
						display: true,
						text: 'Transport',
						color: '#ffffff',
					}
				}
			},
		};
		const chartYearlyTransport = new Chart(contYearlyTransport, configYearlyTransport);
		
		//Exim
		const dataYearlyExim = {
			labels: ['Yay', 'Nay'],
			datasets: [
				{
					label: 'Exim',
					data: [{{ $achievement_exim[0] }}, {{ $achievement_exim[1]-$achievement_exim[0] }}],
					backgroundColor: ['rgb(33, 242, 5)', 'rgb(22, 163, 3)'],
				},
			]
		};
		const contYearlyExim = $('#chartYearlyExim');
		const configYearlyExim = {
			type: 'doughnut',
			data: dataYearlyExim,
			options: {
				responsive: true,
				plugins: {
					legend: {
						display: false,
					},
					title: {
						display: true,
						text: 'Exim',
						color: '#ffffff',
					}
				}
			},
		};
		const chartYearlyExim = new Chart(contYearlyExim, configYearlyExim);
		
		//Bulk
		const dataYearlyBulk = {
			labels: ['Yay', 'Nay'],
			datasets: [
				{
					label: 'Bulk',
					data: [{{ $achievement_bulk[0] }}, {{ $achievement_bulk[1]-$achievement_bulk[0] }}],
					backgroundColor: ['rgb(0, 119, 255)', 'rgb(0, 30, 255)'],
				},
			]
		};
		const contYearlyBulk = $('#chartYearlyBulk');
		const configYearlyBulk = {
			type: 'doughnut',
			data: dataYearlyBulk,
			options: {
				responsive: true,
				plugins: {
					legend: {
						display: false,
					},
					title: {
						display: true,
						text: 'Bulk',
						color: '#ffffff',
					}
				}
			},
		};
		const chartYearlyBulk = new Chart(contYearlyBulk, configYearlyBulk);

		//Warehouse
		const dataYearlyWarehouse = {
			labels: ['Yay', 'Nay'],
			datasets: [
				{
					label: 'Warehouse',
					data: [0,1],
					backgroundColor: ['rgb(168, 168, 168)', 'rgb(87, 87, 87)'],
				},
			]
		};
		const contYearlyWarehouse = $('#chartYearlyWarehouse');
		const configYearlyWarehouse = {
			type: 'doughnut',
			data: dataYearlyWarehouse,
			options: {
				responsive: true,
				plugins: {
					legend: {
						display: false,
					},
					title: {
						display: true,
						text: 'Warehouse',
						color: '#ffffff',
					}
				}
			},
		};
		const chartYearlyWarehouse = new Chart(contYearlyWarehouse, configYearlyWarehouse);
		
		//1 Month Overview
		//Transport
		const transportOverviewFetch = await $.get('/sales/data/get-division-overview/transport');
		
		$('#transport-revenue-1m').empty().html(transportOverviewFetch['revenue_1m']);
		$('#transport-revenue-ytd').empty().html(transportOverviewFetch['revenue_ytd']);
		$('#transport-transaction-1m').empty().html(transportOverviewFetch['transaction_1m']);
		$('#transport-transaction-ytd').empty().html(transportOverviewFetch['transaction_ytd']);
		$('#transport-achievement-1m').empty().html(transportOverviewFetch['achievement_1m_text']);
		$('#transport-achievement-ytd').empty().html(transportOverviewFetch['achievement_ytd_text']);
		$('#transport-achivementbar-1m').css("width",transportOverviewFetch['achivement_1m']+"%");
		$('#transport-achivementbar-ytd').css("width",transportOverviewFetch['achivement_ytd']+"%");

		//Exim
		const eximOverviewFetch = await $.get('/sales/data/get-division-overview/exim');
		
		$('#exim-revenue-1m').empty().html(eximOverviewFetch['revenue_1m']);
		$('#exim-revenue-ytd').empty().html(eximOverviewFetch['revenue_ytd']);
		$('#exim-transaction-1m').empty().html(eximOverviewFetch['transaction_1m']);
		$('#exim-transaction-ytd').empty().html(eximOverviewFetch['transaction_ytd']);
		$('#exim-achievement-1m').empty().html(eximOverviewFetch['achievement_1m_text']);
		$('#exim-achievement-ytd').empty().html(eximOverviewFetch['achievement_ytd_text']);
		$('#exim-achivementbar-1m').css("width",eximOverviewFetch['achivement_1m']+"%");
		$('#exim-achivementbar-ytd').css("width",eximOverviewFetch['achivement_ytd']+"%");

		//Bulk
		const bulkOverviewFetch = await $.get('/sales/data/get-division-overview/bulk');
		
		$('#bulk-revenue-1m').empty().html(bulkOverviewFetch['revenue_1m']);
		$('#bulk-revenue-ytd').empty().html(bulkOverviewFetch['revenue_ytd']);
		$('#bulk-transaction-1m').empty().html(bulkOverviewFetch['transaction_1m']);
		$('#bulk-transaction-ytd').empty().html(bulkOverviewFetch['transaction_ytd']);
		$('#bulk-achievement-1m').empty().html(bulkOverviewFetch['achievement_1m_text']);
		$('#bulk-achievement-ytd').empty().html(bulkOverviewFetch['achievement_ytd_text']);
		$('#bulk-achivementbar-1m').css("width",bulkOverviewFetch['achivement_1m']+"%");
		$('#bulk-achivementbar-ytd').css("width",bulkOverviewFetch['achivement_ytd']+"%");

		//Table Chart Trends
		@php
			$indexLoader = 0;
		@endphp
		@foreach ($budgets as $b)
			@php
				$indexLoader++;
			@endphp
			var elementId = "{{ $b->id }}";
			// Find the chart intended for this data
			var ctx = $("#"+elementId);
			console.log(ctx);
			$('#loader-index').html('{{ $indexLoader }}')
			try {
				const checkChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
						datasets: [{
							label: '# of Votes',
							data: [12, 19, 3, 5, 2, 3],
							backgroundColor: [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							],
							borderColor: [
								'rgba(255, 99, 132, 1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)'
							],
							borderWidth: 1
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true
							}
						}
					}
				});

				checkChart.destroy();

				//Draw chart
				const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

				const blujayData = await $.get('/sales/data/get-yearly-achievement/'+elementId);

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
		document.getElementById("loader").style.display = "none";
	}
	
</script>