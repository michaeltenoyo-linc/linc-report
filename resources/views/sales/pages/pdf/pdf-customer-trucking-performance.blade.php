<!DOCTYPE html>
<html>
<head>
	<title>PDF HTML {{ $period }} Sales Report</title>
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
			<br><br>
		</div>
	</header>
	
	<section class="overview">
		<div class="row mt-5" style="height: 723px;">
			<div class="col-8 text-white p-5 text-center" style="background-color: #9c0a16;">
				<div class="row">
					<div class="col">
						<b>Overall Revenue</b><br> <span style="font-size: 24pt;">IDR. {{ number_format($overall_revenue,0,',','.') }}</span>
					</div>
					<div class="col">
						<b>Overall Cost</b><br> <span style="font-size: 24pt;">IDR. {{ number_format($overall_cost,0,',','.') }}</span>
					</div>
				</div>
				<div class="row mt-5">
					<div class="col">
						<b>Net Profit</b><br> <span style="font-size: 36pt;">IDR. {{ number_format(($overall_revenue - $overall_cost),0,',','.') }}</span>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<b><span style="font-size: 48pt;">{{ number_format(((($overall_revenue - $overall_cost)/$overall_revenue)*100),0,',','.') }}%</span></b>
					</div>
				</div>
			</div>
		</div>
	</section>

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
							<th scope="col">Customer Detail</th>
							<th scope="col">Rate Performance</th>
							<th scope="col">Load Detail</th>
						</tr>
					</thead>
					<tbody>
						@php
							$index = 1;
						@endphp
						@foreach($customer as $p)
						<tr>
							<th scope="row">{{ $index }}</th>
							<td style="width: 30%;">
								<div style="background-color: lightcoral; padding-left: 3%; margin-bottom: 1%;border-radius: 5px; ">
									<span class="font-weight-bold" style="color:white; background-color:darkred; padding: 1% 5%; border-radius: 5px;">{{ $p->customer_reference }}</span><br>
									<div class="font-weight-bold pt-2 px-2 py-4 h5">{{ $p->customer_name }}</div>
								</div>
							</td>
							<td style="width: 50%;">
								<div>
									<div class="row my-2">
										<div class="col">
											<span style="color:white; background-color:darkred; padding: 2%; margin-right: 1%; border-radius: 50px; font-size: 8pt;">Cost</span><span> IDR. {{ $p->cost_format }}</b></span>
										</div>
										<div class="col-2 text-center">
											<b>{{ $p->totalLoads }} Loads</b> 
										</div>
										<div class="col text-right">
											<span>IDR. {{ $p->revenue_format }} </b></span><span style="color:white; background-color:#067d00; padding: 2%; margin-left: 1%; border-radius: 50px; font-size: 8pt;">Bill</span>
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
											<div class="row justify-content-center" style="font-size: 24pt; font-weight:bold;">
												@if ($p->totalRevenue - $p->totalCost > 0)
													<span style="color: green;">{{ $p->margin_percentage }} %</span>
												@elseif ($p->totalRevenue - $p->totalCost < 0)
													<span style="color: red;">{{ $p->margin_percentage }} %</span>
												@else
													<span>{{ $p->margin_percentage }} %</span>
												@endif
											</div>
											<div class="row justify-content-center">
												<span style="font-size: 12pt;"><b>Net Profit : IDR. {{ $p->net_format }}</b></span>
											</div>
										</div>
									</div>
								</div>
							</td>
								
							<td>
								<div class="row">
									<div class="col">
										<div class="row justify-content-center my-4">
											<button type="button" class="btn btn-outline-info btn-sm btn-customer-trucks" data-toggle="modal" data-target="#modal-customer-trucks" value="{{ $p->customer_reference }}${{ $p->customer_name }}">Unit<br>Detail</button>
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
@include('sales.modals.customer-trucks-modal');


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