<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Laravel\Jetstream\TeamInvitation as TeamInvitationModel;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public TeamInvitationModel $invitation;

    /**
     * Create a new message instance.
     *
     * @param  TeamInvitationModel  $invitation
     * @return void
     */
    public function __construct(TeamInvitationModel $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this->markdown('emails.team-invitation', [
            'acceptUrl' => URL::signedRoute('team-invitations.accept', [
                'invitation' => $this->invitation,
            ]),
        ])->subject(__('Team Einladung'));
    }
}
