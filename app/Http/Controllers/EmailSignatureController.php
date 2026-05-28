<?php

namespace App\Http\Controllers;

use App\Models\EmailSignature;
use App\Support\EmailSignaturePresenter;
use Illuminate\Http\Response;
use Illuminate\View\View;

class EmailSignatureController extends Controller
{
    public function show(EmailSignature $emailSignature): View
    {
        abort_unless($emailSignature->is_active, 404);

        return view('signatures.show', [
            'signature' => $emailSignature,
            'signatureHtml' => EmailSignaturePresenter::renderHtml($emailSignature),
        ]);
    }

    public function html(EmailSignature $emailSignature): Response
    {
        abort_unless($emailSignature->is_active, 404);

        return response(EmailSignaturePresenter::renderHtml($emailSignature), 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }

    public function download(EmailSignature $emailSignature): Response
    {
        abort_unless($emailSignature->is_active, 404);

        $filename = 'signature-mail-'.$emailSignature->slug.'.html';
        $html = "\xEF\xBB\xBF".EmailSignaturePresenter::renderDocumentHtml($emailSignature);

        return response($html, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
