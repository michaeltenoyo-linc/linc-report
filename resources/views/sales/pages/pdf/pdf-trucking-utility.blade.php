<!DOCTYPE html>
<html>
<head>
	<title>PDF HTML {{ $period }} Trucking Utility</title>
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
			<h1>Please wait for all graphs to be loaded (<span id="loader-index"></span>/{{ count($unit) }})...</h1>
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
						<h1>Trucking Utility Report</h1>
						<h5 class="font-weight-normal">{{ $period }}</h5>
					</center>
				</div>
			</div>
		</div>

		<div>
			<br><br>
		</div>
	</header>
	
	<section class="overview">
		<div class="row mt-5" style="height: 723px;">
			<!-- Overview Section -->
			<div class="col-8 text-white p-5 text-center" style="background-color: #9c0a16;">
				<div class="row">
					<div class="col">
						<div class="row font-weight-bold" style="font-size: 12pt;">
							<div class="col">
								Average On Call This Month
							</div>
						</div>
						<div class="row">
							<div class="col">
								<span style="font-size: 32pt;">{{ $avg_on_call_percentage }}%</span>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<span style="font-size: 12pt;">{{ $avg_on_call }} days</span>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="row font-weight-bold" style="font-size: 12pt;">
							<div class="col">
								Average Idle This Month
							</div>
						</div>
						<div class="row">
							<div class="col">
								<span style="font-size: 32pt;">{{ $avg_idle_percentage }}%</span>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<span style="font-size: 12pt;">{{ $avg_idle }} days</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row my-4">
					<div class="col">
						<div class="progress">
							<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $avg_on_call_percentage }}%" aria-valuenow="{{ $avg_on_call_percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $avg_on_call_percentage }}%</div>
						</div>
					</div>
				</div>
				<div class="row my-4">
					<div class="col">
						<div class="row">
							<div class="col font-weight-bold" style="font-size: 12pt;">
								Today Activities : {{ $today_full_date }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="table-data">
		<div class="container">
			<div class="mb-4 mt-5 text-danger text-xs">
				<br>
				<small>*All the calculation is based on realtime blujay's loads data</small>
				<br>
				<small>*The values in the table are sorted by current month's activity rate</small>
			</div>
			<div class="row">
				<table class="table" style="width: 100%; font-size: 9pt;">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Truck Detail</th>
							<th scope="col">Activity Performance</th>
							<th scope="col">Activity Detail</th>
						</tr>
					</thead>
					<tbody>
						@php
							$index = 1;
						@endphp
						@foreach($unit as $p)
						<tr>
							<th scope="row">{{ $index }}</th>
							<!--Truck Information-->
							<td style="width: 30%;">
								<div style="background-color: lightcoral; padding-left: 3%; margin-bottom: 1%;border-radius: 5px; ">
									<span class="font-weight-bold" style="color:white; background-color:darkred; padding: 1% 5%; border-radius: 5px;">{{ $p->own }}</span><br>
									<div class="font-weight-bold pt-2 px-2 h5">{{ $p->nopol }}</div>
									<div class="font-weight-bold py-2 px-2">UNIT : {{ $p->type }}</div>
								</div>
								<div class="py-2 pl-2">Current Driver : {{ $p->driver }}</div>
							</td>

							<!--Activity Performance-->
							<td style="width: 50%; font-size:12pt;">
								<div class="row">
									<div class="col">
										<div class="row text-center text-danger font-weight-bold" style="font-size: 16pt;">
											<div class="col">
												{{ $p->idle_percentage }}%
											</div>
										</div>
										<div class="row text-center font-weight-bold" style="font-size: 10pt;">
											<div class="col">
												{{ $p->count_idle }} days
											</div>
										</div>
										<div class="row text-center font-weight-bold" style="font-size: 8pt;">
											<div class="col">
												Idle
											</div>
										</div>
									</div>
									
									<div class="col">
										<div class="row text-center text-success font-weight-bold" style="font-size: 16pt;">
											<div class="col">
												{{ $p->on_call_percentage }}%
											</div>
										</div>
										<div class="row text-center font-weight-bold" style="font-size: 10pt;">
											<div class="col">
												{{ $p->count_on_call }} days
											</div>
										</div>
										<div class="row text-center font-weight-bold" style="font-size: 8pt;">
											<div class="col">
												On Call
											</div>
										</div>
									</div>
									
									<div class="col">
										<div class="row text-center text-warning font-weight-bold" style="font-size: 16pt;">
											<div class="col">
												0%
											</div>
										</div>
										<div class="row text-center font-weight-bold" style="font-size: 10pt;">
											<div class="col">
												0 days
											</div>
										</div>
										<div class="row text-center font-weight-bold" style="font-size: 8pt;">
											<div class="col">
												Breakout
											</div>
										</div>
									</div>
								</div>
								<div class="row my-1">
									<div class="col">
										<div class="progress mt-1">
											<div class="progress-bar" role="progressbar" style="background-color: #067d00; width: {{ $p->on_call_percentage }}%" aria-valuenow="{{ $p->on_call_percentage }}" aria-valuemin="0" aria-valuemax="100">{{ $p->on_call_percentage }}%</div>
										</div>
									</div>
								</div>
								<div class="row justify-content-center">
									<div style="font-size:10pt;"><b>1</b></div>
									@foreach ($p->activity as $act)
										@if ($act == "idle")
											<div class="mx-1" style="width: 1.3%; height: 10px; border-radius: 2px; background-color: #9c0a16;"></div>
										@else
											<div class="mx-1" style="width: 1.3%; height: 10px;  border-radius: 2px; background-color: #067d00;"></div>
										@endif
									@endforeach
									<div style="font-size:10pt;"><b>{{ count($p->activity) }}</b></div>
								</div>
							</td>
							
							<!-- Activity Detail -->
							<td>
								<div class="row">
									<div class="col">
										<div class="row justify-content-center my-4">
											<button type="button" class="btn btn-outline-info btn-sm btn-truck-activity" data-toggle="modal" data-target="#modal-truck-activity" value="{{ $p->nopol }}${{ $p->type }}">Activity<br>Detail</button>
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
@include('sales.modals.truck-activitiy-modal');


<!--Alert Instruction-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
	Swal.fire(
		'How to save as PDF?',
		'Right Click -> Print -> Save as PDF',
		'question'
	);
</script>
<script>
	//ON CLICK TRUCK TO CUSTOMERS
	$(document).on('click', '.btn-truck-activity', async function(e){
		e.preventDefault();

        let btnData = $(this).val().split('$');

		let nopol = btnData[0];
		let unitType = btnData[1];
		console.log("Open Modal :"+nopol);

		//Data Init and Reset
		$('#modal-nopol').html(nopol);
		$('#modal-unit-type').html(unitType);
		$('#modal-truck-activity .calendar-list').empty();
		$('#modal-truck-activity .calendar-activity-message').html("<< Choose a date >>");
		$('#modal-truck-activity .calendar-activity-dd').html("DD");
		$('#modal-truck-activity .calendar-activity-mm').html("MM");
		$('#modal-truck-activity .calendar-activity-yyyy').html("YYYY");
		$('#modal-truck-activity .calendar-activity-day').html("DAYNAME");
		$('#modal-truck-activity .calendar-activity-detail').html("DETAIL ACTIVITY");


		//Calendar Listing
		const fetchCalendar = await $.get('/sales/truck/get-trucking-calendar/'+nopol);
		let date = 1;
		fetchCalendar['unit']['activity'].forEach(row => {
			let dayName = fetchCalendar['unit']['dayName'][date-1];
			let color = "btn-success";
			if(row == "idle"){
				color = "btn-danger";
			}

			let divDateActivity = "<div class='col-2'>"
				+"<div class='row'>"
				+"<div class='col btn "+color+" m-1 show-date-detail' type='button' id='"+date+"-"+fetchCalendar['month']+"-"+fetchCalendar['year']+"-"+dayName+"-"+row+"'>"
				+"<div class='row'><div class='col'>"
				+date	
				+"</div></div>"
				+"<div class='row' style='font-size:10pt;'><div class='col'>"
				+dayName	
				+"</div></div>"
				+"</div>"					
				+"</div>"
				+"</div>";
				
			$('#modal-truck-activity .calendar-list').append(divDateActivity);
			date++;
		});
	});

	$(document).on('click', '.show-date-detail', async function(e){
		let selected = $(this).attr('id').split('-');
		
		$('#modal-truck-activity .calendar-activity-dd').html(selected[0]);
		$('#modal-truck-activity .calendar-activity-mm').html(selected[1]);
		$('#modal-truck-activity .calendar-activity-yyyy').html(selected[2]);
		$('#modal-truck-activity .calendar-activity-day').html(selected[3]);

		//Activity Detailing
		if(selected[4] == 'idle'){
			$('#modal-truck-activity .calendar-activity-detail').html("Idle or Delay");
		}else{
			$('#modal-truck-activity .calendar-activity-detail').html("<a href='{{ url('/sales/load-detail') }}/"+selected[4]+"' target='_blank'><button type='button' class='btn btn-info'>"+selected[4]+"</button></a>");
		}
		
	});
</script>