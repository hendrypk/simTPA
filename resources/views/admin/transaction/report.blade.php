@extends('admin._layout.main')
@section('title', __('Report - TPA Attaqwa'))
@section('heading', __('Report'))
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-end">
        </div>
        <div class="card-body">
            <canvas id="transactionChart" height="100"></canvas>       
        </div>
    </div>

    <script>    
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('transactionChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels), // January–December
            datasets: [
                {
                    label: 'Credit',
                    backgroundColor: '#28a745',
                    data: @json($credit),
                },
                {
                    label: 'Debet',
                    backgroundColor: '#dc3545',
                    data: @json($debet),
                }
            ]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Monthly Transaction Summary ({{ now()->year }})'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: value => 'Rp ' + value.toLocaleString()
                    }
                }]
            }
        }
    });
});
    </script>
    

@include('components.modal')
@include('components.attachment')

@endsection