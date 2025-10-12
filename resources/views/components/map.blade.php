<div class="flex items-center justify-center font-sans">
  <div id="map" class="relative">
    <!-- Controls -->
    <div class="absolute top-4 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2">
      <div class="flex gap-2 h-10">
        <!-- Ô tìm kiếm -->
        <div class="flex bg-white rounded-lg shadow-md w-[400px]">
          <input
            type="text"
            id="search-input"
            placeholder="Nhập địa điểm (VD: Hà Nội...)"
            autocomplete="off"
            class="flex-1 px-3 rounded-l-lg text-sm focus:outline-none"
          />
          <button
            id="search-btn"
            type="button"
            class="bg-blue-500 text-white px-4 rounded-r-lg hover:bg-blue-600 transition"
          >
            Tìm
          </button>
        </div>

        <!-- Nút định vị -->
        <button
          id="locate-btn"
          type="button"
          class="bg-green-600 hover:bg-green-700 text-white px-3 rounded-lg shadow-md text-sm flex items-center justify-center"
        >
          📍 Dùng vị trí hiện tại
        </button>
      </div>

      <!-- Gợi ý -->
      <div class="w-full flex justify-start">
        <div
          id="suggestions"
          class="suggestions bg-white rounded-b-lg shadow-lg w-[400px] hidden max-h-[200px] overflow-y-auto text-sm"
        ></div>
      </div>
    </div>
  </div>

  <script>
    const MAPTILER_KEY = "{{ env('MAPTILER_KEY') }}";

    // ==============================
    // Khởi tạo bản đồ
    // ==============================
    const map = new maplibregl.Map({
      container: 'map',
      style: `https://api.maptiler.com/maps/streets/style.json?key=${MAPTILER_KEY}`,
      center: [105.8342, 21.0278], // Việt Nam
      zoom: 6
    });

    let marker, userMarker;
    const input = document.getElementById('search-input');
    const suggestionsDiv = document.getElementById('suggestions');
    const locateBtn = document.getElementById('locate-btn');
    let timeout = null;

    // ==============================
    // Gợi ý tìm kiếm
    // ==============================
    input.addEventListener('input', async () => {
      const query = input.value.trim();
      if (query.length < 2) {
        suggestionsDiv.style.display = 'none';
        return;
      }

      clearTimeout(timeout);
      timeout = setTimeout(async () => {
        const url = `https://api.maptiler.com/geocoding/${encodeURIComponent(
          query
        )}.json?key=${MAPTILER_KEY}&language=vi&country=VN&limit=6`;

        const response = await fetch(url);
        const data = await response.json();

        if (!data.features || data.features.length === 0) {
          suggestionsDiv.style.display = 'none';
          return;
        }

        suggestionsDiv.innerHTML = '';
        data.features.forEach(feature => {
          const place = buildFullAddress(feature);
          const div = document.createElement('div');
          div.textContent = place;
          div.className =
            'px-3 py-2 border-b border-gray-100 cursor-pointer hover:bg-blue-50';
          div.addEventListener('click', () => {
            showLocation(feature, place);
            input.value = place;
            suggestionsDiv.style.display = 'none';
          });
          suggestionsDiv.appendChild(div);
        });
        suggestionsDiv.style.display = 'block';
      }, 400);
    });

    // ==============================
    // Nút tìm kiếm
    // ==============================
    document.getElementById('search-btn').addEventListener('click', async () => {
      const query = input.value.trim();
      if (!query) return alert('Vui lòng nhập địa điểm');

      const url = `https://api.maptiler.com/geocoding/${encodeURIComponent(
        query
      )}.json?key=${MAPTILER_KEY}&language=vi&country=VN`;

      const response = await fetch(url);
      const data = await response.json();

      if (!data.features || data.features.length === 0) {
        alert('Không tìm thấy địa điểm!');
        return;
      }

      const feature = data.features[0];
      const fullAddress = buildFullAddress(feature);
      showLocation(feature, fullAddress);
    });

    // ==============================
    // Nút định vị GPS
    // ==============================
    locateBtn.addEventListener('click', () => {
      if (!navigator.geolocation) {
        alert('Trình duyệt không hỗ trợ định vị GPS.');
        return;
      }

      locateBtn.textContent = '🔍 Đang định vị...';
      locateBtn.disabled = true;

      navigator.geolocation.getCurrentPosition(
        async pos => {
          const { latitude, longitude } = pos.coords;

          // Reverse geocoding
          const reverseUrl = `https://api.maptiler.com/geocoding/${longitude},${latitude}.json?key=${MAPTILER_KEY}&language=vi`;
          const response = await fetch(reverseUrl);
          const data = await response.json();

          let fullAddress = 'Không xác định được địa chỉ';
          let feature = null;
          if (data.features && data.features.length > 0) {
            feature = data.features[0];
            fullAddress = buildFullAddress(feature);
            input.value = fullAddress;
          }

          map.flyTo({ center: [longitude, latitude], zoom: 15 });

          if (userMarker) userMarker.remove();
          userMarker = new maplibregl.Marker({ color: '#2563eb' })
            .setLngLat([longitude, latitude])
            .setPopup(new maplibregl.Popup().setText(fullAddress))
            .addTo(map);

          // Bắn event để form nhận địa chỉ
          if (feature) {
            const payload = buildFullData(feature, fullAddress, latitude, longitude);
            window.dispatchEvent(new CustomEvent('map:location-selected', { detail: payload }));
            window.lastMapLocation = payload;
            console.log('📍 map:location-selected từ GPS', payload);
          }

          locateBtn.textContent = '📍 Dùng vị trí hiện tại';
          locateBtn.disabled = false;
        },
        err => {
          alert('Không thể lấy vị trí của bạn. Hãy kiểm tra quyền GPS.');
          console.error(err);
          locateBtn.textContent = '📍 Dùng vị trí hiện tại';
          locateBtn.disabled = false;
        }
      );
    });

    // ==============================
    // Hiển thị marker khi chọn địa điểm
    // ==============================
    function showLocation(feature, text) {
      const [lng, lat] = feature.geometry.coordinates;
      map.flyTo({ center: [lng, lat], zoom: 14 });

      if (marker) marker.remove();
      marker = new maplibregl.Marker({ color: 'red' })
        .setLngLat([lng, lat])
        .setPopup(new maplibregl.Popup().setText(text))
        .addTo(map);

      const payload = buildFullData(feature, text, lat, lng);
      window.dispatchEvent(new CustomEvent('map:location-selected', { detail: payload }));
      window.lastMapLocation = payload;
      console.log('🚀 map:location-selected', payload);
    }

    // ==============================
    // Xây địa chỉ đầy đủ
    // ==============================
    function buildFullAddress(feature) {
      const name = feature.text || '';
      const address = feature.properties?.address || '';
      const context = feature.context || [];
      const ward =
        context.find(c => c.id.includes('locality') || c.id.includes('neighbourhood'))?.text || '';
      const district = context.find(c => c.id.includes('district'))?.text || '';
      const province = context.find(c => c.id.includes('region'))?.text || '';
      const country = context.find(c => c.id.includes('country'))?.text || '';

      const parts = [address, name, ward, district, province, country].filter(Boolean);
      return parts.join(', ');
    }

    // ==============================
    // Tạo dữ liệu chi tiết gửi về form
    // ==============================
    function buildFullData(feature, fullAddress, lat, lng) {
      const props = feature.properties || {};
      const context = feature.context || [];

      const getContext = type => {
        return context.find(c => c.id.includes(type))?.text || '';
      };

      return {
        address_line: props.address || feature.text || '',
        district: getContext('district'),
        city: getContext('locality') || getContext('place'),
        province: getContext('region'),
        country: getContext('country'),
        postal_code: props.postcode || getContext('postcode') || '',
        google_place_id: feature.id || '',
        formatted_address: fullAddress,
        latitude: lat,
        longitude: lng
      };
    }
  </script>
</div>
