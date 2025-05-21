<div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($cupons as $cupom)

        @php
            $fundo = match (true) {
                $cupom->codigo === 'SALE20' => 'ticket3.svg',
                $cupom->tipo === 'percentual' => 'ticket1.svg',
                $cupom->tipo === 'fixo' => 'ticket2.svg',
                default => 'ticket3.svg',
            };
        @endphp

        <div
            class="relative rounded-xl p-6 hover:scale-[1.02] transition-all duration-200 cursor-pointer group active:scale-[0.98] text-black"
            style="background-image: url('{{ asset("svg/{$fundo}") }}');
                   background-repeat: no-repeat;
                   background-size: cover;
                   background-position: center;">

            {{-- Código do Cupom --}}
            <div class="text-sm font-medium mb-1">
                Código: {{ $cupom->codigo }}
            </div>

            {{-- Valor --}}
            <div class="text-3xl font-extrabold">
                {{ $cupom->tipo === 'percentual' ? $cupom->valor . '%' : 'R$ ' . number_format($cupom->valor, 2, ',', '.') }}
            </div>

            {{-- Validade --}}
            <div class="text-xs mt-1">
                Válido até: {{ \Carbon\Carbon::parse($cupom->data_validade)->format('d/m/Y') }}
            </div>

            {{-- Status --}}
            <div class="mt-3">
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                    {{ $cupom->ativo ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                    {{ $cupom->ativo ? 'Ativo' : 'Inativo' }}
                </span>
            </div>

        </div>
    @endforeach
</div>
