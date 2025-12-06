<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Upload Bukti Pembayaran - Gateway to PTN</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/ticket-dashboard-new.css') }}">
    <style>
        .cash-container {
            max-width: 800px;
            margin: 120px auto 50px;
            padding: 0 20px;
        }

        .cash-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .cash-title {
            font-size: 24px;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f2f6;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
        }

        .summary-item label {
            display: block;
            font-size: 12px;
            color: #636e72;
            margin-bottom: 5px;
        }

        .summary-item span {
            font-size: 15px;
            font-weight: 600;
            color: #2d3436;
        }

        .instruction-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .instruction-box h3 {
            font-size: 16px;
            color: #1565c0;
            margin-bottom: 10px;
        }

        .instruction-box ol {
            margin-left: 20px;
            color: #1976d2;
        }

        .instruction-box li {
            margin-bottom: 8px;
        }

        .upload-area {
            border: 2px dashed #cbd5e0;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
        }

        .upload-area:hover {
            border-color: #6c5ce7;
            background: #f8f9fa;
        }

        .upload-area.dragover {
            border-color: #6c5ce7;
            background: #eef2ff;
        }

        .upload-icon {
            font-size: 48px;
            color: #a0aec0;
            margin-bottom: 15px;
        }

        .upload-text {
            color: #4a5568;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .upload-hint {
            color: #a0aec0;
            font-size: 13px;
        }

        .preview-container {
            display: none;
            margin-top: 20px;
            position: relative;
            width: 100%;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .preview-image {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .remove-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #ff4757;
            color: white;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            margin-top: 30px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }

        .submit-btn:disabled {
            background: #b2bec3;
            cursor: not-allowed;
            transform: none;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            <img style ="width: 40px; height: 40px;" src="{{ asset('assets/images/GatewayToPTN.png') }}" alt="Logo">
            <span>Gateway To PTN</span>
        </a>

        <div class="profile-section">
            <div class="profile-trigger" id="profileTrigger">
                <div class="profile-avatar">
                    {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                </div>
                <span class="profile-name">{{ Auth::user()->nama_lengkap }}</span>
                <i class="fas fa-chevron-down" style="font-size: 0.8rem; margin-left: 5px;"></i>
            </div>

            <div class="dropdown-menu" id="dropdownMenu">
                <div class="dropdown-header">
                    <span>Signed in as</span>
                    <strong>{{ Auth::user()->email }}</strong>
                </div>
                
                <div class="dropdown-divider"></div>
                
                <a href="{{ route('home.user') }}" class="dropdown-item">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="{{ route('dashboard') }}" class="dropdown-item">
                    <i class="fas fa-ticket-alt"></i> Dashboard
                </a>
                
                <div class="dropdown-divider"></div>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item" style="color: #ff6b6b;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="cash-container">
        <div class="cash-card">
            <h2 class="cash-title"><i class="fas fa-upload" style="margin-right: 10px;"></i>Upload Bukti Pembayaran</h2>

            <div class="summary-grid">
                <div class="summary-item">
                    <label>Order ID</label>
                    <span>#{{ $orderData['order_id'] }}</span>
                </div>
                <div class="summary-item">
                    <label>Paket Tiket</label>
                    <span>{{ $orderData['bundle_name'] }}</span>
                </div>
                <div class="summary-item">
                    <label>Total Pembayaran</label>
                    <span style="color: #6c5ce7;">Rp {{ number_format($orderData['amount'], 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="instruction-box">
                <h3><i class="fas fa-info-circle"></i> Instruksi Pembayaran</h3>
                <ol>
                    <li>Silakan transfer sesuai nominal di atas ke rekening berikut:</li>
                    <li><strong>Bank BCA: 1234567890 a.n Gateway to PTN</strong></li>
                    <li>Pastikan nominal transfer sesuai hingga 3 digit terakhir.</li>
                    <li>Simpan bukti transfer (screenshot/foto struk).</li>
                    <li>Upload bukti transfer pada form di bawah ini.</li>
                </ol>
            </div>

            <form id="cashPaymentForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $orderData['order_id'] }}">
                <input type="hidden" name="bundle" value="{{ $orderData['bundle_type'] }}">
                <input type="hidden" name="email" value="{{ $orderData['email'] }}">
                <input type="hidden" name="phone" value="{{ $orderData['phone'] }}">
                <input type="hidden" name="amount" value="{{ $orderData['amount'] }}">

                <div class="upload-area" id="uploadArea">
                    <input type="file" name="payment_proof" id="paymentProof" accept="image/*" style="display: none;" required>
                    <div id="uploadPlaceholder">
                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                        <p class="upload-text">Klik atau tarik file ke sini untuk upload bukti pembayaran</p>
                        <p class="upload-hint">Format: JPG, PNG (Max. 5MB)</p>
                    </div>
                    
                    <div class="preview-container" id="previewContainer">
                        <button type="button" class="remove-btn" onclick="removeImage(event)">
                            <i class="fas fa-times"></i>
                        </button>
                        <img src="" alt="Preview" class="preview-image" id="previewImage">
                    </div>
                </div>

                <button type="submit" class="submit-btn" id="submitButton">
                    <i class="fas fa-paper-plane"></i> Kirim Bukti Pembayaran
                </button>
            </form>
        </div>
    </div>

    <script>
        // Dropdown functionality
        const profileTrigger = document.getElementById('profileTrigger');
        const dropdownMenu = document.getElementById('dropdownMenu');

        profileTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!dropdownMenu.contains(e.target) && !profileTrigger.contains(e.target)) {
                dropdownMenu.classList.remove('active');
            }
        });

        // File Upload Logic
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('paymentProof');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');

        uploadArea.addEventListener('click', () => fileInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) {
                fileInput.files = e.dataTransfer.files;
                handleFile(file);
            }
        });

        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            handleFile(file);
        });

        function handleFile(file) {
            if (!file) return;

            // Validate type
            if (!file.type.startsWith('image/')) {
                alert('Mohon upload file gambar (JPG/PNG).');
                return;
            }

            // Validate size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 5MB.');
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                previewImage.src = e.target.result;
                uploadPlaceholder.style.display = 'none';
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        window.removeImage = function(e) {
            e.stopPropagation();
            fileInput.value = '';
            previewContainer.style.display = 'none';
            uploadPlaceholder.style.display = 'block';
        }

        // Form Submission
        document.getElementById('cashPaymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = document.getElementById('submitButton');
            const originalText = submitButton.innerHTML;
            
            if (!fileInput.files[0]) {
                alert('Mohon upload bukti pembayaran terlebih dahulu.');
                return;
            }

            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
            
            const formData = new FormData(this);
            
            fetch('{{ route("ticket.cash.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("ticket.cash.pending") }}';
                } else {
                    alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
        });
    </script>
</body>
</html>