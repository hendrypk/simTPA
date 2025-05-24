@extends('admin._layout.main')
@section('title', __('Transaksi - TPA Attaqwa'))
@section('heading', __('Transaksi'))
@section('content')

                    <!-- Content Row -->
                    <div class="row mb-5">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary  h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Pemasukan</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $trxs['total_debet'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success  h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Pengeluaran</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $trxs['total_credit'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info  h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Donasi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $trxs['total_donate'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Sisa Saldo</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $trxs['remaining'] }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row">
                        <form method="GET" class="mb-4 w-100" id="filterForm">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-2">
                                    <label>Dompet</label>
                                    <select name="wallet_id" class="form-control" onchange="document.getElementById('filterForm').submit();">
                                        <option value="">- Semua Dompet -</option>
                                        @foreach($wallet as $w)
                                            <option value="{{ $w->id }}" {{ request('wallet_id') == $w->id ? 'selected' : '' }}>
                                                {{ $w->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                        
                                <div class="col-md-2">
                                    <label>Jenis Transaksi</label>
                                    <select name="type" class="form-control" onchange="document.getElementById('filterForm').submit();">
                                        <option value="">- Semua -</option>
                                        <option value="debet" {{ request('type') == 'debet' ? 'selected' : '' }}>Debet (Masuk)</option>
                                        <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credit (Keluar)</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-2">
                                    <label>Rentang Tanggal</label>
                                    <x-date-range-filter onchange="document.getElementById('filterForm').submit();"/>
                                </div>
                            </div>
                        </form>
                    </div> --}}
    <div class="card mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-end">
                <!-- Tombol trigger modal -->
                <button id="formModalBtn" data-action="{{ route('trx.submit') }}" class="btn btn-sm btn-primary formModalBtn">
                    Tambah Transaksi
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>TXID</th>
                            <th>Tanggal</th>
                            <th>Debet/Kredit</th>
                            <th>Dompet</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Penerima/Pengirim</th>
                            <th>Deskripsi</th>
                            <th>Lampiran</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    @foreach($trx as $no=>$data)
                        <tbody>
                            <td>{{ $no+1 }}</td>
                            <td>{{ $data->transaction_id }}</td>
                            <td>{{ $data->transaction_at->format('d M Y') }}</td>
                            <td>{{ $data->type }}</td>
                            <td>{{ $data->wallet->name }}</td>
                            <td>{{ $data->payable->name }}</td>
                            <td>{{ $data->amount }}</td>
                            <td>{{ $data->contact_name->name }}</td>
                            <td>{{ $data->meta }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" 
                                onclick="showAttachmentModal('{{ $data->getFirstMediaUrl('transactions') }}')">
                                <i class="ri-eye-fill"></i>
                            </button>
                                {{-- <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal" data-target="#attachmentModal" onclick="showAttachmentModal('{{ $data->getFirstMediaUrl('transactions') }}')">
                                    Lihat Bukti Transaksi
                                </a> --}}
                            </td>
                            <td>
                                <button type="button" id="formModalBtn" class="btn btn-sm btn-primary formModalBtn btn-edit"
                                    data-id="{{ $data->id }}"
                                    data-date="{{ $data->transaction_at }}"
                                    data-meta="{{ $data->meta }}"
                                    data-amount="{{ $data->amount }}"
                                    data-trx_category="{{ $data->payable_id }}"
                                    data-type="{{ $data->type }}"
                                    data-wallet="{{ $data->wallet_id }}"
                                    data-recipient_category="{{ $data->related_model }}"
                                    data-employee="{{ $data->related_id }}"
                                    data-student="{{ $data->related_id }}"
                                    data-donor="{{ $data->related_id }}"
                                    data-action="{{ route('trx.submit', $data->id) }}">
                                    <i class="ri-pencil-fill"></i>
                                </button>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="confirmDelete({{ $data->id }}, '{{ $data->transaction_at }}', 'transactions')">
                                    <i class="ri-delete-bin-fill"></i>
                                </button>
                            </td>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

    <script>    

function showAttachmentModal(mediaUrl) {
    var attachmentContent = document.getElementById('attachmentContent');
    
    // Check if the file is an image or PDF and load accordingly
    if (mediaUrl.match(/\.(jpeg|jpg|png)$/)) {
        attachmentContent.innerHTML = `<img src="${mediaUrl}" class="img-responsive" alt="Bukti Transaksi">`;
    } else if (mediaUrl.match(/\.pdf$/)) {
        attachmentContent.innerHTML = `<iframe src="${mediaUrl}" width="100%" height="500px"></iframe>`;
    } else {
        attachmentContent.innerHTML = `<p>Unsupported file type.</p>`;
    }

    // Show the modal after content is injected
    $('#attachmentModal').modal('show');
    $('#attachmentModal').modal('hide');

}

    
        document.addEventListener('input', function (e) {
            if (e.target.name === 'amount') {
                e.target.value = e.target.value.replace(/[^0-9.]/g, '');
            }
        });


    document.querySelectorAll('.formModalBtn').forEach(button => {
        button.addEventListener('click', function () {
            const walletOptions = @json($wallet);
            const inTrxOptions = @json($inTrx);
            const outTrxOptions = @json($outTrx);
            const employeeOptions = @json($employee);
            const donorOptions = @json($donor);
            const studentOptions = @json($student);

            const fields = [
                { name: 'id', type: 'hidden' },
                { label: 'Tipe Transaksi', name: 'type', type: 'select', options: [
                    { id: 'credit', name: 'Pengeluaran' },
                    { id: 'debet', name: 'Pemasukan' },
                ]},
                { label: 'Tanggal', name: 'date', type: 'date' },
                { label: 'Dompet', name: 'wallet', type: 'select', options: walletOptions },
                { name: 'trx_category', type: 'dynamic_trx_category' },
                { label: 'Nominal', name: 'amount', type: 'number', min: 0 },
                { label: 'Bukti Transaksi', name: 'attachment', type: 'file' },
                { label: 'Deskripsi', name: 'meta', type: 'text', placeholder: 'Isi deskripsi di sini...' },
                { label: 'Kategori Penerima', name: 'recipient_category', type: 'select', options: [
                    { id: 'employee', name: 'Karyawan' },
                    { id: 'donor', name: 'Donatur' },
                    { id: 'student', name: 'Santri' }
                ]},
            ];

            const entityFields = document.getElementById('entityFields');
            entityFields.innerHTML = ''; // Clear previous content
            let trxCategorySelect = null;

            const isEdit = button.classList.contains('btn-edit');

            const row = document.createElement('div');
            row.classList.add('row');
            
            fields.forEach(field => {

                let value = button.dataset[field.name] || '';
                if (field.type === 'hidden') {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = field.name;
                    hiddenInput.value = value;
                    entityFields.appendChild(hiddenInput);
                    return;
                }
              
                const col = document.createElement('div');
                col.classList.add('col-md-6', 'mb-3');

                let inputHTML = '';

                if (field.type === 'select') {
                    inputHTML += `<label class="form-label">${field.label}</label>`;
                    inputHTML += `<select class="form-control" name="${field.name}" id="${field.name}" required>`;
                    inputHTML += `<option value="">-- Pilih ${field.label} --</option>`;
                    field.options.forEach(opt => {
                        const selected = (opt.id == value) ? 'selected' : '';
                        inputHTML += `<option value="${opt.id}" ${selected}>${opt.name}</option>`;
                    });
                    inputHTML += `</select>`;
                } else if (field.type === 'dynamic_trx_category') {
                    inputHTML += `<label class="form-label">Kategori Transaksi</label>`;
                    inputHTML += `<select class="form-control" name="trx_category" id="trx_category" required>`;
                    inputHTML += `<option value="">-- Pilih Kategori Transaksi --</option>`;
                    inputHTML += `</select>`;
                } else {
                    inputHTML += `
                        <label class="form-label">${field.label}</label>
                        <input type="${field.type}" class="form-control" name="${field.name}" 
                            placeholder="${field.placeholder || ''}" value="${value}" ${field.min !== undefined ? `min="${field.min}"` : ''} required>
                    `;
                }

                col.innerHTML = inputHTML;
                row.appendChild(col);

                // Simpan referensi ke trx_category
                if (field.name === 'trx_category') {
                    trxCategorySelect = document.getElementById('trx_category');
                }
            });

        entityFields.appendChild(row);

            // After render: ambil ulang reference
            trxCategorySelect = document.getElementById('trx_category');
            const recipientCategorySelect = document.getElementById('recipient_category');
            const typeSelect = document.querySelector('[name="type"]');

            // Update label dan isi trx_category saat type berubah
            typeSelect.addEventListener('change', function () {
                const selectedType = typeSelect.value;
                const label = recipientCategorySelect?.previousElementSibling;
                if (label) {
                    label.innerText = selectedType === 'debet' ? 'Kategori Pembayar' : 'Kategori yang Menerima';
                }

                const trxOptions = selectedType === 'debet' ? inTrxOptions : outTrxOptions;
                trxCategorySelect.innerHTML = `<option value="">-- Pilih Kategori Transaksi --</option>`;
                trxOptions.forEach(opt => {
                    trxCategorySelect.innerHTML += `<option value="${opt.id}">${opt.name}</option>`;
                });

                // Prefill jika sedang edit
                if (isEdit) {
                    const currentTrx = button.dataset.trx_category;
                    if (currentTrx) {
                        trxCategorySelect.value = currentTrx;
                    }
                }
            });

            // Panggil sekali saat pertama render (untuk edit)
            typeSelect.dispatchEvent(new Event('change'));

            // Listener untuk show select dinamis
            recipientCategorySelect.addEventListener('change', function () {
                showDynamicSelectOptions();
                // Prefill select setelah kategori diterima
                if (isEdit) {
                    const currentRelatedId = button.dataset.related_id;
                    if (currentRelatedId) {
                        const relatedSelect = document.getElementById('related_id');
                        relatedSelect.value = currentRelatedId;
                    }
                }
            });

            function showDynamicSelectOptions() {
                const selectedCategory = recipientCategorySelect.value;
                const dynamicContainer = document.getElementById('entityFields');
                const row = dynamicContainer.querySelector('.row');

                // Hapus semua select dinamis sebelumnya dari dalam row
                const allDynamicFields = row.querySelectorAll('.dynamic-select');
                allDynamicFields.forEach(field => field.remove());

                if (selectedCategory === 'employee') {
                    row.appendChild(showSelectDropdown('Karyawan', 'related_id', employeeOptions));
                } else if (selectedCategory === 'donor') {
                    row.appendChild(showSelectDropdown('Donatur', 'related_id', donorOptions));
                } else if (selectedCategory === 'student') {
                    row.appendChild(showSelectDropdown('Santri', 'related_id', studentOptions));
                }
            }

            // Fungsi untuk membuat dropdown dinamis
            function showSelectDropdown(label, name, options) {
                const selectDiv = document.createElement('div');
                selectDiv.classList.add('dynamic-select', 'col-md-6', 'mb-3');

                let selectedValue = button.dataset[name] || '';  // Ambil nilai selected dari dataset

                let html = `<label class="form-label">Pilih ${label}</label>`;
                html += `<select class="form-control" name="${name}" id="${name}">`;
                html += `<option value="">-- Pilih ${label} --</option>`;
                options.forEach(opt => {
                    const selected = opt.id == selectedValue ? 'selected' : '';  // Tentukan nilai terpilih
                    html += `<option value="${opt.id}" ${selected}>${opt.name}</option>`;
                });
                html += `</select>`;

                selectDiv.innerHTML = html;

                return selectDiv;  // Kembalikan elemen untuk diproses di showDynamicSelectOptions
            }

            // Panggil sekali saat pertama render (untuk edit)
            showDynamicSelectOptions();


            // Modal setup
            document.getElementById('formModalLabel').innerText = isEdit ? 'Edit Transaksi' : 'Tambah Transaksi Baru';
            const form = document.getElementById('formModalForm');
            form.enctype = "multipart/form-data"; // This ensures files are properly sent
            form.action = button.dataset.action;

            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('formModal'));
            modal.show();
        });
    });


        // document.querySelectorAll('.formModalBtn').forEach(button => {
        //     button.addEventListener('click', function () {
        //         const walletOptions = @json($wallet);
        //         const fields = [
        //             { name: 'id', type: 'hidden' },
        //             { label: 'Tanggal', name: 'date', type: 'date' },
        //             { label: 'Deskripsi', name: 'meta', type: 'text', placeholder: 'isi deskripsi di sini...' },
        //             { label: 'Kategori Penerima', name: '', type: 'date' },
        //             {
        //                 label: 'Status', name: 'wallet', type: 'select', options: walletOptions
        //             },
        //         ];

        //         const entityFields = document.getElementById('entityFields');
        //         entityFields.innerHTML = '';

        //         fields.forEach(field => {
        //             const div = document.createElement('div');
        //             div.classList.add('mb-3');

        //             let value = button.dataset[field.name] || ''; // ambil nilai dari data-* kalau ada

        //             let inputHTML = '';

        //             if (field.type === 'select') {
        //                 inputHTML += `<label class="form-label">${field.label}</label>`;
        //                 inputHTML += `<select class="form-control" name="${field.name}" required>`;
        //                 inputHTML += `<option value="">-- Pilih ${field.label} --</option>`;
        //                 field.options.forEach(opt => {
        //                 const selected = (opt.id == value) ? 'selected' : '';
        //                 inputHTML += `<option value="${opt.id}" ${selected}>${opt.name}</option>`;
        //             });
        //                 inputHTML += `</select>`;
        //         } else if (field.type === 'hidden') {
        //             inputHTML = `<input type="hidden" name="${field.name}" value="${value}">`;
                
        //             } else {
        //                 inputHTML = `
        //                     <label class="form-label">${field.label}</label>
        //                     <input type="${field.type}" class="form-control" name="${field.name}" 
        //                         placeholder="${field.placeholder || ''}" value="${value}" required>
        //                 `;
        //             }

        //             div.innerHTML = inputHTML;
        //             entityFields.appendChild(div);
        //         });

        //         // Judul modal disesuaikan
        //         const isEdit = button.classList.contains('btn-edit');
        //         document.getElementById('formModalLabel').innerText = isEdit ? 'Edit Karyawan' : 'Tambah Karyawan Baru';

        //         const form = document.getElementById('formModalForm');
        //         form.action = button.dataset.action;

        //         // Tampilkan modal
        //         const modal = new bootstrap.Modal(document.getElementById('formModal'));
        //         modal.show();
        //     });
        // });
    </script>
    

@include('components.modal')
@include('components.attachment')

@endsection