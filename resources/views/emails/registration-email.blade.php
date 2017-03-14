@component('mail::message')
# Registration Confirmation

## Congratulations {{ $user->name }}!

You have joined our site and now have access to the following benefits:

* instant access
* 24/7 support
* updated daily content

@component('mail::button', ['url' => config('app.url')])
Visit Now
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@component('mail::panel', ['url' => ''])
You are receiving this email because you subscribed to Sample Project.
You may Unsubscribe by clicking <a href="{{ config('app.url') }}/unsubscribe">here</a>.
@endcomponent

@endcomponent

