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
				<br>
				<br>
				<label class="parent">Days of Stay:</label>
				<label id="CustomerName">
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
		@if($InvoiceType == 'Reservation' || $InvoiceType == 'WalkIn' || $InvoiceType == 'WalkInPackage')
			<tr>
				<th style="width: 60%;">Description</th>
				<th style="width: 20%;">Price/Rate</th>
				<th style="width: 20%;">Quantity</th>
				<th style="width: 20%;">Amount</th>
			</tr>
		@endif
	<tbody>
		@if($InvoiceType == 'Reservation')
		  	@if(!$boolIsPackaged)
	  		  	@foreach($rooms as $room)
	  				<tr>
	  					<td>{{ $room->strRoomType }}</td>
	  					<td style="text-align: center;">{{ $room->dblRoomRate }}</td>
	  					<td style="text-align: center;">{{ $room->quantity }}</td>
	  					<td style="text-align: right;">{{ $room->amount }}</td>
	  				</tr>
	  		  	@endforeach
	  		  	@foreach($fees as $fee)
	  				<tr>
	  					<td>{{ $fee->name }}</td>
	  					<td style="text-align: center;">{{ $fee->price }}</td>
	  					<td style="text-align: center;">{{ $fee->quantity }}</td>
	  					<td style="text-align: right;">{{ $fee->amount }}</td>
	  				</tr>
	  		  	@endforeach
	  		  	@foreach($boats as $boat)
	  				<tr>
	  					<td>{{ $boat->strBoatName }}</td>
	  					<td style="text-align: center;">{{ $boat->dblBoatRate }}</td>
	  					<td style="text-align: center;">{{ $boat->quantity }}</td>
	  					<td style="text-align: right;">{{ $boat->amount }}</td>
	  				</tr>
	  		  	@endforeach
		  	@else
		  		@foreach($packages as $package)
	  				<tr>
	  					<td>{{ $package->strPackageName }}</td>
	  					<td style="text-align: center;">{{ $package->dblPackagePrice }}</td>
	  					<td style="text-align: center;">{{ $package->quantity }}</td>
	  					<td style="text-align: right;">{{ $package->amount }}</td>
	  				</tr>
	  		  	@endforeach
		  	@endif
		@elseif($InvoiceType == 'WalkIn')
		  	@foreach($rooms as $room)
				<tr>
					<td>{{ $room->name }}</td>
					<td style="text-align: center;">{{ $room->price }}</td>
					<td style="text-align: center;">{{ $room->quantity }}</td>
					<td style="text-align: right;">{{ $room->amount }}</td>
				</tr>
		  	@endforeach
		  	@foreach($EntranceFee as $ef)
  				<tr>
  					<td>{{ $ef->name }}</td>
  					<td style="text-align: center;">{{ $ef->price }}</td>
  					<td style="text-align: center;">{{ $ef->quantity }}</td>
  					<td style="text-align: right;">{{ $ef->amount }}</td>
  				</tr>
  		  	@endforeach
		  	@foreach($fees as $fee)
				<tr>
					<td>{{ $fee->name }}</td>
					<td style="text-align: center;">{{ $fee->price }}</td>
					<td style="text-align: center;">{{ $fee->quantity }}</td>
					<td style="text-align: right;">{{ $fee->amount }}</td>
				</tr>
		  	@endforeach
		@elseif($InvoiceType == 'WalkInPackage')
			@foreach($package as $p)
				<tr>
					<td>{{ $p->name }}</td>
					<td style="text-align: center;">{{ $p->price }}</td>
					<td style="text-align: center;">{{ $p->quantity }}</td>
					<td style="text-align: right;">{{ $p->amount }}</td>
				</tr>
		  	@endforeach
		@endif

		@for($i = $TableRows; $i <= 10; $i++)
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		@endfor
	</tbody>
	</table>

	<label class="total-amount">{{ $total }}</label>
	<label class="total">TOTAL Due:</label>

	<table style="width: 60%">
		<tr>
			<th>Other Comments</th>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>
</body>
</html>
