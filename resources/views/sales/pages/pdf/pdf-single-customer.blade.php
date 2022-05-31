<!DOCTYPE html>
<html>
<head>
	<title>PDF HTML {{ $customer->customer_name }} {{ $period }}</title>
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
				<div class="col-12 mt-3 mb-3">
					<center>
						<img width="25%" src="{{ asset('assets/novena/images/logo.png') }}" alt="No image found" class="img-fluid">
					</center>
				</div>	
				<div class="col-12 mb-5">
					<center>
						<img style="height:150px;" src="{{ asset('assets/icons/customers/'.$customer->customer_reference.'.png') }}" alt="Image not found" class="img-fluid icon-customer">
					</center>
				</div>	
				<div class="col-12 mt-2">
					<center>
						<h1>Sales Report</h1>
						<h4><u>{{ $customer->customer_name }}</u></h4>
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
			<div class="mb-4 mt-1 text-danger text-xs">
				<br>
				<small>*All the calculation is based on realtime blujay's data <b>(billable total rate)</b></small>
				<br>
				<small>*The values in the table are sorted by current month's <b>(closed date)</b> actual rates</small>
			</div>
			<div class="row">
				<table class="table" style="width: 100%; font-size: 9pt;">
					<thead>
						<tr>
							<th scope="col">#</th>
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
							<th scope="row">{{ $index }}</th>
							<td style="width: 30%;">
								<div style="background-color: lightcoral; padding-left: 3%; margin-bottom: 1%;border-radius: 5px; ">
									<span class="font-weight-bold" style="color:white; background-color:darkred; padding: 1% 5%; border-radius: 5px;">{{ $b->customer_sap }}</span><br>
									<div class="font-weight-bold pt-2 px-2 h5">{{ $b->customer_name }}</div>
									<div class="font-weight-bold py-2 px-2">{{ $b->division }} Division</div>
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
	$(document).ready(function()
	{
		$(".icon-customer").on("error", function(){
			$(this).attr('src', '{{ asset('assets/icons/customers/default.png') }}');
		});
	});
</script>
<script>
	Swal.fire(
		'How to save as PDF?',
		'Right Click -> Print -> Save as PDF',
		'question'
	)
	
	window.onload = async function(e){
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