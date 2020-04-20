<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateMailboxFormRequest;
use App\Repositories\Contracts\MailboxRepositoryInterface;
use Illuminate\Http\Request;

class MailboxController extends Controller
{
    protected $mailboxRepository;

    public function __construct(MailboxRepositoryInterface $mailboxRepository)
    {
        $this->mailboxRepository = $mailboxRepository;
    }

    public function index()
    {
        $mailboxes = $this->mailboxRepository->all();

        return response()->json($mailboxes);
    }

    public function store(StoreUpdateMailboxFormRequest $request)
    {
        return $this->mailboxRepository->store($request->all());
    }

    public function show($id)
    {
        $mailbox = $this->mailboxRepository->findById($id);

        if (!$mailbox) {
            return response()->json(['success' => false, 'error' => 'Caixa de e-mail não encontrada.'], 404);
        }

        return response()->json($mailbox);
    }

    public function update(StoreUpdateMailboxFormRequest $request, $id)
    {
        $mailbox = $this->mailboxRepository->findById($id);

        if (!$mailbox) {
            return response()->json(['success' => false, 'error' => 'Caixa de e-mail não encontrada.'], 404);
        }

        return $this->mailboxRepository->update($id, $request->all());
    }

    public function destroy($id)
    {
        $mailbox = $this->mailboxRepository->findById($id);

        if (!$mailbox) {
            return response()->json(['success' => false, 'error' => 'Caixa de e-mail não encontrada.'], 404);
        }

        return $this->mailboxRepository->delete($id);
    }
}
