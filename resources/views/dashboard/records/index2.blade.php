<x-front-layout>
    @push('styles')
        <style>
            .main-content{
                margin: 0 !important;
            }
        </style>
    @endpush
    <div class="row">
        <div class="col-md-12 my-4">
            <livewire:table-record />
        </div> <!-- Bordered table -->
    </div>
</x-front-layout>
