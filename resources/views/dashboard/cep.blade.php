<div class="bg-white rounded shadow p-6 max-w-md mx-auto" x-data="{ cep: '', buscando: false, resultado: null }">
    <label for="cep" class="block text-gray-700 mb-2 font-medium">CEP</label>
    <input type="text" id="cep" maxlength="9"
           class="w-full p-2 border rounded mb-4 text-black" placeholder="Digite o CEP"
           x-model="cep">

    <button
        @click="buscarCEP"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
    >
        Buscar
    </button>

    <div x-show="buscando" class="animate-spin w-6 h-6 border-4 border-blue-300 border-t-white rounded-full ml-2"></div>

    <div class="mt-4" x-show="resultado">
        <p><strong>Logradouro:</strong> <span x-text="resultado.logradouro"></span></p>
        <p><strong>Bairro:</strong> <span x-text="resultado.bairro"></span></p>
        <p><strong>Cidade:</strong> <span x-text="resultado.localidade"></span></p>
        <p><strong>UF:</strong> <span x-text="resultado.uf"></span></p>
    </div>

    <script>
        function buscarCEP() {
            this.buscando = true;
            fetch(`https://viacep.com.br/ws/${this.cep}/json/`)
                .then(res => res.json())
                .then(data => {
                    this.resultado = data;
                    this.buscando = false;
                })
                .catch(() => this.buscando = false);
        }
    </script>
</div>
