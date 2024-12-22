<table>
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
            @foreach ($purchase->carts as $cart)
                <tr>
                    <td>{{ $cart->product->code }}</td>
                    <td>{{ $cart->product->name }}</td>
                    <td>{{ $cart->quantity }}</td>
                    <td>{{ $cart->price }}</td>
                    <td>{{ $cart->quantity * $cart->price }}</td>
                    <td>{{ $purchase->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>