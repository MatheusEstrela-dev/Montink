
<div class="max-w-md mx-auto" x-data="cepMapa()" x-init="init()">
  <div class="bg-white p-6 rounded shadow space-y-4">
    <label class="block font-semibold">CEP</label>
    <input
      x-model="cep"
      type="text"
      placeholder="Digite o CEP"
      class="w-full px-3 py-2 border rounded"
    />
    <button
      @click="buscar()"
      class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
    >Buscar</button>

    <template x-if="endereco">
      <div class="text-gray-700 space-y-1">
        <p><strong>Logradouro:</strong> <span x-text="endereco.logradouro"></span></p>
        <p><strong>Bairro:</strong>     <span x-text="endereco.bairro"></span></p>
        <p><strong>Cidade:</strong>     <span x-text="endereco.localidade"></span> /
                                         <span x-text="endereco.uf"></span></p>
      </div>
    </template>
  </div>

  {{-- Mapa Leaflet --}}
  <div id="map" class="mt-4 rounded shadow" style="height:400px;"></div>
</div>

{{-- CSS/JS do Leaflet --}}
<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet/dist/leaflet.css"
/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
function cepMapa() {
  return {
    cep: '',
    endereco: null,
    map: null,
    marker: null,

    init() {
      // inicia o mapa centrado no Brasil
      this.map = L.map('map').setView([-15.7801, -47.9292], 4);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
      }).addTo(this.map);
    },

    async buscar() {
      if (!this.cep) return alert('Informe um CEP!');
      const res = await fetch(`/consulta-cep/${this.cep}`);
      if (!res.ok) return alert('CEP não encontrado');
      this.endereco = await res.json();

      // reposiciona mapa e marcador
      const lat = parseFloat(this.endereco.lat);
      const lon = parseFloat(this.endereco.lon);
      this.map.setView([lat, lon], 15);

      if (this.marker) this.map.removeLayer(this.marker);
      this.marker = L.marker([lat, lon])
        .addTo(this.map)
        .bindPopup(`${this.endereco.logradouro}, ${this.endereco.localidade}`)
        .openPopup();
    }
  }
}
</script>
