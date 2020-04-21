<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEmailFormRequest;
use App\Repositories\Contracts\EmailRepositoryInterface;
use App\Services\Mail\MailHandlerService;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    protected $emailRepository;
    protected $mailHandlerService;

    public function __construct(EmailRepositoryInterface $emailRepository, MailHandlerService $mailHandlerService)
    {
        $this->emailRepository = $emailRepository;
        $this->mailHandlerService = $mailHandlerService;
    }

    public function sendEmail(StoreUpdateEmailFormRequest $request)
    {
        $send = $this->mailHandlerService->run($request->all());

        if($send) {
            return $this->emailRepository->store($request->all());
        } else {
            return response()->json(['success' => false, 'error' => 'Erro ao enviar o e-mail']);
        }
    }

    public function index()
    {
        $emails = $this->emailRepository->all();

        return response()->json($emails);
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
