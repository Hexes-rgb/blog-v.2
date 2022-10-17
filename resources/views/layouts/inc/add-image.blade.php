<div class="mt-4 w-50">
    <div class="file-upload">
        <label class="btn btn-outline-primary" for="postImage">Add your image
            <input type="file" class="d-none" name='image' onchange="getFileName ();" id="postImage" />
        </label>
        <div id="file-name"></div>
    </div>
</div>

<script>
    function getFileName() {
        var file = document.getElementById('postImage').value;
        file = file.replace(/\\/g, '/').split('/').pop();
        document.getElementById('file-name').innerHTML = 'File:  ' + file;
    }
</script>
