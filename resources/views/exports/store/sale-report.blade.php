<table>
    <thead>
        <tr>
            <th>Invoice</th>
            <th>Produk</th>
            <th>Jml</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Member</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale['no_invoice'] }}</td>
                <td>{{ $sale['product_name'] }}</td>
                <td>{{ $sale['product_quantity'] }}</td>
                <td>{{ $sale['product_price'] }}</td>
                <td>{{ $sale['total'] }}</td>
                <td>{{ $sale['member'] }}</td>
                <td>{{ $sale['date'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>