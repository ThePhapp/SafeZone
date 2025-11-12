<x-app-layout>

    <!-- 🌪️ Bản đồ gió (Windy Map) -->
    <section class="relative mt-2">
        <iframe
            class="w-full h-[70vh] rounded-2xl overflow-hidden shadow-[0_0_25px_rgba(56,189,248,0.25)]"
            src="https://embed.windy.com/embed2.html?lat=15.5&lon=108.0&zoom=5&level=surface&overlay=wind&menu=&message=true&marker=&calendar=&pressure=true&type=map&location=coordinates"
            frameborder="0"
        ></iframe>
    </section>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 dark:bg-gray-900/70 backdrop-blur-xl border border-white/10 overflow-hidden shadow-lg sm:rounded-3xl p-8 space-y-8 text-slate-200">

                <!-- 🛡️ Trạng thái an toàn -->
                <div class="bg-gradient-to-br from-sky-800/30 to-sky-600/10 border border-sky-500/30 rounded-2xl p-6 shadow-lg hover:shadow-sky-400/20 transition-all duration-300">
                    <div class="flex flex-wrap justify-between items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-sky-500/20 rounded-xl border border-sky-400/30">
                                <svg class="w-9 h-9 text-sky-400 drop-shadow-[0_0_10px_#38bdf8]" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-semibold text-sky-400">Bạn đang an toàn ✅</h2>
                                <p class="text-slate-300 mt-1">Không có cảnh báo khẩn cấp trong bán kính 10km.</p>
                                <p class="text-xs text-slate-500 mt-1">Cập nhật: 2 phút trước</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <a href="/alerts"
                               class="px-5 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20 text-slate-100 backdrop-blur-sm transition-all duration-300">
                               Xem cảnh báo
                            </a>
                            <button
                               class="px-5 py-2 rounded-lg bg-sky-500 hover:bg-sky-400 text-white shadow-[0_0_15px_rgba(56,189,248,0.5)] transition-all duration-300">
                               🚨 Gửi SOS
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ⚡ Hành động nhanh -->
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-2xl shadow-lg">
                    <h4 class="text-sm font-semibold mb-4 text-slate-300 uppercase tracking-wider">Hành động nhanh</h4>
                    <div class="flex flex-wrap gap-3">
                        <button class="flex items-center gap-2 px-4 py-3 rounded-xl bg-sky-500/30 hover:bg-sky-500/40 border border-sky-400/20 text-white font-medium shadow-[0_0_15px_rgba(56,189,248,0.25)] transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3v18" />
                            </svg>
                            Báo cáo nhanh
                        </button>
                        <button class="flex items-center gap-2 px-4 py-3 rounded-xl bg-emerald-500/30 hover:bg-emerald-500/40 border border-emerald-400/20 text-white font-medium shadow-[0_0_15px_rgba(16,185,129,0.25)] transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20h9" />
                            </svg>
                            Hỗ trợ khẩn cấp
                        </button>
                        <button class="flex items-center gap-2 px-4 py-3 rounded-xl bg-indigo-500/30 hover:bg-indigo-500/40 border border-indigo-400/20 text-white font-medium shadow-[0_0_15px_rgba(99,102,241,0.25)] transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m7-7v14" />
                            </svg>
                            Gửi vị trí
                        </button>
                    </div>
                </div>

                <!-- 🌤️ Cảnh báo khu vực hiện tại -->
                <div id="localAlert" class="bg-red-500/10 border border-red-500/30 text-red-200 p-5 rounded-2xl shadow-lg hidden">
                    <h3 class="text-lg font-semibold mb-2">⚠️ Cảnh báo tại khu vực của bạn</h3>
                    <p class="text-sm" id="localAlertMessage">Đang tải thông tin...</p>
                </div>

                <!-- 🧭 Mức độ rủi ro hôm nay -->
                <div class="bg-white/10 border border-white/20 p-6 rounded-2xl backdrop-blur-xl">
                    <h3 class="text-sm font-semibold text-slate-300 uppercase mb-3">Mức độ rủi ro hôm nay</h3>
                    <div class="w-full bg-gray-700 rounded-full h-3 mb-2">
                        <div class="bg-yellow-400 h-3 rounded-full animate-pulse" style="width: 60%;"></div>
                    </div>
                    <p class="text-sm text-slate-400">Rủi ro trung bình - đề nghị theo dõi cảnh báo.</p>
                </div>

                <!-- 🆘 Trung tâm cứu hộ -->
                <div class="bg-white/10 border border-white/20 p-6 rounded-2xl backdrop-blur-xl">
                    <h3 class="text-sm font-semibold text-slate-300 uppercase mb-3">Trung tâm cứu hộ gần đây</h3>
                    <ul class="divide-y divide-white/10 text-sm">
                        <li class="py-2 flex justify-between">
                            <span>🚑 Đội phản ứng nhanh - Đà Nẵng</span>
                            <span class="text-green-400">Hoạt động</span>
                        </li>
                        <li class="py-2 flex justify-between">
                            <span>🚒 Cứu hộ miền Trung</span>
                            <span class="text-yellow-400">Đang di chuyển</span>
                        </li>
                        <li class="py-2 flex justify-between">
                            <span>🚓 Hỗ trợ giao thông</span>
                            <span class="text-red-400">Tạm ngưng</span>
                        </li>
                    </ul>
                </div>

                <!-- 📰 Tin tức khẩn cấp -->
                <div class="bg-white/10 border border-white/20 p-6 rounded-2xl backdrop-blur-xl">
                    <h3 class="text-sm font-semibold text-slate-300 uppercase mb-3">Tin tức khẩn cấp</h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li>🌊 <a href="#" class="hover:text-sky-400 transition">Cảnh báo mưa lớn kéo dài ở miền Trung (04/11)</a></li>
                        <li>💨 <a href="#" class="hover:text-sky-400 transition">Bão số 6 có khả năng mạnh lên cấp 11 - 12</a></li>
                        <li>🚧 <a href="#" class="hover:text-sky-400 transition">Một số tuyến đường ở Quảng Nam tạm ngưng lưu thông</a></li>
                    </ul>
                </div>

                <!-- 🗺️ Bản đồ chọn quốc gia -->
<div class="bg-white/10 border border-white/20 rounded-2xl p-6 backdrop-blur-xl mb-6">
  <h3 class="text-slate-300 text-sm uppercase font-semibold mb-3">🗺️ Chọn quốc gia để xem thống kê thiên tai</h3>
  <div id="map" class="rounded-xl overflow-hidden border border-white/10" style="height: 400px;"></div>
  <p id="selectedCountry" class="text-sm text-slate-400 mt-3 italic">Nhấn vào bản đồ để chọn quốc gia...</p>
</div>

<!-- 📊 Kết quả thống kê -->
<div class="bg-white/10 border border-white/20 rounded-2xl p-6 backdrop-blur-xl">
  <h3 id="countryTitle" class="text-slate-300 text-sm uppercase font-semibold mb-3">Thống kê thiên tai gần đây</h3>
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
    <div class="p-4 bg-sky-500/20 rounded-xl border border-sky-500/20">
      <p id="stormCount" class="text-3xl font-bold text-sky-400">--</p>
      <p class="text-xs text-slate-400">Bão / Áp thấp</p>
    </div>
    <div class="p-4 bg-amber-500/20 rounded-xl border border-amber-500/20">
      <p id="earthquakeCount" class="text-3xl font-bold text-amber-400">--</p>
      <p class="text-xs text-slate-400">Động đất / Sóng thần</p>
    </div>
    <div class="p-4 bg-emerald-500/20 rounded-xl border border-emerald-500/20">
      <p id="floodCount" class="text-3xl font-bold text-emerald-400">--</p>
      <p class="text-xs text-slate-400">Lũ / Ngập</p>
    </div>
    <div class="p-4 bg-rose-500/20 rounded-xl border border-rose-500/20">
      <p id="diseaseCount" class="text-3xl font-bold text-rose-400">--</p>
      <p class="text-xs text-slate-400">Dịch bệnh / Khác</p>
    </div>
  </div>
  <p id="updateTime" class="text-[11px] text-slate-500 mt-4 text-right italic">Chưa có dữ liệu.</p>
            </div>
        </div>
    </div>

<link
  rel="stylesheet"
  href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Scripts -->
    <script>
        // 🌦️ Cảnh báo khu vực hiện tại
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                const lat = pos.coords.latitude;
                const lon = pos.coords.longitude;
                fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=YOUR_API_KEY&lang=vi`)
                    .then(res => res.json())
                    .then(data => {
                        const alertBox = document.getElementById('localAlert');
                        const msg = document.getElementById('localAlertMessage');
                        if (data.weather && data.weather[0]) {
                            msg.innerText = `Khu vực: ${data.name} – ${data.weather[0].description}`;
                            alertBox.classList.remove('hidden');
                        }
                    });
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
  // 1️⃣ Tạo bản đồ
  const map = L.map("map").setView([20, 105], 3);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution: "&copy; OpenStreetMap contributors"
  }).addTo(map);

  let marker = null;

  // 2️⃣ Khi người dùng click lên bản đồ
  map.on("click", async (e) => {
    const { lat, lng } = e.latlng;

    // Nếu đã có marker thì xóa trước
    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lng]).addTo(map);

    document.getElementById("selectedCountry").textContent = "🔍 Đang xác định quốc gia...";

    try {
      // 3️⃣ Lấy quốc gia từ toạ độ (Reverse Geocoding)
      const geoRes = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
      const geoData = await geoRes.json();
      const country = geoData.address.country;

      document.getElementById("selectedCountry").textContent = `🌍 Quốc gia: ${country}`;
      document.getElementById("countryTitle").textContent = `Thống kê thiên tai gần đây tại ${country}`;

      // 4️⃣ Gọi API ReliefWeb với headers phù hợp
      try {
        const rwRes = await fetch(`https://api.reliefweb.int/v1/disasters?appname=safezone&limit=100`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify({
            limit: 100,
            filter: {
              field: 'country.name',
              value: country
            }
          })
        });

        if (!rwRes.ok) {
          console.warn('ReliefWeb API error:', rwRes.status);
          throw new Error('API not available');
        }

        const rwData = await rwRes.json();

        // 5️⃣ Đếm loại thiên tai
        const counts = { storm: 0, earthquake: 0, flood: 0, disease: 0 };
        
        if (rwData.data && Array.isArray(rwData.data)) {
          rwData.data.forEach(d => {
            const name = (d.fields?.name || '').toLowerCase();
            if (name.includes("typhoon") || name.includes("storm") || name.includes("cyclone")) counts.storm++;
            else if (name.includes("earthquake") || name.includes("tsunami")) counts.earthquake++;
            else if (name.includes("flood") || name.includes("mudslide") || name.includes("landslide")) counts.flood++;
            else counts.disease++;
          });
        }

        // 6️⃣ Cập nhật giao diện
        document.getElementById("stormCount").textContent = counts.storm;
        document.getElementById("earthquakeCount").textContent = counts.earthquake;
        document.getElementById("floodCount").textContent = counts.flood;
        document.getElementById("diseaseCount").textContent = counts.disease;
        document.getElementById("updateTime").textContent = `Cập nhật: ${new Date().toLocaleTimeString()} (ReliefWeb API)`;

      } catch (apiErr) {
        console.warn('ReliefWeb API unavailable, using fallback data:', apiErr);
        
        // 🔄 Phương án dự phòng: Sử dụng dữ liệu mẫu
        const fallbackCounts = generateFallbackData(country);
        
        document.getElementById("stormCount").textContent = fallbackCounts.storm;
        document.getElementById("earthquakeCount").textContent = fallbackCounts.earthquake;
        document.getElementById("floodCount").textContent = fallbackCounts.flood;
        document.getElementById("diseaseCount").textContent = fallbackCounts.disease;
        document.getElementById("updateTime").textContent = `⚠️ Dữ liệu ước tính (API tạm thời không khả dụng)`;
      }

    } catch (err) {
      console.error('General error:', err);
      document.getElementById("selectedCountry").textContent = "⚠️ Không thể xác định hoặc lấy dữ liệu quốc gia.";
    }
  });
});

// 🔄 Hàm tạo dữ liệu dự phòng dựa trên quốc gia
function generateFallbackData(country) {
  // Dữ liệu ước tính dựa trên đặc điểm địa lý của từng khu vực
  const countryProfiles = {
    'Vietnam': { storm: 8, earthquake: 2, flood: 12, disease: 3 },
    'Việt Nam': { storm: 8, earthquake: 2, flood: 12, disease: 3 },
    'Japan': { storm: 6, earthquake: 15, flood: 5, disease: 1 },
    '日本': { storm: 6, earthquake: 15, flood: 5, disease: 1 },
    'Philippines': { storm: 12, earthquake: 8, flood: 10, disease: 4 },
    'Indonesia': { storm: 7, earthquake: 20, flood: 9, disease: 5 },
    'Thailand': { storm: 5, earthquake: 1, flood: 8, disease: 3 },
    'China': { storm: 9, earthquake: 12, flood: 15, disease: 6 },
    '中国': { storm: 9, earthquake: 12, flood: 15, disease: 6 },
    'India': { storm: 10, earthquake: 8, flood: 18, disease: 7 },
    'United States': { storm: 11, earthquake: 5, flood: 7, disease: 2 },
    'United States of America': { storm: 11, earthquake: 5, flood: 7, disease: 2 },
    'Australia': { storm: 4, earthquake: 1, flood: 6, disease: 2 },
    'New Zealand': { storm: 3, earthquake: 10, flood: 4, disease: 1 }
  };

  // Trả về dữ liệu cho quốc gia hoặc giá trị mặc định
  return countryProfiles[country] || { storm: 5, earthquake: 5, flood: 5, disease: 2 };
}


    </script>

</x-app-layout>
