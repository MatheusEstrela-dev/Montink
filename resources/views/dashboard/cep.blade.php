<div class="bg-white rounded shadow p-6 max-w-md mx-auto">
    <label for="cep" class="block text-gray-700 mb-2 font-medium">CEP</label>
    <input type="text" id="cep" maxlength="9"
           class="w-full p-2 border rounded mb-4 text-black" placeholder="Digite o CEP">

    <div id="resultado" class="hidden text-sm text-gray-800 space-y-1">
        <p><strong>Logradouro:</strong> <span id="logradouro"></span></p>
        <p><strong>Bairro:</strong> <span id="bairro"></span></p>
        <p><strong>Cidade:</strong> <span id="localidade"></span></p>
        <p><strong>Estado:</strong> <span id="uf"></span></p>
    </div>
</div>

<script>
document.getElementById('cep').addEventListener('blur', async function () {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length !== 8) return;

    try {
        const response = await fetch(`/consulta-cep/${cep}`);
        const data = await response.json();

        if (!data.erro) {
            document.getElementById('logradouro').textContent = data.logradouro;
            document.getElementById('bairro').textContent = data.bairro;
            document.getElementById('localidade').textContent = data.localidade;
            document.getElementById('uf').textContent = data.uf;
            document.getElementById('resultado').classList.remove('hidden');
        } else {
            alert('CEP não encontrado.');
        }
    } catch (e) {
        alert('Erro ao buscar CEP.');
        console.error(e);
    }
});
</script>
