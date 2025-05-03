<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    {{-- <title>SB Admin 2 - Dashboard</title> --}}
    <title>@yield('title','TPQ At-Taqwa')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.jpg') }}">


    @vite([
        'resources/css/app.css'
    ])
    
    <!-- Remix Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    @stack('styles')

</head>
@include('admin._layout.header')
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('admin._layout.sidebar')
                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">
                        <!--page heading-->
                        <div class="container-fluid">
                            {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4 flex-wrap">
                                <h1 class="h3 mb-2 text-gray-800">@yield('heading', 'Heading')</h1>
                                @if(!in_array(request()->route()->getName(), ['options.index', 'roles.index', 'roles.detail']))
                                @endif                                                    
                            </div> --}}
                            @yield('content')
                        </div>
                        <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Hendry PK | 2025</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Success Message --}}
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000, // ⏳ Tampilkan alert selama 2 detik
                showConfirmButton: false,

                // icon: 'success',
                // title: 'Berhasil!',
                // text: '{{ session('success') }}',
                // confirmButtonColor: '#3085d6',
                // confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    {{-- Error Validation Message --}}
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Tutup'
            });
        });
    </script>
    @endif

    <script>
    //Delete Modal
    function confirmDelete(id, name, entity) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete the " + entity + ": " + name,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '',
            cancelButtonColor: '',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/${entity}/${id}/delete`, { 
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.message, // Use message from the server
                            icon: 'success'
                        }).then(() => {
                            // Reload the page or redirect to another route
                            window.location.href = data.redirect; // Redirect to the desired route
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Something went wrong. Try again later.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'Failed to delete. Please try again.', 'error');
                    console.error('There was a problem with the fetch operation:', error);
                });
            }
        });
    }
    </script>
    <!-- jQuery (Pastikan ini sebelum Bootstrap dan sb-admin-2.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SB Admin 2 JavaScript -->
    @vite([
        // 'resources/js/sb-admin-2.js',
        'resources/js/app.js',
        // 'resources/js/sb-admin-2.min.js',
        // 'resources/vendor/chart.js/Chart.min.js',
    ])
    @yield('script')
    @stack('scripts')
</body>

</html>