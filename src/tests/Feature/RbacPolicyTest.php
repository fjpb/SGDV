<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentAuditLog;
use App\Models\Setting;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class RbacPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_rbac_policy_matrix(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'active' => true]);
        $supervisor = User::factory()->create(['role' => 'supervisor', 'active' => true]);
        $user = User::factory()->create(['role' => 'user', 'active' => true]);
        $inactive = User::factory()->create(['role' => 'user', 'active' => false]);

        $ownVehicle = new Vehicle(['user_id' => $user->id]);
        $otherVehicle = new Vehicle(['user_id' => $admin->id]);

        $this->assertTrue(Gate::forUser($admin)->allows('viewAny', User::class));
        $this->assertTrue(Gate::forUser($admin)->allows('viewAny', Setting::class));
        $this->assertTrue(Gate::forUser($supervisor)->allows('viewReports', Document::class));
        $this->assertTrue(Gate::forUser($supervisor)->allows('viewAny', DocumentAuditLog::class));
        $this->assertTrue(Gate::forUser($user)->allows('view', $ownVehicle));
        $this->assertFalse(Gate::forUser($user)->allows('view', $otherVehicle));
        $this->assertFalse(Gate::forUser($inactive)->allows('viewAny', Vehicle::class));
    }
}
