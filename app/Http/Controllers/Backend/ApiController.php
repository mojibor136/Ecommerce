<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GmailSmtp;
use App\Models\Textlocal;
use Illuminate\Http\Request;

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
        // -------------------------
        // TEXTLOCAL SMS
        // -------------------------
        if ($request->has('api_key') || $request->has('sender')) {

            $validated = $request->validate([
                'api_key' => 'nullable|string',
                'sender' => 'nullable|string',
                'url' => 'nullable|url',
                'provider' => 'required|string',
            ]);

            try {

                $textlocal = Textlocal::updateOrCreate(
                    ['id' => $request->textlocal_id],
                    [
                        'api_key' => $request->api_key,
                        'sender' => $request->sender,
                        'url' => $request->url,
                        'provider' => $request->provider,
                        'status' => $request->has('textlocal_status') ? 1 : 0,
                    ]
                );

                return back()->with('success', 'Textlocal SMS settings updated!');
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        // -------------------------
        // GMAIL SMTP
        // -------------------------
        if ($request->has('email') || $request->has('host')) {

            $validated = $request->validate([
                'email' => 'required|email',
                'password' => 'nullable|string',
                'host' => 'nullable|string',
                'encryption' => 'nullable|string',
                'port' => 'nullable|integer',
            ]);

            try {

                $gmail = GmailSmtp::updateOrCreate(
                    ['id' => $request->gmail_id],
                    [
                        'email' => $request->email,
                        'password' => $request->password,
                        'host' => $request->host,
                        'port' => $request->port,
                        'encryption' => $request->encryption,
                        'status' => $request->has('gmail_status') ? 1 : 0,
                    ]
                );

                return back()->with('success', 'Gmail SMTP settings updated!');
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        return back()->with('error', 'Invalid request.');
    }
}
