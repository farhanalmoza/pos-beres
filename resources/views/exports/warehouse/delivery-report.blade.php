<table>
    <thead>
        <tr>
            <th>Barang</th>
            <th>Toko</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deliveries as $delivery)
            <tr>
                <td>{{ $delivery['product']['code'] }} - {{ $delivery['product']['name'] }}</td>
                <td>{{ $delivery['store']['name'] }}</td>
                <td>{{ $delivery['quantity'] }}</td>
                <td>{{ \Carbon\Carbon::parse($delivery['created_at'])->format('d-m-Y') }}</td>
            </tr>            
        @endforeach
    </tbody>
</table>