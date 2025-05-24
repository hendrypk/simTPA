@extends('admin._layout.main')
@section('title', __('Santri - TPQ At-Taqwa'))
@section('heading', __('Data Santri'))
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h1 class="h3 mb-2 text-gray-800">Santri</h1>
        {{-- <x-date-range-filter/>                                             --}}
    </div>
    <div class="card mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-end">
                <!-- Tombol trigger modal -->
                @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->can('create student'))
                    <button id="openModalStudentBtn" class="btn btn-sm btn-primary openModalStudentBtn">
                        Tambah Santri Baru
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
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>TTL</th>
                            <th>Kelas</th>
                            <th>Nama Wali</th>
                            <th>WhatsApp Wali</th>
                            <th>Tanggal Masuk</th>
                            <th>Sekolah</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    @foreach($students as $no=>$data)
                        <tbody>
                            <td>{{ $no+1 }}</td>
                            <td>{{ $data->cid }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->address }}</td>
                            <td>{{ $data->place_birth }}, {{ $data->date_birth->format('d M Y') }}</td>
                            <td>{{ $data->classes->name }}</td>
                            <td>{{ $data->guardian_name }}</td>
                            <td>
                                <a href="https://wa.me/62{{ ltrim($data->guardian_number, '0') }}" target="_blank">
                                    {{ $data->guardian_number }}
                                </a>
                            </td>
                            <td>{{ $data->register_date->format('d M Y') }}</td>
                            <td>{{ $data->schools->name }}</td>
                            <td>{{ $data->statuses->name }}</td>
                            <td>
                                @auth
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('update student'))
                                    <button type="button" id="openModalStudentBtn" class="btn btn-sm btn-primary openModalStudentBtn btn-edit"
                                        data-id="{{ $data->id }}"
                                        data-cid="{{ $data->cid }}"
                                        data-name="{{ $data->name }}"
                                        data-address="{{ $data->address }}"
                                        data-place_birth="{{ $data->place_birth }}"
                                        data-date_birth="{{ $data->date_birth->format('Y-m-d') }}"
                                        data-class_id="{{ $data->class_id }}"
                                        data-guardian_name="{{ $data->guardian_name }}"
                                        data-guardian_number="{{ $data->guardian_number }}"
                                        data-register_date="{{ $data->register_date->format('Y-m-d') }}"
                                        data-school_id="{{ $data->school_id }}"
                                        data-status="{{ $data->status_id }}"
                                        data-url="{{ route('student.submit', $data->id) }}">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                @endif
                                @endauth
                            <td>
                                @auth
                                @if(auth()->user()->hasRole('admin') || auth()->user()->can('delete student'))
                                    <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'students')">
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
        // document.querySelectorAll('.openModalStudentBtn').forEach(button => {
        //     button.addEventListener('click', function () {
        //         const classOptions = @json($class);
        //         const schoolOptions = @json($school);
        //         const statusOptions = @json($status);
        //         const fields = [
        //             { name: 'id', type: 'hidden' },
        //             { label: 'Nama', name: 'name', type: 'text' },
        //             { label: 'Alamat', name: 'address', type: 'text', placeholder: 'Contoh: Bandung' },
        //             { label: 'Tempat Lahir', name: 'place_birth', type: 'text', placeholder: 'Contoh: Bandung' },
        //             { label: 'Tanggal Lahir', name: 'date_birth', type: 'date' },
        //             { label: 'Kelas', name: 'class_id', type: 'select', options: classOptions },
        //             { label: 'Nama Wali', name: 'guardian_name', type: 'text' },
        //             { label: 'WhatsApp', name: 'guardian_number', type: 'text', placeholder: '08xxxxxxxxxx' },
        //             { label: 'Tanggal Masuk', name: 'register_date', type: 'date' },
        //             { label: 'Sekolah', name: 'school_id', type: 'select', options: schoolOptions },
        //             { label: 'Status', name: 'status', type: 'select', options: statusOptions },
        //         ];

        //         const entityFields = document.getElementById('entityFields');
        //         entityFields.innerHTML = ''; // Kosongkan dulu

        //         let row = document.createElement('div');
        //         row.className = 'row';
        //         fields.forEach((field, index) => {
        //             if (field.type === 'hidden') {
        //                 const input = document.createElement('input');
        //                 input.type = 'hidden';
        //                 input.name = field.name;
        //                 row.appendChild(input);
        //                 return;
        //             }

        //             const col = document.createElement('div');
        //             col.className = 'col-md-6 mb-3';

        //             const label = document.createElement('label');
        //             label.className = 'form-label';
        //             label.innerText = field.label;
        //             col.appendChild(label);

        //             let input;
        //             if (field.type === 'select') {
        //                 input = document.createElement('select');
        //                 input.name = field.name;
        //                 input.className = 'form-control';

        //                 field.options.forEach(opt => {
        //                     const option = document.createElement('option');
        //                     option.value = opt.id;
        //                     option.innerText = opt.name;
        //                     input.appendChild(option);
        //                 });

        //             } else {
        //                 input = document.createElement('input');
        //                 input.type = field.type;
        //                 input.name = field.name;
        //                 input.className = 'form-control';
        //                 input.placeholder = field.placeholder || '';
        //             }

        //             col.appendChild(input);
        //             row.appendChild(col);

        //             // Tambahkan row baru setiap 2 kolom (optional, Bootstrap handle otomatis)
        //         });

        //         entityFields.appendChild(row);


        //         // Judul modal disesuaikan
        //         const isEdit = button.classList.contains('btn-edit');
        //         document.getElementById('modalStudentLabel').innerText = isEdit ? 'Edit Santri' : 'Tambah Santri Baru';

        //         // Tampilkan modal
        //         const modal = new bootstrap.Modal(document.getElementById('modalStudent'));
        //         modal.show();
        //     });
        // });
        document.querySelectorAll('.openModalStudentBtn').forEach(button => {
    button.addEventListener('click', function () {
        const classOptions = @json($class);
        const schoolOptions = @json($school);
        const statusOptions = @json($status);

        const fields = [
            { name: 'id', type: 'hidden' },
            { label: 'Nama', name: 'name', type: 'text' },
            { label: 'Alamat', name: 'address', type: 'text', placeholder: 'Contoh: Bandung' },
            { label: 'Tempat Lahir', name: 'place_birth', type: 'text', placeholder: 'Contoh: Bandung' },
            { label: 'Tanggal Lahir', name: 'date_birth', type: 'date' },
            { label: 'Kelas', name: 'class_id', type: 'select', options: classOptions },
            { label: 'Nama Wali', name: 'guardian_name', type: 'text' },
            { label: 'WhatsApp', name: 'guardian_number', type: 'text', placeholder: '08xxxxxxxxxx' },
            { label: 'Tanggal Masuk', name: 'register_date', type: 'date' },
            { label: 'Sekolah', name: 'school_id', type: 'select', options: schoolOptions },
            { label: 'Status', name: 'status', type: 'select', options: statusOptions },
        ];

        const entityFields = document.getElementById('entityFields');
        entityFields.innerHTML = '';

        let row = document.createElement('div');
        row.className = 'row';

        fields.forEach(field => {
            const fieldValue = button.dataset[field.name];

            if (field.type === 'hidden') {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = field.name;
                input.value = fieldValue || '';
                row.appendChild(input);
                return;
            }

            const col = document.createElement('div');
            col.className = 'col-md-6 mb-3';

            const label = document.createElement('label');
            label.className = 'form-label';
            label.innerText = field.label;
            col.appendChild(label);

            let input;

            if (field.type === 'select') {
                input = document.createElement('select');
                input.name = field.name;
                input.className = 'form-control';

                field.options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.id;
                    option.innerText = opt.name;
                    if (String(fieldValue) === String(opt.id)) {
                        option.selected = true;
                    }
                    input.appendChild(option);
                });
            } else {
                input = document.createElement('input');
                input.type = field.type;
                input.name = field.name;
                input.className = 'form-control';
                input.placeholder = field.placeholder || '';
                input.value = fieldValue || '';
            }

            col.appendChild(input);
            row.appendChild(col);
        });

        entityFields.appendChild(row);

        // Set action form
        // document.getElementById('formStudent').action = button.getAttribute('data-url');

        // Ubah judul
        document.getElementById('modalStudentLabel').innerText = 'Edit Santri';

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById('modalStudent'));
        modal.show();
    });
});


        // document.getElementById('openModalStudentBtn').addEventListener('click', function () {
        //     const classOptions = @json($class);
        //     const schoolOptions = @json($school);
        //     const fields = [
        //         { label: 'Nama', name: 'name', type: 'text' },
        //         { label: 'Tempat Lahir', name: 'place_birth', type: 'text', placeholder: 'Contoh: Bandung' },
        //         { label: 'Tanggal Lahir', name: 'date_birth', type: 'date', placeholder: 'Contoh: Bandung' },
        //         {
        //             label: 'Kelas', name: 'class_id', type: 'select', options: classOptions
        //         },
        //         { label: 'Nama Wali', name: 'father_name', type: 'text' },
        //         { label: 'WhatsApp', name: 'parent_number', type: 'text', placeholder: '08xxxxxxxxxx' },
        //         { label: 'Tanggal Masuk', name: 'register_date', type: 'date' },
        //         {
        //             label: 'Sekolah', name: 'school_id', type: 'select', options: schoolOptions
        //         },
        //     ];
    
        //     const entityFields = document.getElementById('entityFields');
        //     entityFields.innerHTML = ''; // clear existing fields
    
        //     fields.forEach(field => {
        //         const div = document.createElement('div');
        //         div.classList.add('mb-3');

        //         let inputHTML = '';

        //         if (field.type === 'select') {
        //             inputHTML += `<label class="form-label">${field.label}</label>`;
        //             inputHTML += `<select class="form-control" name="${field.name}" required>`;
        //             inputHTML += `<option value="">-- Pilih ${field.label} --</option>`;
        //             field.options.forEach(opt => {
        //                 inputHTML += `<option value="${opt.id}">${opt.name}</option>`;
        //             });
        //             inputHTML += `</select>`;
        //         } else {
        //             inputHTML = `
        //                 <label class="form-label">${field.label}</label>
        //                 <input type="${field.type}" class="form-control" name="${field.name}" 
        //                     placeholder="${field.placeholder || ''}" required>
        //             `;
        //         }

        //         div.innerHTML = inputHTML;
        //         entityFields.appendChild(div);
        //     });
    
        //     document.getElementById('modalStudentLabel').innerText = 'Tambah Santri Baru';

        //     // Tampilkan modal
        //     const modal = new bootstrap.Modal(document.getElementById('modalStudent'));
        //     modal.show();
        // });
    </script>
    

@include('admin.student.modal')

@endsection