@if (session()->has($type))
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">تنبيه !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                        <span class="alert-icon">
                            <i class="ni ni-like-2"></i>
                        </span>
                        <span class="alert-text">
                            {{ session($type) }}
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">تم</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $('#exampleModalCenter').modal('show');
    </script>
    @endpush
@endif
