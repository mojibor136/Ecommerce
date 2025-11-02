<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GmailSmtp;
use App\Models\Textlocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * Display the SMS/Gmail API page.
     */
    public function index()
    {
        $textlocal = Textlocal::first();
        $gmailSmtp = GmailSmtp::first();

        return view('backend.sms_email.index', compact('textlocal', 'gmailSmtp'));
    }

    /**
     * Store or update SMS/Gmail API settings.
     */
    public function store(Request $request)
    {
        if ($request->has('api_key') || $request->has('sender')) {
            // Textlocal SMS
            $validated = $request->validate([
                'api_key' => 'nullable|string',
                'sender' => 'nullable|string',
                'url' => 'nullable|url',
                'provider' => 'nullable|string',
            ]);

            try {
                Log::info('Textlocal Request:', $request->all());

                $textlocal = Textlocal::updateOrCreate(
                    ['provider' => $validated['provider'] ?? 'other'],
                    [
                        'api_key' => $validated['api_key'] ?? null,
                        'sender' => $validated['sender'] ?? null,
                        'url' => $validated['url'] ?? null,
                        'status' => $request->has('status') ? 1 : 0,
                    ]
                );

                Log::info('Textlocal Saved:', $textlocal->toArray());

                return back()->with('success', 'Textlocal SMS settings saved successfully!');
            } catch (\Exception $e) {
                Log::error('Textlocal Save Error: '.$e->getMessage());

                return back()->with('error', 'Something went wrong while saving Textlocal settings.');
            }
        }

        if ($request->has('email') || $request->has('host')) {
            // Gmail SMTP
            $validated = $request->validate([
                'email' => 'nullable|email',
                'password' => 'nullable|string',
                'host' => 'nullable|string',
                'port' => 'nullable|integer',
            ]);

            try {
                Log::info('Gmail SMTP Request:', $request->all());

                $gmail = GmailSmtp::updateOrCreate(
                    ['email' => $validated['email']],
                    [
                        'password' => $validated['password'] ?? null,
                        'host' => $validated['host'] ?? null,
                        'port' => $validated['port'] ?? null,
                        'status' => $request->has('status') ? 1 : 0,
                    ]
                );

                Log::info('Gmail SMTP Saved:', $gmail->toArray());

                return back()->with('success', 'Gmail SMTP settings saved successfully!');
            } catch (\Exception $e) {
                Log::error('Gmail SMTP Save Error: '.$e->getMessage());

                return back()->with('error', 'Something went wrong while saving Gmail SMTP settings.');
            }
        }

        return back()->with('error', 'No valid input found.');
    }
}
