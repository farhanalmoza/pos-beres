<table>
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Toko</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deliveries as $delivery)
            <tr>
                <td>{{ $delivery->no_invoice }}</td>
                <td>{{ $delivery->product->code }}</td>
                <td>{{ $delivery->product->name }}</td>
                <td>{{ $delivery->store }}</td>
                <td>{{ $delivery->quantity }}</td>
                <td>{{ $delivery->price }}</td>
                <td>{{ $delivery->quantity * $delivery->price }}</td>
                <td>{{ $delivery->created_at->format('d-m-Y') }}</td>
            </tr>            
        @endforeach
    </tbody>
</table>