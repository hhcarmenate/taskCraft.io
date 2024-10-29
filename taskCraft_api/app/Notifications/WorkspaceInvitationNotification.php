<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkspaceInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected string $subject;
    protected string $invitationText;
    protected string $inviter;
    protected string $workspace;
    protected string $invitationUrl;


    /**
     * Create a new notification instance.
     */
    public function __construct(string $subject, string $invitationText, string $inviter, string $workspace, string $invitationUrl)
    {
        $this->subject = $subject;
        $this->invitationText = $invitationText;
        $this->inviter = $inviter;
        $this->workspace = $workspace;
        $this->invitationUrl = $invitationUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->markdown('emails.workspace_invitation', [
                'inviter' => $this->inviter,
                'workspace' => $this->workspace,
                'invitationUrl' => $this->invitationUrl,
                'invitationText' => $this->invitationText
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
