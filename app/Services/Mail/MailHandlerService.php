<?php

namespace App\Services\Mail;

use App\Mail\Sender;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class MailHandlerService
{
    protected $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function run(array $data)
    {
        try {
            $contact = $this->contactRepository->findById($data['contact_id']);

            if (!$contact) {
                return response()->json(['success' => false, 'error' => 'Contato não encontrado.'], 404);
            }

            Mail::to($contact['email'])->send(new Sender($data['message']));

        } catch (Exception $e) {
            throw $e;
        }

    }
}
