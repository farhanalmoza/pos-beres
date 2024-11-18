<table>
    <thead>
        <tr>
            <th>Barang</th>
            <th>Supplier</th>
            <th>Harga</th>
            <th>Jml</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchases as $purchase)
            <tr>
                <td>{{ $purchase['product']['code'] }} - {{ $purchase['product']['name'] }}</td>
                <td>{{ $purchase['supplier']['name'] }}</td>
                <td>{{ $purchase['product']['price'] }}</td>
                <td>{{ $purchase['quantity'] }}</td>
                <td>{{ $purchase['product']['price'] * $purchase['quantity'] }}</td>
                <td>{{ \Carbon\Carbon::parse($purchase['created_at'])->format('d-m-Y') }}</td>
            </tr>            
        @endforeach
    </tbody>
</table>