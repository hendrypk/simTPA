@extends('admin._layout.main')
@section('title', __('Akun - TPQ At-Taqwa'))
@section('heading', __('Data Donatur'))
@section('content')
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <!-- Login Card -->
            <div class="card p-4">
                <h4 class="text-center mb-4">Detil Akun</h4>

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                    <div class="d-flex align-items-center justify-content-center">
                        <img class="img-profile rounded-circle mb-2 d-block mx-auto" 
                            src="{{ auth()->user()->getFirstMediaUrl('profile') ?: asset('default-avatar.png') }}" 
                            id="profileImage" 
                            style="cursor: pointer; width: 120px; height: 120px; object-fit: cover;"
                            onclick="document.getElementById('fileInput').click();">
                        <input type="file" id="fileInput" style="display: none;" onchange="uploadProfileImage(event)">
                    </div>
                
                
                {{-- <img class="img-profile rounded-circle mb-2" 
                        src="{{ auth()->user()->getFirstMediaUrl('profile') ?: asset('default-avatar.png') }}" 
                        id="profileImage" style="cursor: pointer;" onclick="document.getElementById('fileInput').click();">
                
                <!-- Input file yang tersembunyi -->
                <input type="file" id="fileInput" style="display: none;" onchange="uploadProfileImage(event)"> --}}
           
                

                <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama -->
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="form-control">
                    </div>
            
                    <!-- Username -->
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" class="form-control">
                    </div>
            
                    <!-- Email -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="form-control">
                    </div>
            
                    <!-- Nomor Telepon -->
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="form-control">
                    </div>
            
                    <!-- Password -->
                    <div class="form-group">
                        <label>Password Baru (opsional)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
            
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

@section('script')
<script>
function uploadProfileImage(event) {
    const formData = new FormData();
    formData.append('profile_image', event.target.files[0]);

    // Gunakan route name untuk mendapatkan URL
    const uploadUrl = "{{ route('profile.upload') }}";

    fetch(uploadUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pastikan CSRF token dikirim dengan benar
        },
        body: formData
    })
    .then(response => response.json()) // Memastikan server mengembalikan response JSON
    .then(data => {
        console.log(data);  // Cek respons dari server
            if (data.success) {
                const profileImage = document.getElementById('profileImage');
                profileImage.src = data.new_image_url + "?t=" + new Date().getTime();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    timer: 2000, // ⏳ Tampilkan alert selama 2 detik
                    showConfirmButton: false,
                    willClose: () => {
                        window.location.reload(); // 🔁 Reload otomatis saat alert ditutup
                    }
                });
            } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Upload gagal'
            });
        }

    })
    .catch(error => console.error('Error uploading image:', error));
}


</script>
@endsection
@endsection