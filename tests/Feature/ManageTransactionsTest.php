<?php

namespace Tests\Feature;

use App\Account;
use App\Transaction;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;

class ManageAccountsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guest_users_cannot_manage_accounts()
    {
        $transaction = factory(Transaction::class)->raw();
        factory(Account::class)->create();

        $this->get("/api/accounts")
            ->assertRedirect('login');

        $this->post('/api/transactions', $transaction)
            ->assertRedirect('login');
    }
    
    /** @test */
    public function a_user_can_make_a_trasaction()
    {
        $account = factory(Account::class)->create();
        $this->actingAs($account->user);

        $transaction = [
            'number' => $account->number,
            'amount' => $this->faker->numberBetween(1, 5000),
            'description' => $this->faker->randomElement(['deposit', 'withdraw']),
        ];

        $this->post('/api/transactions', $transaction)
            ->assertJson(['message' => 'Transaction saved.'])
            ->assertStatus(201);
    }

    /** @test */
    public function a_user_can_view_their_account_details()
    {
        $account = factory(Account::class)->create();
        $this->actingAs($account->user);

        $this->get('api/accounts')
            ->assertOk();
    }
    
}
