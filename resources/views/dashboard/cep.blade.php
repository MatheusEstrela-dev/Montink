@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto" x-data="cepMapa()" x-init="init()">


  {{-- Formulário --}}
  <div class="bg-white p-6 rounded shadow space-y-4">
    <label class="block font-semibold">CEP</label>
    <div class="flex gap-2">
      <input
        x-model="cep"
        @keyup.enter="buscar()"
        type="text"
        placeholder="Digite o CEP"
        class="flex-1 px-3 py-2 border rounded focus:outline-none focus:ring"
      />
      <button
        @click="buscar()"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
      >Buscar</button>
    </div>

    <template x-if="endereco">
      <div class="text-gray-700 space-y-1">
        <p><strong>Logradouro:</strong> <span x-text="endereco.logradouro"></span></p>
        <p><strong>Bairro:</strong>     <span x-text="endereco.bairro"></span></p>
        <p><strong>Cidade:</strong>     <span x-text="endereco.localidade + ' / ' + endereco.uf"></span></p>
      </div>
    </template>
  </div>

  {{-- Mapa --}}
  <div id="map" class="mt-4 rounded shadow" style="height:400px;"></div>
</div>
@endsection

@push('styles')
  <!-- Leaflet CSS -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet/dist/leaflet.css"
  />
@endpush

@push('scripts')
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!-- Componente Alpine.js -->
  <script>
    function cepMapa() {
      return {
        cep: '',
        endereco: null,
        map: null,
        marker: null,

        init() {
          // cria o mapa centrado no Brasil
          this.map = L.map('map').setView([-15.7801, -47.9292], 4)
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
          }).addTo(this.map)
        },

        async buscar() {
          if (!this.cep.trim()) {
            alert('Informe um CEP!')
            return
          }
          const res = await fetch(`/consulta-cep/${this.cep.trim()}`)
          if (!res.ok) {
            alert('CEP não encontrado.')
            return
          }
          this.endereco = await res.json()

          const lat = parseFloat(this.endereco.lat)
          const lon = parseFloat(this.endereco.lon)
          this.map.setView([lat, lon], 15)

          if (this.marker) this.map.removeLayer(this.marker)
          this.marker = L.marker([lat, lon])
            .addTo(this.map)
            .bindPopup(`${this.endereco.logradouro}, ${this.endereco.localidade}`)
            .openPopup()
        }
      }
    }
  </script>
@endpush
