<x-mail::message>
# Sveiki

Sistemoje {{ config('app.name') }} atsiėmėte prizą:
## {{ $prize->name }} <br />
{{ $prize->description }} <br />
### Kaina: {{ $prize->price }} taškų. <br />

# Kodas: {{ $prizeCode->code }} <br />

</x-mail::message>
