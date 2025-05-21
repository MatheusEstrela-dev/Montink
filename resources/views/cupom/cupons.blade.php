<div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($cupons as $cupom)
        <div
            class="relative bg-yellow-100 border border-yellow-500 rounded-xl p-4 shadow-lg
                   hover:shadow-xl hover:scale-[1.02] transition-all duration-200 cursor-pointer group active:scale-[0.98]"
            style="background-image: url('{{ asset('svg/ticket2.svg') }}'); background-repeat: no-repeat; background-position: right top; background-size: 60px;">

            {{-- Conteúdo do cupom --}}
            <div class="text-sm font-semibold text-gray-700 mb-2">
                Código: {{ $cupom->codigo }}
            </div>

            <div class="text-3xl font-extrabold text-gray-900">
                {{ $cupom->tipo === 'percentual' ? $cupom->valor . '%' : 'R$ ' . number_format($cupom->valor, 2, ',', '.') }}
            </div>

            <div class="text-xs text-gray-600 mt-1">
                Válido até: {{ \Carbon\Carbon::parse($cupom->data_validade)->format('d/m/Y') }}
            </div>

            <div class="mt-3">
                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full
                    {{ $cupom->ativo ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                    {{ $cupom->ativo ? 'Ativo' : 'Inativo' }}
                </span>
            </div>

        </div>
    @endforeach
</div>
