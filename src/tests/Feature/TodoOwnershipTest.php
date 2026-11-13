<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_only_see_their_own_todos(): void
    {
        $userOne = User::factory()->create();
        $userTwo = User::factory()->create();

        Todo::create([
            'task' => 'User one task',
            'user_id' => $userOne->id,
        ]);

        Todo::create([
            'task' => 'User two task',
            'user_id' => $userTwo->id,
        ]);

        $response = $this->actingAs($userOne)->get('/todos');
        $response->assertOk();
        $response->assertSee('User one task');
        $response->assertDontSee('User two task');

        $response = $this->actingAs($userTwo)->get('/todos');
        $response->assertOk();
        $response->assertSee('User two task');
        $response->assertDontSee('User one task');
    }

    public function test_edit_form_uses_patch_method_for_todo_update(): void
    {
        $user = User::factory()->create();
        $todo = Todo::create([
            'task' => 'Sample task',
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get("/todos/{$todo->id}/edit");

        $response->assertOk();
        $response->assertSee('_method', false);
        $response->assertSee('PATCH', false);
        $response->assertDontSee('PUT', false);
    }
}
