<?php


namespace App\Repositories\Core\Eloquent;


use App\Models\Email;
use App\Repositories\Contracts\EmailRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;

class EloquentEmailRepository extends BaseEloquentRepository implements EmailRepositoryInterface
{
    public function entity()
    {
        return Email::class;
    }

    public function search(array $data)
    {
        return $this->entity
            ->where(function ($query) use ($data) {
                if(isset($data['name'])) {
                    $query->where('name', 'LIKE', "%{$data['name']}%");
                }
            })
            ->orderBy('id', 'desc')
            ->paginate();
    }
}
