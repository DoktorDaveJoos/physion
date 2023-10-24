<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\TeamInvitation;
use Tests\TestCase;

class InviteTeamMemberTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function test_team_members_can_be_invited_to_team(): void
    {
        if (!Features::sendsTeamInvitations()) {
            $this->markTestSkipped('Team invitations not enabled.');

            return;
        }

        Mail::fake();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->post('/teams/'.$user->currentTeam->id.'/members', [
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        Mail::assertSent(\App\Mail\TeamInvitation::class);

        $this->assertCount(1, $user->currentTeam->fresh()->teamInvitations);
    }

    public function test_team_member_invitations_can_be_cancelled(): void
    {
        ray()->showRequests();
        if (!Features::sendsTeamInvitations()) {
            $this->markTestSkipped('Team invitations not enabled.');

            return;
        }

        Mail::fake();

        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $invitation = $user->currentTeam->teamInvitations()->create([
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        $this->delete(
            route('team-invitations.destroy', [
                'invitation' => $invitation->id,
            ])
        );

        $this->assertCount(0, $user->currentTeam->fresh()->teamInvitations);
    }
}
