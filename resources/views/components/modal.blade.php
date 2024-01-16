
 <!-- Modal -->
 <div class="modal fade" id="{{ $idModal }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog @if($customStyle){{ $customStyle }}@endif">
        <div class="modal-content bg-white">
            <div class="modal-header">
            <h5 class="modal-title text-light" id="exampleModalLabel">{{ $title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            {{-- form --}}
            {{ $slot }}
            </div>
        </div>
    </div>
</div>

