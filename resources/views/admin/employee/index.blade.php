@extends('admin._layout.main')
@section('title', __('Karyawan - TPQ At-Taqwa'))
@section('heading', __('Data Karyawan'))
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h1 class="h3 mb-2 text-gray-800">Karyawan</h1>
        {{-- <x-date-range-filter/>                                             --}}
    </div>
    <div class="card mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-end">
                <!-- Tombol trigger modal -->
                @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->can('create employee'))
                    <button id="formModalBtn" data-action="{{ route('employees.submit') }}" class="btn btn-sm btn-primary formModalBtn">
                        Tambah Karyawan Baru
                    </button>
                @endif
                @endauth
                {{-- <button id="formModal" class="btn d-none d-sm-inline-block btn btn-sm btn-primary">Tambah Santri Baru</button> --}}
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
                            <th>Alamat</th>
                            <th>WhatsApp</th>
                            <th>Tanggal Masuk</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    @foreach($employees as $no=>$data)
                        <tbody>
                            <td>{{ $no+1 }}</td>
                            <td>{{ $data->cid }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->address }}</td>
                            {{-- <td>{{ $data->whatsapp }}</td> --}}
                            <td>

                                @auth
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('update employee'))
                                    <a href="https://wa.me/62{{ ltrim($data->whatsapp, '0') }}" target="_blank">
                                        {{ $data->whatsapp }}
                                    </a>
                                @endif
                                @endauth
                            </td>
                            <td>{{ $data->register_date->format('d M Y') }}</td>
                            <td>{{ $data->employee_category->name }}</td>
                            <td>{{ $data->statuses->name }}</td>
                            <td>

                                @auth
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('delete employee'))
                                    <button type="button" id="formModalBtn" class="btn btn-sm btn-primary formModalBtn btn-edit"
                                        data-id="{{ $data->id }}"
                                        data-name="{{ $data->name }}"
                                        data-address="{{ $data->address }}"
                                        data-whatsapp="{{ $data->whatsapp }}"
                                        data-register_date="{{ $data->register_date }}"
                                        data-category="{{ $data->employee_category_id }}"
                                        data-status="{{ $data->status_id }}"
                                        data-action="{{ route('employees.submit', $data->id) }}">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                @endif
                                @endauth
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'employees')">
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
        document.querySelectorAll('.formModalBtn').forEach(button => {
            button.addEventListener('click', function () {
                const statusOptions = @json($status);
                const categoryOptions = @json($category);
                const fields = [
                    { name: 'id', type: 'hidden' },
                    { label: 'Nama', name: 'name', type: 'text' },
                    { label: 'Alamat', name: 'address', type: 'text' },
                    { label: 'WhatsApp', name: 'whatsapp', type: 'text', placeholder: '08xxxxxxxxxx' },
                    { label: 'Tanggal Masuk', name: 'register_date', type: 'date' },
                    {
                        label: 'Kategory', name: 'category', type: 'select', options: categoryOptions
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
                        inputHTML += `<select class="form-control" name="${field.name}" required>`;
                        inputHTML += `<option value="">-- Pilih ${field.label} --</option>`;
                        field.options.forEach(opt => {
                            const selected = (opt.id == value) ? 'selected' : '';
                            inputHTML += `<option value="${opt.id}" ${selected}>${opt.name}</option>`;
                        });
                        inputHTML += `</select>`;
                    } else {
                        inputHTML += `
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
                document.getElementById('formModalLabel').innerText = isEdit ? 'Edit Karyawan' : 'Tambah Karyawan Baru';

                const form = document.getElementById('formModalForm');
                form.action = button.dataset.action;

                const modal = new bootstrap.Modal(document.getElementById('formModal'));
                modal.show();
            });
        });

        // document.querySelectorAll('.formModalBtn').forEach(button => {
        //     button.addEventListener('click', function () {
        //         const statusOptions = @json($status);
        //         const categoryOptions = @json($category);
        //         const fields = [
        //             { name: 'id', type: 'hidden' },
        //             { label: 'Nama', name: 'name', type: 'text' },
        //             { label: 'Alamat', name: 'address', type: 'text' },
        //             { label: 'WhatsApp', name: 'whatsapp', type: 'text', placeholder: '08xxxxxxxxxx' },
        //             { label: 'Tanggal Masuk', name: 'register_date', type: 'date' },
        //             {
        //                 label: 'Kategory', name: 'category', type: 'select', options: categoryOptions
        //             },
        //             {
        //                 label: 'Status', name: 'status', type: 'select', options: statusOptions
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

@endsection