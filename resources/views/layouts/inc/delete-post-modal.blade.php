<div id="delete-modal" class="modal start-50 top-50 modal-alert position-absolute d-none bg-secondary py-5 zindex-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content rounded-3 shadow">
        <div class="modal-body p-4 text-center">
          <h5 class="mb-0">Delete this post?</h5>
          <p class="mb-0">You can always delete it in your profile.</p>
        </div>
        <div class="modal-footer flex-nowrap p-0 text-center">
            <a href="{{ route('change-post-status', ['post_id' => $post->id, 'is_deleted' => 'true']) }}"class="w-100" ><button type="button" class="btn btn-lg btn-link fs-6 w-100 text-decoration-none col-6 m-0 rounded-0 border-end delete-post">Yes, delete</button></a>
          <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 cancel-delete-post" data-bs-dismiss="modal">No, thanks</button>
        </div>
      </div>
    </div>
  </div>

<script>
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('delete-post')){
            document.getElementById('delete-modal').className = 'd-block'
        }
    })
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('cancel-delete-post')){
            document.getElementById('delete-modal').className = 'd-none'
        }
    })
</script>
