@include('layouts.header')

<!-- Dashboard -->
<section id="dashboard" class="space-y-6">
  <h1 class="text-2xl font-semibold mb-2">Dashboard Utama</h1>
  <div class="grid grid-cols-1 gap-4">

    <!-- Status Kesehatan -->
    <div class="soft-bg p-4 rounded-lg shadow flex items-center space-x-4">
      <i class="fas fa-heartbeat text-red-500 text-3xl"></i>
      <div>
        <h2 class="font-semibold text-lg">Status Kesehatan</h2>
        <p class="text-gray-700">Normal, tekanan darah stabil</p>
      </div>
    </div>

    <!-- Mood Hari Ini -->
    <div class="soft-bg p-4 rounded-lg shadow flex items-center space-x-4">
      <i class="fas fa-smile-beam text-yellow-400 text-3xl"></i>
      <div>
        <h2 class="font-semibold text-lg">Mood Hari Ini</h2>
        <p class="text-gray-700">Bahagia dan semangat</p>
      </div>
    </div>

    <!-- Lokasi Terakhir -->
    <div class="soft-bg p-4 rounded-lg shadow flex items-center space-x-4">
      <i class="fas fa-map-marker-alt text-blue-500 text-3xl"></i>
      <div>
        <h2 class="font-semibold text-lg">Lokasi Terakhir</h2>
        <p class="text-gray-700">Rumah, Jalan Melati No. 12</p>
      </div>
    </div>

    <!-- Notifikasi Penting -->
    <div class="soft-bg p-4 rounded-lg shadow flex items-center space-x-4">
      <i class="fas fa-bell text-indigo-500 text-3xl"></i>
      <div>
        <h2 class="font-semibold text-lg">Notifikasi Penting</h2>
        <p class="text-gray-700">Pengingat vaksinasi bulan depan</p>
      </div>
    </div>

  </div>
</section>

@include('layouts.footer')