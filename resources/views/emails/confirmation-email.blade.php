@component('mail::message')
# Email Confirmation

## Hello {{ $user->name }}!

To validate your email click on the button below

@component('mail::button', ['url' => $link])
Email Verification
@endcomponent

Thanks,<br>{{ config('app.name') }}</br>

@component('mail::panel', ['url' => ''])

If you’re having trouble clicking the "Email Verification" button, copy and paste the URL below into your web browser: <br/>
{{ $link }}
@endcomponent

@endcomponent
