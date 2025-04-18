@extends('admin._layout.main')
@section('title', __('TPQ At-Taqwa'))
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Santri</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Ekspor</a> --}}
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-end">
                <!-- Tombol trigger modal -->
                <button id="openModalStudentBtn" class="btn btn-sm btn-primary shadow-sm openModalStudentBtn">
                    Tambah Santri Baru
                </button>

                {{-- <button id="modalStudent" class="btn d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Tambah Santri Baru</button> --}}
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
                            <th>TTL</th>
                            <th>Kelas</th>
                            <th>Nama Wali</th>
                            <th>WhatsApp</th>
                            <th>Tanggal Masuk</th>
                            <th>Asal Sekolah</th>
                            <th>Edit</th>
                            <th>Hapus</th>
                        </tr>
                    </thead>
                    @foreach($students as $no=>$data)
                        <tbody>
                            <td>{{ $no+1 }}</td>
                            <td>{{ $data->nis }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->place_birth }}, {{ $data->date_birth }}</td>
                            <td>{{ $data->class->name }}</td>
                            <td>{{ $data->father_name }}</td>
                            <td>{{ $data->parent_number }}</td>
                            <td>{{ $data->register_date }}</td>
                            <td>{{ $data->school->name }}</td>
                            <td>
                                <button type="button" id="openModalStudentBtn" class="btn btn-sm btn-primary openModalStudentBtn btn-edit"
                                    data-id="{{ $data->id }}"
                                    data-nis="{{ $data->nis }}"
                                    data-name="{{ $data->name }}"
                                    data-place_birth="{{ $data->place_birth }}"
                                    data-date_birth="{{ $data->date_birth }}"
                                    data-class_id="{{ $data->class_id }}"
                                    data-father_name="{{ $data->father_name }}"
                                    data-parent_number="{{ $data->parent_number }}"
                                    data-register_date="{{ $data->register_date }}"
                                    data-school_id="{{ $data->school_id }}"
                                    data-url="{{ route('student.submit', $data->id) }}">
                                    <i class="ri-pencil-fill"></i>
                                </button>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="confirmDelete({{ $data->id }}, '{{ $data->name }}', 'students')">
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
        document.querySelectorAll('.openModalStudentBtn').forEach(button => {
            button.addEventListener('click', function () {
                const classOptions = @json($class);
                const schoolOptions = @json($school);
                const fields = [
                    { name: 'id', type: 'hidden' },
                    { label: 'Nama', name: 'name', type: 'text' },
                    { label: 'Tempat Lahir', name: 'place_birth', type: 'text', placeholder: 'Contoh: Bandung' },
                    { label: 'Tanggal Lahir', name: 'date_birth', type: 'date' },
                    {
                        label: 'Kelas', name: 'class_id', type: 'select', options: classOptions
                    },
                    { label: 'Nama Wali', name: 'father_name', type: 'text' },
                    { label: 'WhatsApp', name: 'parent_number', type: 'text', placeholder: '08xxxxxxxxxx' },
                    { label: 'Tanggal Masuk', name: 'register_date', type: 'date' },
                    {
                        label: 'Sekolah', name: 'school_id', type: 'select', options: schoolOptions
                    },
                ];

                const entityFields = document.getElementById('entityFields');
                entityFields.innerHTML = '';

                fields.forEach(field => {
                    const div = document.createElement('div');
                    div.classList.add('mb-3');

                    let value = button.dataset[field.name] || ''; // ambil nilai dari data-* kalau ada

                    let inputHTML = '';

                    if (field.type === 'select') {
                        inputHTML += `<label class="form-label">${field.label}</label>`;
                        inputHTML += `<select class="form-control" name="${field.name}" required>`;
                        inputHTML += `<option value="">-- Pilih ${field.label} --</option>`;
                        field.options.forEach(opt => {
                        const selected = (opt.id == value) ? 'selected' : '';
                        inputHTML += `<option value="${opt.id}" ${selected}>${opt.name}</option>`;
                    });

                        // field.options.forEach(opt => {
                        //     const selected = (opt.name === value || opt.id == value) ? 'selected' : '';
                        //     inputHTML += `<option value="${opt.id}" ${selected}>${opt.name}</option>`;
                        // });
                        inputHTML += `</select>`;
                } else if (field.type === 'hidden') {
                    inputHTML = `<input type="hidden" name="${field.name}" value="${value}">`;
                
                    } else {
                        inputHTML = `
                            <label class="form-label">${field.label}</label>
                            <input type="${field.type}" class="form-control" name="${field.name}" 
                                placeholder="${field.placeholder || ''}" value="${value}" required>
                        `;
                    }

                    div.innerHTML = inputHTML;
                    entityFields.appendChild(div);
                });

                // Judul modal disesuaikan
                const isEdit = button.classList.contains('btn-edit');
                document.getElementById('modalStudentLabel').innerText = isEdit ? 'Edit Santri' : 'Tambah Santri Baru';

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