@php($spamShield = \App\Support\FormSpamGuard::payload($form))

<input type="hidden" name="{{ $spamShield['timestamp_field'] }}" value="{{ $spamShield['timestamp'] }}">
<input type="hidden" name="{{ $spamShield['signature_field'] }}" value="{{ $spamShield['signature'] }}">
<div aria-hidden="true" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">
    <label for="{{ $form }}-website">Site web</label>
    <input
        id="{{ $form }}-website"
        type="text"
        name="{{ $spamShield['honeypot_field'] }}"
        value=""
        tabindex="-1"
        autocomplete="off"
    >
</div>
