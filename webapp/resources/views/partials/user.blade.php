<li>
    <a href="/users/{{ $user->id }}">
        {{ $user->nome }}
        @if ($user->banned)
            (BANIDO)
        @elseif ($user->became_admin)
            (PROMOVIDO)
        @endif
    </a>
    <p>
        <span>{{ $user->email }}</span>
    </p>
</li>
