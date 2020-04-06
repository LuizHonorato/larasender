<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateUserFormRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();

        return response()->json($users);
    }

    public function store(StoreUpdateUserFormRequest $request)
    {
        return $this->userRepository->store($request->all());
    }

    public function show($id)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Usuário não encontrado.'], 404);
        }

        return response()->json($user);
    }

    public function update(StoreUpdateUserFormRequest $request, $id)
    {
        $data = $request->all();

        $user = $this->userRepository->findById($id);

        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Usuário não encontrado.'], 404);
        }

        if($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {

            if($user->profile_pic) {
                if(Storage::exists("users/{$user->profile_pic}")) {
                    Storage::delete("users/{$user->profile_pic}");
                }
            }

            $name = md5($request->name . time());
            $extension = $request->profile_pic->extension();


            $nameFile = "{$name}.{$extension}";
            $data['profile_pic'] = $nameFile;
            $upload = $request->profile_pic->storeAs('users', $nameFile);

            if(!$upload) {
                return response()->json(['success' => false, 'error' => 'Falha ao armazenar a imagem.'], 500);
            }
        }

        return $this->userRepository->update($id, $data);
    }

    public function destroy($id)
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            return response()->json(['success' => false, 'error' => 'Usuário não encontrado.'], 404);
        }

        return $this->userRepository->delete($id);
    }

}
