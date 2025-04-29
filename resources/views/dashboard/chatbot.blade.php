@include('layouts.header')

<!-- Chatbot Container -->
<div class="container mx-auto max-w-2xl p-4">
    <!-- Chatbot Header -->
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold text-gray-800">Chatbot Teman Ngobrol</h1>
        <div id="status-indicator" class="flex items-center">
            <span class="h-3 w-3 rounded-full bg-gray-400 mr-2"></span>
            <span class="text-sm text-gray-500">Offline</span>
        </div>
    </div>

    <!-- Chat Messages Area -->
    <div id="chatbox" class="border border-gray-200 rounded-lg p-4 h-96 overflow-y-auto mb-4 bg-gray-50 shadow-inner">
        <div class="text-center text-gray-500 italic py-8">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p>Mulai ngobrol dengan menekan tombol mikrofon</p>
        </div>
    </div>

    <!-- Voice Button -->
    <div class="flex justify-center">
        <button id="voiceBtn" class="relative w-20 h-20 bg-red-500 hover:bg-red-600 text-white text-3xl rounded-full shadow-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-50 flex items-center justify-center">
            <span id="mic-icon">🎤</span>
            <div id="recording-indicator" class="absolute -top-2 -right-2 h-5 w-5 bg-red-600 rounded-full hidden animate-pulse"></div>
        </button>
    </div>

    <!-- Error Message Area -->
    <div id="error-message" class="mt-2 text-red-500 text-sm hidden"></div>

    <!-- Loading Indicator -->
    <div id="loading-indicator" class="text-center py-2 hidden">
        <div class="inline-block animate-spin rounded-full h-5 w-5 border-b-2 border-gray-600"></div>
        <span class="ml-2 text-gray-600">Bot sedang mengetik...</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const voiceBtn = document.getElementById('voiceBtn');
        const chatbox = document.getElementById('chatbox');
        const statusIndicator = document.getElementById('status-indicator');
        const errorMessage = document.getElementById('error-message');
        const loadingIndicator = document.getElementById('loading-indicator');
        const recordingIndicator = document.getElementById('recording-indicator');
        const micIcon = document.getElementById('mic-icon');

        // Check browser compatibility
        if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
            showError('Browser Anda tidak mendukung fitur Speech Recognition. Gunakan Chrome atau Edge versi terbaru.');
            voiceBtn.disabled = true;
            voiceBtn.classList.add('opacity-50', 'cursor-not-allowed');
            return;
        }

        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        const recognition = new SpeechRecognition();
        recognition.lang = 'id-ID';
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        const synth = window.speechSynthesis;
        let isSpeaking = false;

        function updateStatus(connected) {
            const statusDot = statusIndicator.querySelector('span:first-child');
            const statusText = statusIndicator.querySelector('span:last-child');
            
            if (connected) {
                statusDot.classList.remove('bg-gray-400');
                statusDot.classList.add('bg-green-500');
                statusText.textContent = 'Online';
                statusText.classList.remove('text-gray-500');
                statusText.classList.add('text-green-600');
            } else {
                statusDot.classList.remove('bg-green-500');
                statusDot.classList.add('bg-gray-400');
                statusText.textContent = 'Offline';
                statusText.classList.remove('text-green-600');
                statusText.classList.add('text-gray-500');
            }
        }

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
            setTimeout(() => errorMessage.classList.add('hidden'), 5000);
        }

        function addMessage(sender, text, isUser = false) {
            const messageClass = isUser ? 'text-blue-600' : 'text-green-600';
            const messageContainer = document.createElement('div');
            messageContainer.className = `mb-3 ${isUser ? 'text-right' : 'text-left'}`;
            messageContainer.innerHTML = `
                <p class="font-semibold ${messageClass}"><strong>${sender}:</strong> ${text}</p>
                <p class="text-xs text-gray-400 mt-1">${new Date().toLocaleTimeString()}</p>
            `;
            chatbox.appendChild(messageContainer);
            chatbox.scrollTop = chatbox.scrollHeight;

            const placeholder = chatbox.querySelector('.text-center');
            if (placeholder) placeholder.remove();
        }

        voiceBtn.addEventListener('click', () => {
            if (isSpeaking) {
                synth.cancel();
                isSpeaking = false;
                return;
            }

            try {
                recognition.start();
                micIcon.textContent = '🎙️';
                recordingIndicator.classList.remove('hidden');
                voiceBtn.classList.add('ring-4', 'ring-red-200');
            } catch (error) {
                showError('Gagal mengakses mikrofon: ' + error.message);
            }
        });

        recognition.onstart = () => updateStatus(true);
        recognition.onend = () => {
            updateStatus(false);
            micIcon.textContent = '🎤';
            recordingIndicator.classList.add('hidden');
            voiceBtn.classList.remove('ring-4', 'ring-red-200');
        };

        recognition.onerror = event => {
            showError('Error: ' + event.error);
            updateStatus(false);
            micIcon.textContent = '🎤';
            recordingIndicator.classList.add('hidden');
            voiceBtn.classList.remove('ring-4', 'ring-red-200');
        };

        recognition.onresult = async event => {
            const userText = event.results[0][0].transcript;
            addMessage('Kamu', userText, true);
            loadingIndicator.classList.remove('hidden');

            try {
                const botResponse = await getAIResponse(userText);
                addMessage('Bot', botResponse);

                // TTS Natural Enhancement
                const utterance = new SpeechSynthesisUtterance(botResponse);
                utterance.lang = 'id-ID';
                utterance.rate = 0.95; // Lebih lambat agar terdengar manusiawi
                utterance.pitch = 1.1; // Lebih hangat
                utterance.volume = 1.0;

                utterance.onstart = () => {
                    isSpeaking = true;
                    micIcon.textContent = '🔊';
                };

                utterance.onend = () => {
                    isSpeaking = false;
                    micIcon.textContent = '🎤';
                };

                synth.speak(utterance);
            } catch (error) {
                showError('Gagal mendapatkan respon: ' + error.message);
                addMessage('Bot', 'Maaf, terjadi kesalahan saat memproses permintaan Anda.');
            } finally {
                loadingIndicator.classList.add('hidden');
            }
        };

        function getAIResponse(inputText) {
            const text = inputText.toLowerCase();
            if (text.includes("halo") || text.includes("hai")) {
                return "Hai juga... Ada yang bisa aku bantu?";
            } else if (text.includes("siapa kamu")) {
                return "Aku adalah chatbot... teman ngobrolmu!";
            } else if (text.includes("kabar") || text.includes("apa kabar")) {
                return "Aku baik... Makasih udah tanya! Kamu gimana?";
            } else if (text.includes("terima kasih")) {
                return "Sama-sama ya!";
            } else if (text.includes("makan")) {
                return "Aku nggak makan sih... Tapi kamu? Udah makan belum?";
            } else if (text.includes("cuaca") || text.includes("hujan") || text.includes("panas")) {
                return "Cuaca hari ini bisa beda-beda... Coba cek aplikasi cuaca ya.";
            } else if (text.includes("film") || text.includes("nonton")) {
                return "Aku suka film! Kamu suka genre apa? Drama... komedi... atau aksi?";
            } else if (text.includes("musik") || text.includes("lagu")) {
                return "Musik itu indah... Kamu lagi suka lagu apa akhir-akhir ini?";
            } else if (text.includes("hari apa") || text.includes("tanggal berapa")) {
                return `Hari ini adalah ${new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })}.`;
            } else if (text.includes("suka") || text.includes("senang")) {
                return "Aku suka ngobrol sama kamu... Serius!";
            } else if (text.includes("bantuan") || text.includes("help")) {
                return "Boleh banget! Tanya aja, aku siap bantu.";
            } else if (text.includes("cinta") || text.includes("sayang")) {
                return "Cinta itu... hmm... indah. Semoga kamu bahagia ya!";
            } else if (text.includes("keluar") || text.includes("selesai")) {
                return "Terima kasih udah ngobrol... Sampai jumpa lagi!";
            } else {
                return "Maaf ya... Aku belum ngerti itu. Coba tanyakan hal lain.";
            }
        }

        updateStatus(false);
    });
</script>