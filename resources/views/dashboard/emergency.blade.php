@include('layouts.header')

<!-- Tombol Darurat -->
<div id="emergency" class="flex flex-col items-center justify-center space-y-6 p-4">
    <button class="btn-emergency text-white font-bold text-xl rounded-full w-40 h-40 flex items-center justify-center shadow-lg focus:outline-none focus:ring-4 focus:ring-red-600">
        <i class="fas fa-phone-volume fa-2x"></i>
        <span class="block mt-2">Tombol Darurat</span>
    </button>
    <p class="text-center text-gray-700 max-w-xs">Tekan tombol ini untuk mengirim notifikasi darurat dan menghubungi rumah sakit atau call center.</p>
</div>

@include('layouts.footer')