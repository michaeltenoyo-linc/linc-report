<!DOCTYPE html>
<html>
<head>
	<title>PDF HTML Load Detail {{ $load_id }}</title>
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
				<div class="col-12 mt-2">
					<center>
						<h1>Load's Detail</h1>
						<h4 class="font-weight-normal">{{ $shipment[0]->customer_name }}</h4>
						<h5 class="font-weight-normal">{{ $load_id }}</h5>
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
			<!-- Load performance detail -->
			<div class="row">
				<div class="col">
					<small>Load ID</small>
					<br>
					<h3>{{ $load_id }}</h3>
					<br>
					<b>Created :</b> {{ $performance->created_date }}
					<br>
					<b>Status :</b> {{ $performance->load_status }}
					<br>
					<b>Group :</b> {{ $performance->load_group }}
					<br>
					<b>Contact :</b> {{ $performance->load_contact }}
				</div>
				<div class="col">
					<small>Vehicle Number</small>
					<br>
					<h3>{{ $performance->vehicle_number }}</h3>
					<br>
					<b>Carrier :</b> {{ $performance->carrier_name }}
					<br>
					<b>Equipment :</b> {{ str_replace('_',' ',$performance->equipment_description) }}
					<br>
					<b>Routes :</b> {{ $performance->first_pick_location_city }} - {{ $performance->last_drop_location_city }}
					<br>
					<b>LT POD :</b> Estimated {{ $performance->lead_time }} days
					<br>
					<b>Weight :</b> {{ $performance->weight_kg }}Kg. / {{ $performance->weight_lb }}Lb.
				</div>
				<div class="col">
					<small>Net.</small>
					<br>
					@if($performance->net > 0)
						<h3 style="color: green;">{{ 'IDR. '.number_format($performance->net, 2, ',', '.') }}</h3>
					@else
						<h3 style="color: red;">{{ 'IDR. '.number_format($performance->net, 2, ',', '.') }}</h3>
					@endif
					<br>
					<b>Billable :</b> <span style="color: green;">{{ 'IDR. +'.number_format($performance->billable_total_rate, 2, ',', '.') }}</span>
					<br>
					<b>Payable :</b> <span style="color: red;">{{ 'IDR. -'.number_format($performance->payable_total_rate, 2, ',', '.') }}</span>
					<br>
					@if($performance->margin_percentage > 0)
						<h1 style="color: green;">{{ $performance->margin_percentage }} %</h3>
					@else
						<h1 style="color: red;">{{ $performance->margin_percentage }} %</h3>
					@endif
				</div>
			</div>
			<hr>
			<!-- Shipment Detail -->
			<div class="row display-4 justify-content-center">
				Shipments
			</div>
			<div class="row my-5">
				@foreach ($shipment as $s)
					<div class="col-4">
						<b>{{ $s->order_number }}</b>
					</div>
				@endforeach
			</div>
		</div>
	</section>
</body>
</html>



<!--Alert Instruction-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
