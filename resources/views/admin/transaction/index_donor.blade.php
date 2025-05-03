@extends('admin._layout.main')
@section('title', __('Donasi - TPA Attaqwa'))
@section('heading', __('Data Donasi'))
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h1 class="h3 mb-2 text-gray-800">Donasi</h1>
        <x-date-range-filter/>                                            
    </div>
    <div class="card mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-end">
                <!-- Tombol trigger modal -->
                @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->can('create transaction'))
                    <button id="formModalBtn" data-action="{{ route('trx.donor.submit') }}" class="btn btn-sm btn-primary formModalBtn">
                        Tambah Donasi
                    </button>
                @endif
                @endauth
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
                            <th>Donatur</th>
                            <th>Deskripsi</th>
                            <th>Nominal</th>
                            <th>Dompet</th>
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
                            <td>{{ $data->contact_name->name }}</td>
                            <td>{{ $data->meta }}</td>
                            <td>{{ $data->amount }}</td>
                            <td>{{ $data->wallet->name }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" 
                                onclick="showAttachmentModal('{{ $data->getFirstMediaUrl('transactions') }}')">
                                <i class="ri-eye-fill"></i>
                            </button>
                            <td>
                                @auth
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('update transaction'))
                                    <button type="button" id="formModalBtn" class="btn btn-sm btn-primary formModalBtn btn-edit"
                                        data-id="{{ $data->id }}"
                                        data-date="{{ $data->transaction_at }}"
                                        data-meta="{{ $data->meta }}"
                                        data-amount="{{ $data->amount }}"
                                        data-wallet="{{ $data->wallet_id }}"
                                        data-related_id="{{ $data->related_id }}"
                                        data-action="{{ route('trx.donor.submit', $data->id) }}">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                @endif
                                @endauth
                            <td>
                                @auth
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('delete transaction'))
                                    <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete({{ $data->id }}, '{{ $data->transaction_at }}', 'transactions')">
                                        <i class="ri-delete-bin-fill"></i>
                                    </button>
                                @endif
                                @endauth
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
            const donorOptions = @json($donor);

            const fields = [
                { name: 'id', type: 'hidden' },
                { label: 'Donatur', name: 'related_id', type: 'select', options: donorOptions },
                { label: 'Tanggal', name: 'date', type: 'date' },
                { label: 'Dompet', name: 'wallet', type: 'select', options: walletOptions },
                { label: 'Nominal', name: 'amount', type: 'number', min: 0 },
                { label: 'Bukti Transaksi', name: 'attachment', type: 'file' },
                { label: 'Deskripsi', name: 'meta', type: 'text', placeholder: 'Isi deskripsi di sini...' },
            ];

            const entityFields = document.getElementById('entityFields');
            entityFields.innerHTML = ''; // Clear previous content
            let trxCategorySelect = null;

            const isEdit = button.classList.contains('btn-edit');

            fields.forEach(field => {
                const div = document.createElement('div');
                div.classList.add('mb-3');

                let value = button.dataset[field.name] || '';
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
                } else if (field.type === 'hidden') {
                    inputHTML = `<input type="hidden" name="${field.name}" value="${value}">`;
                } else {
                    inputHTML += `
                        <label class="form-label">${field.label}</label>
                        <input type="${field.type}" class="form-control" name="${field.name}" 
                            placeholder="${field.placeholder || ''}" value="${value}" ${field.min !== undefined ? `min="${field.min}"` : ''} required>
                    `;
                }

                div.innerHTML = inputHTML;
                entityFields.appendChild(div);
            });

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