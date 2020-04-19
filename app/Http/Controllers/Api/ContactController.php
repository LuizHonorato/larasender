<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateContactFormRequest;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    protected $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function index()
    {
        $contacts = $this->contactRepository->all();

        return response()->json($contacts);
    }

    public function search(Request $request)
    {
        return $this->contactRepository->search($request->all());
    }

    public function store(StoreUpdateContactFormRequest $request)
    {
        $data = $request->all();

        if($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
            $name = md5($request->name . time());
            $extension = $request->profile_pic->extension();

            $nameFile = "{$name}.{$extension}";
            $data['profile_pic'] = $nameFile;

            $upload = $request->profile_pic->storeAs('contacts', $nameFile);

            if(!$upload) {
                return response()->json(['success' => false, 'error' => 'Falha ao armazenar a imagem.'], 500);
            }
        }

        return $this->contactRepository->store($data);
    }

    public function show($id)
    {
        $contact = $this->contactRepository->findById($id);

        if (!$contact) {
            return response()->json(['success' => false, 'error' => 'Contato não encontrado.'], 404);
        }

        return response()->json($contact);
    }

    public function update(StoreUpdateContactFormRequest $request, $id)
    {
        $data = $request->all();

        $contact = $this->contactRepository->findById($id);

        if (!$contact) {
            return response()->json(['success' => false, 'error' => 'Contato não encontrado.'], 404);
        }

        if($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {

            if($contact->profile_pic) {
                if(Storage::exists("contacts/{$contact->profile_pic}")) {
                    Storage::delete("contacts/{$contact->profile_pic}");
                }
            }

            $name = md5($request->name . time());
            $extension = $request->profile_pic->extension();


            $nameFile = "{$name}.{$extension}";
            $data['profile_pic'] = $nameFile;
            $upload = $request->profile_pic->storeAs('contacts', $nameFile);

            if(!$upload) {
                return response()->json(['success' => false, 'error' => 'Falha ao armazenar a imagem.'], 500);
            }
        }

        return $this->contactRepository->update($id, $data);
    }

    public function destroy($id)
    {
        $contact = $this->contactRepository->findById($id);

        if (!$contact) {
            return response()->json(['success' => false, 'error' => 'Contato não encontrado.'], 404);
        }

        return $this->contactRepository->delete($id);
    }
}
