<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gold border border-transparent rounded-full font-semibold text-xs text-coffee-darkest uppercase tracking-widest hover:opacity-80 focus:bg-gold active:bg-gold focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2 transition ease-in-out duration-150']) }} style="background-color: var(--gold); color: var(--coffee-darkest);">
    {{ $slot }}
</button>
