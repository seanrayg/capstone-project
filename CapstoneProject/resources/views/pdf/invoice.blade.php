<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>

	<link rel="stylesheet" type="text/css" href="css/reports.css">
</head>
<body>
	<div class="header">
		<div class="column-left">
			<p class="title">INVOICE</p>
		</div>
		<div class="column-right">
			<p class="resort">
				Il Sogno Beach Resort<br>
				Nagkaan Locloc, Bauan, Batangas<br>
				OLIVIA R. VILLANUEVA - Prop.
			</p>
		</div>
	</div>

	<br>

	<div class="info">
		<div class="column-left">
			<div style="padding-left: 20px;">
				<label class="parent">Billed To</label><br>
				<label id="CustomerName">
					{{ $CustomerName }} <br>
					{{ $CustomerAddress }}
				</label>
			</div>
		</div>
		<div class="column-right">
			<label class="parent">Invoice Number</label><br>
			<label id="CustomerName">{{ $InvoiceNumber }}</label><br>
			<label class="parent">Date Of Issue</label><br>
			<label id="CustomerName">{{ $date }}</label>
		</div>
	</div>

	<br>
	<br>
	<br>
	<br>
	<hr style="clear: left;">

	<table>
	<tr>
		<th>Description</th>
		<th>Price/Rate</th>
		<th>Qty</th>
		<th>Amount</th>
	</tr>
	<tbody>
		@if($InvoiceType == 'Reservation')
		  	@if(!$boolIsPackaged)
	  		  	@foreach($rooms as $room)
	  				<tr>
	  					<td style="width: 60%;">{{ $room->strRoomType }}</td>
	  					<td style="width: 20%;">{{ $room->dblRoomRate }}</td>
	  					<td style="width: 20%;">{{ $room->quantity }}</td>
	  					<td style="width: 20%;">{{ $room->amount }}</td>
	  				</tr>
	  		  	@endforeach
	  		  	@foreach($fees as $fee)
	  				<tr>
	  					<td>{{ $fee->name }}</td>
	  					<td>{{ $fee->price }}</td>
	  					<td>{{ $fee->quantity }}</td>
	  					<td>{{ $fee->amount }}</td>
	  				</tr>
	  		  	@endforeach
	  		  	@foreach($boats as $boat)
	  				<tr>
	  					<td>{{ $boat->strBoatName }}</td>
	  					<td>{{ $boat->dblBoatRate }}</td>
	  					<td>{{ $boat->quantity }}</td>
	  					<td>{{ $boat->amount }}</td>
	  				</tr>
	  		  	@endforeach
		  	@else
		  		@foreach($packages as $package)
	  				<tr>
	  					<td style="width: 60%;">{{ $package->strPackageName }}</td>
	  					<td style="width: 20%;">{{ $package->dblPackagePrice }}</td>
	  					<td style="width: 20%;">{{ $package->quantity }}</td>
	  					<td style="width: 20%;">{{ $package->amount }}</td>
	  				</tr>
	  		  	@endforeach
		  	@endif
		@endif
	</tbody>
	</table>

	<label class="total">Total Due: {{ $total }}</label>
</body>
</html>
