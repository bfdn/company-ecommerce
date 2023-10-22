Mail Queue Örneği

<hr>

Sayın {{ $user->name }}, hoşgeldiniz.

{{ route('front.verify-token', ['locale' => 'tr', 'token' => 'test-deneme']) }}
