<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="evidence">Evidence</label>
        <input type="file" class="form-control-file" id="evidence{{ $id }}" name="evidence" onchange="previewImage({{ $id }})">
    </div>

    <!-- Image Preview -->
    <div class="form-group">
        <label for="evidence{{ $id }}">Preview:</label><br>
        <img name="evidence" name="evidence" id="image-preview-{{ $id }}" src="{{ $record->receiptTransfer ? asset('storage/receipts/'.$record->receiptTransfer) : asset('storage/icons/upload.png') }}" alt="evidence{{ $id }}" style="max-width: 300px">
    </div>

    {{ $slot }}
</form>

<script>
    // Function to preview the selected image
    function previewImage(id) {
        // console.log("Function previewImage called for ID " + id);
        var input = document.getElementById('evidence' + id);
        var imagePreview = document.getElementById('image-preview-' + id);

        input.addEventListener('change', function () {
            if (input.files && input.files[0]) {
                if (input.files[0].type.startsWith('image/')) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                    };

                    reader.readAsDataURL(input.files[0]);
                } else {
                    alert("Not an image file");
                }
            } else {
                imagePreview.src = '';
            }
        });
    }

    // Call the previewImage function for each input field that should trigger image preview
    previewImage({{ $id }});
</script>

