{{-- <form method="GET" action="{{ url()->current() }}" class="form-inline mt-2 mt-sm-0">
    <div class="input-group">
        <x-date-range-picker id="dashboardFilter" name="date_range" :value="request('date_range')" />
        <div class="input-group-append ml-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter mr-1"></i> Terapkan
            </button>
        </div>
    </div>
</form> --}}
<form method="GET" action="{{ url()->current() }}" class="form-inline mt-2 mt-sm-0">
    <div class="input-group align-items-center">
        <x-date-range-picker 
            id="dashboardFilter"
            name="date_range"
            :value="request('date_range')" 
        />
    </div>
</form>
