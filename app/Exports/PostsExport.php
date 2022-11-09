<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class PostsExport implements FromQuery
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public function __construct(int $post_id)
    {
        $this->id = $post_id;

        return $this;
    }

    public function query()
    {
        return Post::query()->select('id', 'title', 'content', 'created_at')->where('id', $this->id);;
    }
}
