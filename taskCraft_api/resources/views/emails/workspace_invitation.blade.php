@component('mail::message')
# Workspace Invitation

You have been invited to join the workspace

Here the details:
- **Invited by**: {{ $inviter }}
- **Workspace**: {{ $workspace }}

Owner Message:
- **Message**: *{{ $invitationText }}*

@component('mail::button', ['url' => $invitationUrl])
Join Workspace
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
