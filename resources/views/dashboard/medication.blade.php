@include('layouts.header')

<!-- Pengingat Obat -->
<div id="medication" class="space-y-4">
  <h1 class="text-2xl font-semibold mb-2">Pengingat Obat</h1>
    <ul class="divide-y divide-gray-300 border rounded-lg overflow-hidden">
      <li class="flex items-center justify-between p-4 bg-white">
        <div>
          <p class="font-semibold">Paracetamol 500mg</p>
          <p class="text-gray-600 text-sm">08:00 AM</p>
        </div>
        <div>
          <input type="checkbox" id="med1" class="w-5 h-5" />
          <label for="med1" class="ml-2 text-gray-700">Sudah diminum</label>
        </div>
      </li>
      <li class="flex items-center justify-between p-4 bg-white">
        <div>
          <p class="font-semibold">Vitamin C</p>
          <p class="text-gray-600 text-sm">12:00 PM</p>
        </div>
        <div>
          <input type="checkbox" id="med2" class="w-5 h-5" />
          <label for="med2" class="ml-2 text-gray-700">Sudah diminum</label>
        </div>
      </li>
      <li class="flex items-center justify-between p-4 bg-white">
        <div>
          <p class="font-semibold">Obat Kolesterol</p>
          <p class="text-gray-600 text-sm">06:00 PM</p>
        </div>
        <div>
          <input type="checkbox" id="med3" class="w-5 h-5" />
          <label for="med3" class="ml-2 text-gray-700">Sudah diminum</label>
        </div>
      </li>
    </ul>
</div>

@include('layouts.footer')