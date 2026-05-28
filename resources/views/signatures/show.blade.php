<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signature mail {{ $signature->full_name }} | Normes Rénovation</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Barlow:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .signature-preview-stage {
            position: relative;
            display: block;
            max-width: 100%;
            margin: 0 auto;
            overflow: hidden;
        }

        .signature-preview-scale {
            position: absolute;
            top: 0;
            left: 0;
            width: 660px;
            transform-origin: top left;
        }

        .signature-preview-scale .nr-signature-wrap {
            width: 660px !important;
            max-width: none !important;
        }
    </style>
</head>
<body style="margin:0;background:#f0f2f5;font-family:'Barlow',Arial,Helvetica,sans-serif;overflow-x:hidden;">
    <table cellpadding="0" cellspacing="0" border="0" style="width:100%;border-collapse:collapse;">
        <tr>
            <td align="center" style="padding:40px 20px;">
                <table cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:1040px;border-collapse:collapse;">
                    <tr>
                        <td style="padding:0 0 18px 0;text-align:center;font-size:14px;line-height:22px;color:#506070;">
                            Signature email de <strong>{{ $signature->full_name }}</strong> pour Normes Rénovation.
                            <div style="margin-top:14px;">
                                <a href="{{ route('email_signatures.download', $signature->slug) }}" style="display:inline-block;border-radius:12px;background:#0f172a;padding:10px 18px;font-size:13px;font-weight:700;line-height:1;color:#ffffff;text-decoration:none;">
                                    Télécharger le fichier HTML
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <div id="signature-preview-stage" class="signature-preview-stage">
                                <div id="signature-preview-scale" class="signature-preview-scale">
                                    {!! $signatureHtml !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <script>
        (() => {
            const stage = document.getElementById('signature-preview-stage');
            const scaleNode = document.getElementById('signature-preview-scale');
            if (!stage || !scaleNode) {
                return;
            }

            const fitSignature = () => {
                const baseWidth = 660;

                scaleNode.style.transform = 'none';
                scaleNode.style.width = `${baseWidth}px`;
                stage.style.width = 'auto';
                stage.style.height = 'auto';

                const table = scaleNode.querySelector('.nr-signature-wrap');
                if (!table) {
                    return;
                }

                const baseHeight = table.offsetHeight;
                const parentWidth = stage.parentElement
                    ? stage.parentElement.getBoundingClientRect().width
                    : window.innerWidth;
                const availableWidth = Math.max(280, Math.min(parentWidth, window.innerWidth) - 4);
                const scale = Math.min(1, availableWidth / baseWidth);

                scaleNode.style.transform = `scale(${scale})`;
                stage.style.width = `${Math.round(baseWidth * scale)}px`;
                stage.style.height = `${Math.round(baseHeight * scale)}px`;
            };

            window.addEventListener('resize', fitSignature);
            window.addEventListener('load', fitSignature);
            if (document.fonts?.ready) {
                document.fonts.ready.then(fitSignature);
            } else {
                setTimeout(fitSignature, 300);
            }
        })();
    </script>
</body>
</html>
