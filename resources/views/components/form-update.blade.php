{{-- form --}}
<form action="{{$action}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    {{-- if record has value show record input image--}}
    @if ($record->receiptTransfer !== null)
        <div class="form-group">
            <label for="evidence">Bukti Pembayaran</label>
            <input type="file" class="form-control-file" id="evidence" name="evidence" onchange="previewImage()">
        </div>

        <!-- Image Preview -->
        <div class="form-group">
            <label for="evidence">Preview: <img id="image-preview" for="evidence" src="{{ asset('storage/receipts/'.$record->receiptTransfer) }}" alt="evidence" max-width="300px"></label>
        </div>

        {{$slot}}
    @else
        <div class="form-group">
            <label for="evidence">Bukti Pembayaran</label>
            <input type="file" class="form-control-file" id="evidence" name="evidence">
        </div>
        {{-- preview img --}}
        <div class="form-group">
            <label id="image-preview" for="evidence"><img src="https://miro.medium.com/v2/resize:fit:2400/0*hDAyhnOx767w5qma.jpg" alt="evidence" width="900px"></label>
        </div>
        {{$slot}}
    @endif
    <!-- Add more form fields as needed -->

    <script>
        function previewImage() {
            var input = document.getElementById('evidence');
            var imagePreview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</form>
