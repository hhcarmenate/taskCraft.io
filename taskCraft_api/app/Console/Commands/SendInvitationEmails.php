<?php

namespace App\Console\Commands;

use App\Models\Invitation;
use App\Models\User;
use App\Models\Workspace;
use App\Notifications\WorkspaceExternalInvitationNotification;
use App\Notifications\WorkspaceInternalInvitationNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendInvitationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'taskCraft:send-invitation-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send all the invitations links';

    /**
     * Execute the console command.
     * @throws \Throwable
     */
    public function handle(): int
    {
        $invitations = Invitation::query()
            ->where('sent', 0)
            ->get();

        if (!$invitations) {
            $this->fail('There is no Invitations');
        }

        $invitations->each(fn($invitation) => $this->processInvitation($invitation));
        $this->info('Invitations processed successfully!');
        return 0;
    }

    /**
     * Processes an invitation by checking if the invitee's email already exists in the system.
     *
     * @param Invitation $invitation The invitation to be processed.
     */
    private function processInvitation(Invitation $invitation)
    {
        $user = User::query()->where('email', $invitation->invitee_email)->first();
        if ($user) {
            $this->sendInternalInvitation($user, $invitation);
        } else {
            $this->sendExternalInvitation($invitation);
        }

    }

    /**
     * Sends an internal invitation to a user for a workspace.
     *
     * @param User $user The user to whom the invitation is being sent.
     * @param Invitation $invitation The invitation details including inviter, workspace, and invitee email.
     *
     * @return void
     */
    private function sendInternalInvitation(User $user, Invitation $invitation): void
    {
        $subject = 'Join workspace invitation!';
        $inviter = User::query()->find($invitation->inviter_id);
        $workspace = Workspace::query()->find($invitation->workspace_id);

        if ($inviter && $workspace) {
            Notification::route('mail', trim($invitation->invitee_email))
                ->notify(new WorkspaceInternalInvitationNotification(
                    $subject,
                    $invitation->invitation_text,
                    $inviter->name,
                    $user->name,
                    $workspace->name, // Todo: Change the following url with the workspace url.
                    config('app.ui_app_url').'/invitation-link?token=' . $invitation->token
                ));
        }
    }

    private function sendExternalInvitation(Invitation $invitation)
    {
        $inviter = User::query()->find($invitation->inviter_id);
        $subject = "TaskCraft.io workspace invitation!";
        $workspace = Workspace::query()->find($invitation->workspace_id);

        if ($inviter && $workspace) {
            Notification::route('mail', trim($invitation->invitee_email))
                ->notify(new WorkspaceExternalInvitationNotification(
                    $subject,
                    $invitation->invitation_text,
                    $inviter->name,
                    $workspace->name,
                    config('app.ui_app_url').'/invitation-link?token=' . $invitation->token
                ));
        }
    }
}
