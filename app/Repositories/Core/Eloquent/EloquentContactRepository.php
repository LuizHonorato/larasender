<?php


namespace App\Repositories\Core\Eloquent;


use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;

class EloquentContactRepository extends BaseEloquentRepository implements ContactRepositoryInterface
{
    public function entity()
    {
        return Contact::class;
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
