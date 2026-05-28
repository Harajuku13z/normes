<table cellpadding="0" cellspacing="0" border="0" width="660" class="nr-signature-wrap" style="width:100%;font-family:'Barlow',Arial,sans-serif;background:#ffffff;border:0;border-collapse:collapse;outline:none;text-decoration:none;max-width:660px;mso-table-lspace:0pt;mso-table-rspace:0pt;">
  <tr>
    <td class="nr-top-pad" style="padding:24px 28px 20px 24px;">
      <table cellpadding="0" cellspacing="0" border="0" width="100%" class="nr-fluid">
        <tr>
          <td width="150" valign="top" class="nr-photo-cell" style="padding-right:26px;">
            @if ($photoUrl !== '')
              <img src="{{ $photoUrl }}" alt="{{ $photoAlt }}" width="140" height="172" class="nr-photo" style="display:block;object-fit:cover;border-radius:6px;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;">
            @else
              <table cellpadding="0" cellspacing="0" border="0" class="nr-photo" style="width:140px;height:172px;border-collapse:collapse;background:#0d2540;border-radius:6px;">
                <tr>
                  <td align="center" valign="middle" style="font-family:'Anton',Impact,sans-serif;font-size:46px;line-height:46px;color:#ffffff;">
                    {{ $initials }}
                  </td>
                </tr>
              </table>
            @endif
          </td>

          <td valign="middle" class="nr-info-cell">
            <div class="nr-name" style="font-family:'Anton',Impact,sans-serif;font-size:42px;line-height:1;margin-bottom:8px;letter-spacing:1px;text-transform:uppercase;">
              <span style="color:#0d2540;">{{ $nameLeading }}@if ($nameAccent !== '')&nbsp;@endif</span><span style="color:#1b9dd9;">{{ $nameAccent }}</span>
            </div>

            <div class="nr-role" style="font-size:12.5px;font-weight:700;color:#0d2540;letter-spacing:2px;text-transform:uppercase;margin-bottom:20px;">
              {{ $roleTitle }} | {{ $companyName }}.
            </div>

            @if ($phone !== '')
              <table cellpadding="0" cellspacing="0" border="0" class="nr-contact-wrap" style="margin-bottom:12px;">
                <tr>
                  <td width="34" height="34" class="nr-contact-icon" style="width:34px;height:34px;border-radius:17px;background:#1b9dd9;text-align:center;vertical-align:middle;line-height:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15" height="15" fill="#ffffff" class="nr-contact-glyph" style="display:block;margin:9px auto;">
                      <path d="M347.1 349.2c-20.8-10.3-44.8-8.1-63.2 6.2l-24.8 19.1c-51.8-27.6-93.8-69.6-121.4-121.4l19.1-24.8c14.3-18.4 16.5-42.4 6.2-63.2L131.3 100c-11.2-22.7-35.5-35.8-60.6-32.8L26.1 72.7C10.9 74.8 0 88 0 103.3 0 322.7 189.3 512 408.7 512c15.3 0 28.5-10.9 30.6-26.1l5.5-44.6c3.1-25.1-10-49.4-32.8-60.6l-64.9-31.5z"/>
                    </svg>
                  </td>
                  <td class="nr-contact-text" style="padding-left:12px;font-size:14px;font-weight:700;color:#0d2540;letter-spacing:0.3px;vertical-align:middle;">
                    <a href="{{ $phoneHref }}" style="color:#0d2540;text-decoration:none;">{{ $phone }}</a>
                  </td>
                </tr>
              </table>
            @endif

            @if ($email !== '')
              <table cellpadding="0" cellspacing="0" border="0" class="nr-contact-wrap">
                <tr>
                  <td width="34" height="34" class="nr-contact-icon" style="width:34px;height:34px;border-radius:17px;background:#1b9dd9;text-align:center;vertical-align:middle;line-height:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="15" height="15" fill="#ffffff" class="nr-contact-glyph" style="display:block;margin:9px auto;">
                      <path d="M502.3 190.8 327.4 338c-15.2 12.8-37.6 12.8-52.8 0L9.7 190.8C3.7 185.7 0 178.2 0 170.3V112c0-26.5 21.5-48 48-48h416c26.5 0 48 21.5 48 48v58.3c0 7.9-3.7 15.4-9.7 20.5zM0 214.7v185.3c0 26.5 21.5 48 48 48h416c26.5 0 48-21.5 48-48V214.7L358.2 344.1c-29.8 25.1-73 25.1-102.8 0L0 214.7z"/>
                    </svg>
                  </td>
                  <td class="nr-contact-text" style="padding-left:12px;font-size:14px;font-weight:700;color:#0d2540;letter-spacing:0.3px;vertical-align:middle;">
                    <a href="{{ $emailHref }}" style="color:#0d2540;text-decoration:none;">{{ $email }}</a>
                  </td>
                </tr>
              </table>
            @endif

          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td height="3" bgcolor="#1b9dd9" style="font-size:0;line-height:0;">&nbsp;</td>
  </tr>

  <tr>
    <td class="nr-bottom-pad" style="padding:16px 28px 16px 24px;">
      <table cellpadding="0" cellspacing="0" border="0" width="100%" class="nr-fluid">
        <tr valign="middle">
          <td valign="middle" class="nr-logo-cell" style="padding-right:20px;">
            <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}" height="64" class="nr-logo" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;">
          </td>

          <td valign="middle" class="nr-rge-cell" style="padding-right:12px;">
            <img src="{{ $rgeUrl }}" alt="{{ $rgeAlt }}" height="70" class="nr-rge" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;">
          </td>

          <td width="100%" class="nr-spacer-cell"></td>

          <td valign="middle" align="right" class="nr-social-cell">
            <table cellpadding="0" cellspacing="0" border="0" class="nr-social-wrap">
              <tr>
                @foreach ($socialItems as $index => $item)
                  <td @if ($index < count($socialItems) - 1) class="nr-social-gap" style="padding-right:8px;" @endif>
                    <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $item['label'] }}" style="text-decoration:none;">
                      <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td width="34" height="34" bgcolor="#1b9dd9" class="nr-social-icon" style="width:34px;height:34px;border-radius:17px;text-align:center;vertical-align:middle;line-height:0;">
                            @if ($item['network'] === 'facebook')
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="15" height="15" fill="#ffffff" class="nr-social-glyph" style="display:block;margin:9px auto;">
                                <path d="M279.14 288l14.22-92.66h-88.91V135.1c0-25.35 12.42-50.06 52.24-50.06H297V6.26S260.43 0 225.36 0C152.97 0 105.62 43.89 105.62 123.72v71.62H22.89V288h82.73v224h98.83V288z"/>
                              </svg>
                            @elseif ($item['network'] === 'instagram')
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15" height="15" fill="#ffffff" class="nr-social-glyph" style="display:block;margin:9px auto;">
                                <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.3 0-74.7-33.4-74.7-74.7s33.4-74.7 74.7-74.7 74.7 33.4 74.7 74.7-33.4 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.9-26.9 26.9-14.9 0-26.9-12-26.9-26.9 0-14.9 12-26.9 26.9-26.9 14.8 0 26.9 12 26.9 26.9zm76.1 27.2c-1.7-35.3-9.8-66.7-35.7-92.6S354.1 26.2 318.8 24.5c-35.5-2-141.9-2-177.4 0-35.3 1.7-66.7 9.8-92.6 35.7S26.2 157.9 24.5 193.2c-2 35.5-2 141.9 0 177.4 1.7 35.3 9.8 66.7 35.7 92.6s57.3 34 92.6 35.7c35.5 2 141.9 2 177.4 0 35.3-1.7 66.7-9.8 92.6-35.7s34-57.3 35.7-92.6c2-35.5 2-141.8 0-177.4zm-48.2 215.4c-7.7 19.4-22.7 34.4-42.1 42.1-29.1 11.5-98.1 8.8-130.3 8.8s-101.4 2.6-130.3-8.8c-19.4-7.7-34.4-22.7-42.1-42.1-11.5-29.1-8.8-98.1-8.8-130.3s-2.6-101.4 8.8-130.3c7.7-19.4 22.7-34.4 42.1-42.1 29.1-11.5 98.1-8.8 130.3-8.8s101.4-2.6 130.3 8.8c19.4 7.7 34.4 22.7 42.1 42.1 11.5 29.1 8.8 98.1 8.8 130.3s2.7 101.2-8.8 130.3z"/>
                              </svg>
                            @else
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15" height="15" fill="#ffffff" class="nr-social-glyph" style="display:block;margin:9px auto;">
                                <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8A53.79 53.79 0 0 1 53.79 0c29.8 0 53.79 24.6 53.79 53.8 0 29.7-24 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.7-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/>
                              </svg>
                            @endif
                          </td>
                        </tr>
                      </table>
                    </a>
                  </td>
                @endforeach
              </tr>
              <tr>
                <td colspan="{{ max(count($socialItems), 1) }}" align="center" class="nr-website-cell" style="padding-top:8px;">
                  <a href="{{ $websiteUrl }}" target="_blank" rel="noopener noreferrer" class="nr-website-link" style="font-family:'Anton',Impact,sans-serif;font-size:12px;letter-spacing:2px;color:#0d2540;text-decoration:none;font-weight:400;">
                    {{ mb_strtoupper($websiteLabel) }}
                  </a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr>
    <td class="nr-legal" style="background:#f5f7f9;border-top:1px solid #d0d8e4;padding:10px 24px;">
      <p style="font-size:9.5px;color:#5d6c7d;line-height:1.5;margin:0 0 8px 0;letter-spacing:0.15px;text-align:center;">
        <strong style="color:#0d2540;font-weight:700;">Chalon-sur-Saône</strong>
        ·
        <a href="{{ $agencyPhoneHref }}" style="color:#0d2540;text-decoration:none;font-weight:700;">{{ $agencyPhone }}</a>
        ·
        {{ $footerAddress }}
      </p>
      <p style="font-size:9px;color:#8a97a6;line-height:1.55;margin:0;letter-spacing:0.1px;">
        Ce message et ses pièces jointes sont confidentiels et destinés exclusivement à son destinataire. Si vous n'êtes pas le destinataire prévu, merci de le signaler à l'expéditeur et de détruire ce message. Toute divulgation, copie ou distribution non autorisée est interdite. Normes Rénovation SAS — Siège : {{ $footerAddress }} — {{ $footerLegal }}. Certifié RGE – Reconnu Garant de l'Environnement.
      </p>
    </td>
  </tr>
</table>
