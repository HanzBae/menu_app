<form method="POST" action="{{ route('cart.checkout') }}">
@csrf

<input type="text" name="customer_name" placeholder="Nama Pelanggan" required>
<input type="text" name="table_number" placeholder="No Meja" required>

<button type="submit">Pesan</button>
</form>