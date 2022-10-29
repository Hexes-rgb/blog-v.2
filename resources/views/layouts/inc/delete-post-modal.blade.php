 <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete post</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this post?
        </div>
        <div class="modal-footer row">
            <form action="{{ route('post.delete', ['post_id' => $post->id]) }}" method="POST">
                @csrf
                @method('delete')
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end delete-post">
                    Yes, delete
                </button>
            </form>
          <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 cancel-delete-post" data-bs-dismiss="modal">No, thanks</button>
        </div>
      </div>
    </div>
  </div>
