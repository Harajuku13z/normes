<x-mail::message>
# Candidature franchise

**Nom :** {{ $inquiry->name }}

**Téléphone :** {{ $inquiry->phone }}

**E-mail :** {{ $inquiry->email }}

**Code postal :** {{ $inquiry->postal_code }}

**Activité en indépendant :** {{ $inquiry->has_independent_activity ? 'Oui' : 'Non' }}

**Secteur géographique souhaité :** {{ $inquiry->geographic_sector }}

@if (filled($inquiry->personal_contribution))
**Apport personnel (indication) :** {{ $inquiry->personal_contribution }}
@endif

@if (filled($inquiry->message))
**Message :**

{{ $inquiry->message }}
@endif

---

ID dossier : #{{ $inquiry->id }}

</x-mail::message>
