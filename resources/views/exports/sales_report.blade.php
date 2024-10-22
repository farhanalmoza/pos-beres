<table>
	<thead>
		<tr>
			<th>Barang</th>
			<th>SKU</th>
			<th>Kategori</th>
			<th>Terjual</th>
			<th>Pendapatan</th>
			<th>Sisa</th>
		</tr>
	</thead>
	<tbody>
		@foreach($sales as $sale)
		<tr>
			<td>{{ $sale['product_name'] }}</td>
			<td>{{ $sale['product_code'] }}</td>
			<td>{{ $sale['product_category'] }}</td>
			<td>{{ $sale['sold_quantity'] }}</td>
			{{-- <td>{{ number_format($sale['revenue'], 0, ',', '.') }}</td> --}}
			<td>{{ $sale['revenue'] }}</td>
			<td>{{ $sale['remaining_stock'] }}</td>
		</tr>
		@endforeach
	</tbody>
</table>