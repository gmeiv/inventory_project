<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Items to Borrow</title>
    <link rel="stylesheet" href="{{ asset('css/items.css') }}">
    <link rel="stylesheet" href="{{ asset('css/request-history.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .action-btn {
            background-color: #4da6ff;
            border: none;
            padding: 6px 10px;
            margin: 2px;
            border-radius: 4px;
            color: white;
            cursor: pointer;
        }
        .action-btn.preview { 
            background-color: #17a2b8; 
        }
        /* Preview Modal Styles */
        .preview-modal-content {
            max-width: 800px;
            width: 70vw;
            max-height: 90vh;
            overflow-y: auto;
            margin: auto;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .carousel-container {
            position: relative;
            width: 100%;
            height: 400px;
            margin: 20px 0;
            border-radius: 8px;
            overflow: hidden;
            background: #f5f5f5;
        }
        .carousel-slides {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .carousel-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .carousel-slide.active {
            opacity: 1;
        }
        .carousel-slide img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 8px;
            display: block;
            margin: auto;
        }
        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            padding: 15px 10px;
            cursor: pointer;
            font-size: 18px;
            border-radius: 5px;
            z-index: 10;
            transition: background 0.3s;
        }
        .carousel-btn:hover {
            background: rgba(0, 0, 0, 0.9);
        }
        .carousel-btn.prev {
            left: 10px;
        }
        .carousel-btn.next {
            right: 10px;
        }
        .carousel-dots {
            text-align: center;
            margin: 15px 0;
        }
        .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 4px;
            background: #ccc;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.3s;
        }
        .dot.active {
            background: #4da6ff;
        }
        .preview-info {
            margin-top: 20px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }
        .preview-info h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 24px;
        }
        .preview-info p {
            margin: 0;
            color: #666;
            line-height: 1.6;
            font-size: 16px;
        }
        .no-images {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #999;
            font-size: 18px;
        }
    </style>
</head>
<body>

<a href="{{ url('user.dashboard') }}" class="back-button">&larr; Back to Dashboard</a>

<div class="items-wrapper">
    <h1 class="title">Browse Items to Borrow</h1>

    <div class="header-tools" style="display: flex; gap: 8px; margin-bottom: 15px;">
        <input type="text" id="searchInput" placeholder="Search by Serial Number, Name, or Category..." onkeyup="filterTable()" style="padding: 8px; border-radius: 5px; border: none; width: 280px;">

        <div class="filter-dropdown">
            <button onclick="toggleFilterDropdown()" class="filter-btn">
                <i class="fas fa-filter"></i> Filter
            </button>
            <div id="filterOptions" class="dropdown-content">
                <a href="#" onclick="setSortField(1)">Serial Number</a>
                <a href="#" onclick="setSortField(2)">Name</a>
                <a href="#" onclick="setSortField(3)">Category</a>
                <a href="#" onclick="setSortField(4)">Stocks</a>
            </div>
        </div>

        <button class="arrow-btn" onclick="toggleSortDirection()">
            <span id="arrowIcon">Sort ↑</span>
        </button>
    </div>

    <table class="history-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Serial Number</th>
                <th>Name</th>
                <th>Category</th>
                <th>Current Stocks</th>
                <th>Total Stocks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr class="{{ $item->stocks <= 1 ? 'low-stock' : '' }}">
                    <td>
                        @if($item->serial_image)
                            <img src="{{ asset('storage/' . $item->serial_image) }}" alt="Serial Image" width="100" height="100" style="object-fit: cover;">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->serial_number }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->stocks }}</td>
                    <td>{{ $item->total_stocks }}</td>
                    <td>
                        @php 
                            $images = [];
                            for ($i = 1; $i <= 5; $i++) {
                                $imageField = "image$i";
                                if (!empty($item->$imageField)) {
                                    $images[] = $item->$imageField;
                                }
                            }
                        @endphp
                        <button class="action-btn preview" type="button"
                            data-name="{{ $item->name }}"
                            data-description="{{ $item->description }}"
                            data-images='@json($images)'
                            onclick="openPreviewModalFromButton(this)">
                            <i class="fas fa-eye"></i> Preview
                        </button>
                        @if($item->stocks > 0)
                            <button type="button" class="action-btn-borrow" onclick="showBorrowFormPopup('{{ $item->serial_number }}', '{{ $item->name }}', {{ $item->stocks }})">
                                <i class="fas fa-hand-paper"></i> Borrow
                            </button>
                        @else
                            <span class="out-of-stock">Out of Stock</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Confirm Borrow Popup -->
<div class="confirm-popup-overlay" id="confirmPopup">
    <div class="confirm-popup">
        <h3 id="popupTitle">Confirm Action</h3>
        <p id="popupMessage">Are you sure you want to proceed?</p>
        <div class="confirm-popup-buttons">
            <button class="confirm-popup-btn confirm" id="confirmBtn">Confirm</button>
            <button class="confirm-popup-btn cancel" onclick="hideConfirmPopup()">Cancel</button>
        </div>
    </div>
</div>

<!-- Borrow Form Modal -->
<div class="confirm-popup-overlay" id="borrowFormPopup">
    <div class="confirm-popup">
        <h3 id="borrowFormTitle">Borrow Item</h3>
        <form id="borrowForm" method="POST">
            @csrf
            <input type="hidden" name="serial_number" id="borrow_serial_number">
            <div style="margin-bottom: 10px;">
                <label for="borrow_quantity">Quantity:</label>
                <input type="number" name="quantity" id="borrow_quantity" min="1" required>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="borrow_until">Borrow Until:</label>
                <input type="date" name="borrow_until" id="borrow_until" required>
            </div>
            <div class="confirm-popup-buttons">
                <button type="submit" class="confirm-popup-btn confirm">Confirm</button>
                <button type="button" class="confirm-popup-btn cancel" onclick="hideBorrowFormPopup()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="modal" style="display:none;">
    <div class="modal-content preview-modal-content">
        <span class="close" onclick="closePreviewModal()">&times;</span>
        <h2 id="previewModalTitle"> </h2>
        <div class="carousel-container">
            <button class="carousel-btn prev" onclick="changeSlide(-1)">&#10094;</button>
            <div class="carousel-slides" id="carouselSlides"></div>
            <button class="carousel-btn next" onclick="changeSlide(1)">&#10095;</button>
        </div>
        <div class="carousel-dots" id="carouselDots"></div>
        <div class="preview-info">
            <h3 id="previewItemName"></h3>
            <p id="previewItemDescription"></p>
        </div>
    </div>
</div>

<!-- Hidden Form -->
<form id="actionForm" method="POST" style="display: none;">
    @csrf
</form>

<!-- Notification -->
<div class="notification-container" id="notificationContainer"></div>

<script>
    // Preview Modal Carousel Logic
    let previewImages = [];
    let currentSlide = 0;

    function openPreviewModal(name, description, images) {
        previewImages = images && images.length ? images : [];
        currentSlide = 0;
        document.getElementById('previewItemName').textContent = name;
        document.getElementById('previewItemDescription').textContent = description;
        renderCarousel();
        document.getElementById('previewModal').style.display = 'block';
    }

    function closePreviewModal() {
        document.getElementById('previewModal').style.display = 'none';
    }

    function renderCarousel() {
        const slidesContainer = document.getElementById('carouselSlides');
        const dotsContainer = document.getElementById('carouselDots');
        slidesContainer.innerHTML = '';
        dotsContainer.innerHTML = '';
        
        if (!previewImages.length) {
            slidesContainer.innerHTML = '<div class="no-images">No images available</div>';
            return;
        }
        
        previewImages.forEach((img, idx) => {
            const slide = document.createElement('div');
            slide.className = 'carousel-slide' + (idx === currentSlide ? ' active' : '');
            const image = document.createElement('img');
            const imageUrl = img.startsWith('http') ? img : '{{ asset("storage") }}/' + img;
            console.log('Constructed image URL:', imageUrl);
            image.src = imageUrl;
            image.alt = 'Item Image ' + (idx + 1);
            image.onload = function() {
                console.log('Image loaded successfully:', imageUrl);
            };
            image.onerror = function() {
                console.log('Failed to load image:', imageUrl);
                this.style.display = 'none';
            };
            slide.appendChild(image);
            slidesContainer.appendChild(slide);
            
            // Dots
            const dot = document.createElement('span');
            dot.className = 'dot' + (idx === currentSlide ? ' active' : '');
            dot.onclick = () => goToSlide(idx);
            dotsContainer.appendChild(dot);
        });
    }

    function changeSlide(delta) {
        if (!previewImages.length) return;
        currentSlide = (currentSlide + delta + previewImages.length) % previewImages.length;
        renderCarousel();
    }

    function goToSlide(idx) {
        currentSlide = idx;
        renderCarousel();
    }

    function openPreviewModalFromButton(btn) {
        const images = JSON.parse(btn.getAttribute('data-images') || '[]');
        console.log('Images array:', images);
        console.log('Image paths:', images);
        openPreviewModal(
            btn.getAttribute('data-name'),
            btn.getAttribute('data-description'),
            images
        );
    }

    // Close preview modal when clicking outside
    window.addEventListener('click', function(event) {
        const previewModal = document.getElementById('previewModal');
        if (event.target === previewModal) {
            closePreviewModal();
        }
    });

    let currentSortCol = 1;
    let currentSortDir = 'asc';
    let currentItemStocks = 0;

    function toggleFilterDropdown() {
        const dropdown = document.getElementById('filterOptions');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    function setSortField(colIndex) {
        currentSortCol = colIndex;
        sortTable(currentSortCol, currentSortDir);
        document.getElementById('filterOptions').style.display = 'none';
    }

    function toggleSortDirection() {
        currentSortDir = currentSortDir === 'asc' ? 'desc' : 'asc';
        document.getElementById('arrowIcon').textContent = currentSortDir === 'asc' ? 'Sort ↑' : 'Sort ↓';
        sortTable(currentSortCol, currentSortDir);
    }

    function sortTable(colIndex, direction = 'asc') {
        const table = document.querySelector('.history-table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        rows.sort((a, b) => {
            const aText = a.cells[colIndex]?.textContent.trim().toUpperCase() || '';
            const bText = b.cells[colIndex]?.textContent.trim().toUpperCase() || '';
            const aNum = parseFloat(aText);
            const bNum = parseFloat(bText);

            if (!isNaN(aNum) && !isNaN(bNum)) {
                return direction === 'asc' ? aNum - bNum : bNum - aNum;
            }

            return direction === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
        });

        rows.forEach(row => tbody.appendChild(row));
    }

    function filterTable() {
        const input = document.getElementById('searchInput').value.toUpperCase();
        const rows = document.querySelectorAll('.history-table tbody tr');
        rows.forEach(row => {
            const serial_number = row.cells[1].textContent.toUpperCase();
            const name = row.cells[2].textContent.toUpperCase();
            const category = row.cells[3].textContent.toUpperCase();
            row.style.display = (serial_number.includes(input) || name.includes(input) || category.includes(input)) ? '' : 'none';
        });
    }

    function showConfirmPopup(action, serialNumber, itemName) {
        const popup = document.getElementById('confirmPopup');
        const title = document.getElementById('popupTitle');
        const message = document.getElementById('popupMessage');
        const confirmBtn = document.getElementById('confirmBtn');
        const form = document.getElementById('actionForm');

        const baseRoute = "{{ url('/borrow-request') }}";

        if (action === 'borrow') {
            title.textContent = 'Confirm Borrow';
            message.textContent = `Are you sure you want to borrow ${itemName} (${serialNumber})?`;
            form.action = `${baseRoute}/${serialNumber}`;
        }

        confirmBtn.onclick = function () {
            form.submit();
        };

        popup.style.display = 'flex';
    }

    function hideConfirmPopup() {
        document.getElementById('confirmPopup').style.display = 'none';
    }

    document.getElementById('confirmPopup').addEventListener('click', function (e) {
        if (e.target === this) {
            hideConfirmPopup();
        }
    });

    function showBorrowFormPopup(serialNumber, itemName, stocks) {
        document.getElementById('borrowFormTitle').textContent = `Borrow ${itemName} (${serialNumber})`;
        document.getElementById('borrowForm').action = `{{ url('/borrow-request') }}/${serialNumber}`;
        document.getElementById('borrow_serial_number').value = serialNumber;
        document.getElementById('borrow_quantity').max = stocks;
        document.getElementById('borrow_quantity').value = 1;
        document.getElementById('borrow_until').value = '';
        currentItemStocks = stocks;
        document.getElementById('borrowFormPopup').style.display = 'flex';
    }
    function hideBorrowFormPopup() {
        document.getElementById('borrowFormPopup').style.display = 'none';
    }

    function showNotification(message, type = 'success') {
        const container = document.getElementById('notificationContainer');
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;

        const icon = type === 'success' ? 'fas fa-check-circle' :
                     type === 'error' ? 'fas fa-exclamation-circle' :
                     'fas fa-info-circle';

        notification.innerHTML =
            `<div class="notification-content">
                <i class="${icon} notification-icon"></i>
                <span class="notification-message">${message}</span>
            </div>
            <button class="notification-close" onclick="removeNotification(this)">&times;</button>`;

        container.appendChild(notification);

        setTimeout(() => {
            removeNotification(notification.querySelector('.notification-close'));
        }, 5000);
    }

    function removeNotification(button) {
        const notification = button.closest('.notification');
        notification.classList.add('removing');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }

    @if (session('success'))
        showNotification("{{ session('success') }}", 'success');
    @endif

    @if (session('error'))
        showNotification("{{ session('error') }}", 'error');
    @endif
    @if (
$errors->any())
        @foreach ($errors->all() as $error)
            showNotification("{{ $error }}", 'error');
        @endforeach
    @endif
</script>

</body>
</html>
