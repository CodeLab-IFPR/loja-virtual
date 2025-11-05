<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContatoRequest;
use App\Models\Contato;
use App\Mail\NovoContatoAtendimento;
use App\Mail\ConfirmacaoContato;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Exception;

class ContatoController extends Controller
{
    public function index()
    {
        return view('contato.index');
    }

    public function store(ContatoRequest $request): JsonResponse
    {
        try {
            $contato = Contato::create($request->validated());

            try {
                Mail::to(config('mail.atendimento_email'))
                    ->send(new NovoContatoAtendimento($contato));
            } catch (Exception $e) {
                Log::error('Erro ao enviar e-mail de notificação ao atendimento', [
                    'error' => $e->getMessage(),
                    'contato_id' => $contato->id,
                ]);
            }

            try {
                Mail::to($contato->email)
                    ->send(new ConfirmacaoContato($contato));
            } catch (Exception $e) {
                Log::error('Erro ao enviar e-mail de confirmação ao remetente', [
                    'error' => $e->getMessage(),
                    'contato_id' => $contato->id,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Sua mensagem foi enviada com sucesso! Em breve entraremos em contato.',
                'data' => [
                    'id' => $contato->id,
                ]
            ], 201);

        } catch (Exception $e) {
            Log::error('Erro ao processar contato', [
                'error' => $e->getMessage(),
                'data' => $request->validated(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao processar sua mensagem. Por favor, tente novamente.',
            ], 500);
        }
    }
}