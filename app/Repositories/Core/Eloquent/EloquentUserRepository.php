<?php


namespace App\Repositories\Core\Eloquent;


use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;
use App\User;

class EloquentUserRepository extends BaseEloquentRepository implements UserRepositoryInterface
{
    public function entity()
    {
        return User::class;
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
