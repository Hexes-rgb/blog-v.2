<div class="mt-4 w-50">
    <div class="file-upload">
        <label class="btn btn-outline-primary" for="postImage">Add your image
            <input type="file" class="d-none" name='image' onchange="getFileName ();" id="postImage" />
        </label>
        <div id="file-name"></div>
    </div>
</div>
@error('image')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
<script>
    function getFileName() {
        var file = document.getElementById('postImage').value;
        file = file.replace(/\\/g, '/').split('/').pop();
        document.getElementById('file-name').innerHTML = 'File:  ' + file;
    }
</script>
