{{-- @props(['id' => 'dateRange', 'name' => 'date_range', 'label' => 'Rentang Tanggal', 'value' => ''])

<!-- Date Range Picker -->
<div class="md-form md-outline input-with-post-icon">
    <input
        type="text"
        id="{{ $id }}"
        name="{{ $name }}"
        class="form-control"
        value="{{ old($name, $value) ?: \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') . ' to ' . \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" 
    >
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                flatpickr("#{{ $id }}", {
                    mode: "range", // Enable range mode for selecting a date range
                    dateFormat: "Y-m-d", // The format of the date
                    locale: {
                        firstDayOfWeek: 1 // Start the week from Monday
                    }
                });
            });
        </script>
    @endpush
@endonce --}}

@props(['id' => 'dateRange', 'name' => 'date_range', 'label' => 'Rentang Tanggal', 'value' => ''])

<div class="md-form md-outline input-with-post-icon w-100">
    <input
        type="text"
        id="{{ $id }}"
        name="{{ $name }}"
        class="form-control"
        placeholder="Pilih rentang tanggal"
        style="min-width: 250px;"
        value="{{ old($name, $value) ?: \Carbon\Carbon::now()->startOfMonth()->translatedFormat('d F Y') . ' to ' . \Carbon\Carbon::now()->endOfMonth()->translatedFormat('d F Y') }}"

        {{-- value="{{ old($name, $value) ?: \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d') . ' to ' . \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}" --}}
        autocomplete="off"
    >
</div>

@once
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector('#{{ $id }}').closest('form');

            flatpickr("#{{ $id }}", {
                mode: "range",
                dateFormat: "d F Y",
                maxDate: "today",
                locale: {
                    firstDayOfWeek: 1
                },
                onClose: function(selectedDates) {
                    // Hanya submit jika 2 tanggal dipilih
                    if (selectedDates.length === 2 && form) {
                        form.submit();
                    }
                }
            });
        });
    </script>
    @endpush
@endonce
