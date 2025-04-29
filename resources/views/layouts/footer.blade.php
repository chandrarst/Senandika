</main>

<!-- Bottom Navigation Bar -->
<nav class="bg-white border-t border-gray-300 fixed bottom-0 left-0 right-0 flex justify-around items-center h-16 shadow-inner">
  <a href="{{ route('dashboard') }}" class="nav-btn flex flex-col items-center text-gray-600 hover:text-blue-600">
    <i class="fas fa-tachometer-alt text-xl"></i>
    <span class="text-xs mt-1">Dashboard</span>
  </a>
  <a href="{{ route('medication') }}" class="nav-btn flex flex-col items-center text-gray-600 hover:text-blue-600">
    <i class="fas fa-pills text-xl"></i>
    <span class="text-xs mt-1">Obat</span>
  </a>
  <a href="{{ route('chatbot') }}" class="nav-btn flex flex-col items-center text-gray-600 hover:text-blue-600">
    <i class="fas fa-robot text-xl"></i>
    <span class="text-xs mt-1">Chatbot</span>
  </a>
  <a href="{{ route('emergency') }}" class="nav-btn flex flex-col items-center text-red-600 hover:text-red-700">
    <i class="fas fa-phone-volume text-xl"></i>
    <span class="text-xs mt-1 font-semibold">Darurat</span>
  </a>
  <a href="{{ route('location') }}" class="nav-btn flex flex-col items-center text-gray-600 hover:text-blue-600">
    <i class="fas fa-map-marker-alt text-xl"></i>
    <span class="text-xs mt-1">Lokasi</span>
  </a>
  <a href="{{ route('consultation') }}" class="nav-btn flex flex-col items-center text-gray-600 hover:text-blue-600">
    <i class="fas fa-user-md text-xl"></i>
    <span class="text-xs mt-1">Dokter</span>
  </a>
  <a href="{{ route('profile') }}" class="nav-btn flex flex-col items-center text-gray-600 hover:text-blue-600">
    <i class="fas fa-id-card text-xl"></i>
    <span class="text-xs mt-1">Profil</span>
  </a>
</nav>

<script>
  // Navigation button click handler
  const navButtons = document.querySelectorAll('.nav-btn');
  const sections = document.querySelectorAll('main > section');

  function showSection(targetId) {
    sections.forEach(section => {
      if (section.id === targetId) {
        section.classList.remove('hidden');
      } else {
        section.classList.add('hidden');
      }
    });
  }

  navButtons.forEach(button => {
    button.addEventListener('click', () => {
      showSection(button.getAttribute('data-target'));
    });
  });

  // Show dashboard by default
  showSection('dashboard');
</script>

</body>
</html>