<table>
    <thead>
        <tr>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->product->code }} - {{ $purchase->product->name }}</td>
                <td>{{ $purchase->quantity }}</td>
                <td>{{ $purchase->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>