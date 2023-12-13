<li>
    <a href="/users/{{ $userId }}/orders/{{ $purchase->id }}">Encomenda REF {{ $purchase->id }}</a>
    <p>
        <span class="order{{ $purchase->id }}State">Estado: {{ $purchase->estado }}</span><br>
        <span>{{ $purchase->total }}€</span><br>
        <span>{{ $purchase->timestamp }}</span>
    </p>
</li>
