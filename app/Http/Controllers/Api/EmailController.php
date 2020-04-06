<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEmailFormRequest;
use App\Repositories\Contracts\EmailRepositoryInterface;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    protected $emailRepository;

    public function __construct(EmailRepositoryInterface $emailRepository)
    {
        $this->emailRepository = $emailRepository;
    }

    public function index()
    {
        $emails = $this->emailRepository->all();

        return response()->json($emails);
    }

    public function store(StoreUpdateEmailFormRequest $request)
    {
        return $this->emailRepository->store($request->all());
    }

    public function show($id)
    {
        $email = $this->emailRepository->findById($id);

        if (!$email) {
            return response()->json(['success' => false, 'error' => 'E-mail não encontrado.'], 404);
        }

        return response()->json($email);
    }

    public function destroy($id)
    {
        $email = $this->emailRepository->findById($id);

        if (!$email) {
            return response()->json(['success' => false, 'error' => 'E-mail não encontrado.'], 404);
        }

        return $this->emailRepository->delete($id);
    }
}
