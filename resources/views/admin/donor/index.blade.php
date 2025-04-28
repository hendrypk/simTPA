@extends('admin._layout.main')
@section('title', __('TPQ At-Taqwa'))
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Doantur</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Ekspor</a> --}}
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-end">
                <!-- Tombol trigger modal -->
                <button id="openModal" class="btn btn-sm btn-primary shadow-sm openModal">
                    Tambah Doantur Baru
                </button>

                {{-- <button id="modalDonor" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Santri Baru</button> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>WhatsApp</th>
                            <th>Alamat</th>
                            <th>Tanggal Terdaftar</th>
                            <th>Paket Donasi</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    @foreach($donors as $no=>$data)
                        <tbody>
                            <td>{{ $no+1 }}</td>
                            <td>{{ $data->cid }}</td>
                            <td>{{ $data->name }}</td>
                            <td>
                                <a href="https://wa.me/62{{ ltrim($data->whatsapp, '0') }}" target="_blank">
                                    {{ $data->whatsapp }}
                                </a>
                            </td>
                            <td>{{ $data->address }}</td>
                            <td>{{ $data->register_date }}</td>
                            <td>{{ $data->packages->name }}</td>
                            <td>{{ $data->statuses->name }}</td>
                            <td>
                                <button type="button" id="openModal" class="btn btn-sm btn-primary openModal btn-edit"
                                    data-id="{{ $data->id }}"
                                    data-nis="{{ $data->nis }}"
                                    data-name="{{ $data->name }}"
                                    data-whatsapp="{{ $data->whatsapp }}"
                                    data-address="{{ $data->address }}"
                                    data-register_date="{{ $data->register_date }}"
                                    data-package_id="{{ $data->package_id }}"
                                    data-status="{{ $data->status_id }}"
                                    data-url="{{ route('donors.submit', $data->id) }}">
                                    <i class="ri-pencil-fill"></i>
                                </button>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'donors')">
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
document.querySelectorAll('.openModal').forEach(button => {
    button.addEventListener('click', function () {
        const packageOptions = @json($package);
        const statusOptions = @json($status);
        const fields = [
            { name: 'id', type: 'hidden' },
            { label: 'Nama', name: 'name', type: 'text' },
            { label: 'Alamat', name: 'address', type: 'text', placeholder: 'Contoh: Jl Duku Candi III' },
            { label: 'WhatsApp', name: 'whatsapp', type: 'text', placeholder: '08xxxxxxxxxx' },
            { label: 'Tanggal Terdaftar', name: 'register_date', type: 'date' },
            {
                label: 'Paket Donasi', name: 'package_id', type: 'select', options: packageOptions
            },
            {
                label: 'Status', name: 'status', type: 'select', options: statusOptions
            },
        ];

        const entityFields = document.getElementById('entityFields');
        entityFields.innerHTML = '';

        const row = document.createElement('div');
        row.classList.add('row');

        fields.forEach(field => {
            let value = button.dataset[field.name] || ''; // ambil nilai dari data-* kalau ada

            // Tangani input hidden langsung, jangan dimasukkan ke grid
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
                inputHTML += `<select class="form-control" name="${field.name}" required>`;
                inputHTML += `<option value="">-- Pilih ${field.label} --</option>`;
                field.options.forEach(opt => {
                    const selected = (opt.id == value) ? 'selected' : '';
                    inputHTML += `<option value="${opt.id}" ${selected}>${opt.name}</option>`;
                });
                inputHTML += `</select>`;
            } else {
                inputHTML = `
                    <label class="form-label">${field.label}</label>
                    <input type="${field.type}" class="form-control" name="${field.name}" 
                        placeholder="${field.placeholder || ''}" value="${value}" required>
                `;
            }

            col.innerHTML = inputHTML;
            row.appendChild(col);
        });

        entityFields.appendChild(row);

        const isEdit = button.classList.contains('btn-edit');
        document.getElementById('modalDonorLabel').innerText = isEdit ? 'Edit Donatur' : 'Tambah Donatur Baru';

        const modal = new bootstrap.Modal(document.getElementById('modalDonor'));
        modal.show();
    });
});


    </script>
    

@include('admin.donor.modal')

@endsection