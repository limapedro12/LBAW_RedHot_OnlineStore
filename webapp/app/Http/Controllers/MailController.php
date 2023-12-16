<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Mail\MailModel;
use App\Models\NotificationMailModel;
use TransportException;
use Exception;
use App\Models\User;

class MailController extends Controller
{
    function send(Request $request)
    {
        $missingVariables = [];
        $requiredEnvVariables = [
            'MAIL_MAILER',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME',
        ];

        foreach ($requiredEnvVariables as $envVar) {
            if (empty(env($envVar))) {
                $missingVariables[] = $envVar;
            }
        }

        $user = User::where('email', '=', $request->email)->first();

        if ($user != null) {

            $token = bin2hex(random_bytes(32));

            $user->validTokens[$user->id] = $token;

            session(['validTokens' => $user->validTokens]);

            if (empty($missingVariables)) {

                $mailData = [
                    'id' => $user->id,
                    'name' => $user->nome,
                    'email' => $request->email,
                    'token' => $token
                ];

                try {
                    Mail::to($request->email)->send(new MailModel($mailData));
                    $message = 'Foi enviado um email de recuperação para ' . $request->email;
                } catch (TransportException $e) {
                    $message = 'SMTP connection error occurred during the email sending process to ' . $request->email;
                } catch (Exception $e) {
                    $message = 'An unhandled exception occurred during the email sending process to ' . $request->email;
                    \Log::error($e->getMessage());
                }
            } else {
                $message = 'The SMTP server cannot be reached due to missing environment variables:';
            }

            $request->session()->flash('message', $message);
            $request->session()->flash('details', $missingVariables);
        } else {
            $texto = 'Este email é invalido ou não está associado a nenhuma conta de utilizador na plataforma da RedHot';
            $request->session()->flash('message', $texto);
        }

        return redirect()->route('forgetPassword');
    }

    public static function sendNotificationEmail(bool $isAdmin, string $message, $receiver){
        $missingVariables = [];
        $requiredEnvVariables = [
            'MAIL_MAILER',
            'MAIL_HOST',
            'MAIL_PORT',
            'MAIL_USERNAME',
            'MAIL_PASSWORD',
            'MAIL_ENCRYPTION',
            'MAIL_FROM_ADDRESS',
            'MAIL_FROM_NAME',
        ];

        foreach ($requiredEnvVariables as $envVar) {
            if (empty(env($envVar))) {
                $missingVariables[] = $envVar;
            }
        }

        if ($receiver != null) {
            if (empty($missingVariables)) {
                $url = $isAdmin ? '/admin/' . $receiver->id . '/notifications' : 
                                '/users/' . $receiver->id . '/notifications';
                $mailData = [
                    'url' => $url,
                    'name' => $receiver->nome,
                    'message' => $message,
                    'email' => $receiver->email
                ];

                try {
                    Mail::to($request->email)->send(new NotificationMailModel($mailData));
                    $message = $notification->message;
                } catch (TransportException $e) {
                    $message = 'SMTP connection error occurred during the email sending process to ' . $request->email;
                } catch (Exception $e) {
                    $message = 'An unhandled exception occurred during the email sending process to ' . $request->email;
                    \Log::error($e->getMessage());
                }
            } else {
                $message = 'The SMTP server cannot be reached due to missing environment variables:';
            }

            $request->session()->flash('message', $message);
            $request->session()->flash('details', $missingVariables);
        } else {
            $texto = 'Este email é invalido ou não está associado a nenhuma conta de utilizador na plataforma da RedHot';
            $request->session()->flash('message', $texto);
        }
    }
}
