@component('mail::message')
# Forgot Password

Hello {{ $user->name }},

We received a request to reset your password. Click the button below to reset it:

@component('mail::button', ['url' => url('/reset-password/'.$user->remember_token)])
Reset Password
@endcomponent

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
