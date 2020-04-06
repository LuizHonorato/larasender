<?php


namespace App\Repositories\Core;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\NotEntityDefined;

class BaseEloquentRepository
{
    protected $entity;

    public function __construct()
    {
        $this->entity = $this->resolveEntity();
    }

    public function all()
    {
        return $this->entity->get();
    }

    public function findById($id)
    {
        return $this->entity->find($id);
    }

    public function findWhere($column, $value)
    {
        return $this->entity->where($column, $value)->get();
    }

    public function findWhereFirst($column, $value)
    {
        return $this->entity->where($column, $value)->first();
    }

    public function paginate($totalPage = 10)
    {
        return $this->entity->paginate($totalPage);
    }

    public function store(array $data)
    {
        $entity = $this->entity->create($data);

        if($entity) {
            $newEntity = $this->findById($entity->id);

            return response()->json(['success' => true, 'entity' => $newEntity], 201);
        } else {
            return response()->json(['success' => false, 'error' => 'Erro ao inserir.'], 500);
        }
    }

    public function update($id, array $data)
    {
        $entity = $this->findById($id)->update($data);

        if($entity) {
            $updatedEntity = $this->findById($id);

            return response()->json(['success' => true, 'entity' => $updatedEntity]);
        } else {
            return response()->json(['success' => false, 'error' => 'Erro ao atualizar.'], 500);
        }
    }

    public function delete($id)
    {
        $entity = $this->findById($id)->delete();

        return response()->json($entity);
    }

    public function relationships(...$relationships)
    {
        $this->entity = $this->entity->with($relationships);

        return $this;
    }

    public function resolveEntity()
    {
        if(!method_exists($this, 'entity')) {
            throw new NotEntityDefined();
        }

        return app($this->entity());
    }
}
