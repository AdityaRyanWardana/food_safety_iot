<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ContaminationLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContaminationLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_delete_an_individual_contamination_log()
    {
        $user = User::factory()->create();
        
        $log = ContaminationLog::create([
            'type' => 'Anomali Suhu',
            'severity' => 'sedang',
            'status' => 'terdeteksi',
            'detected_at' => now(),
        ]);

        $this->assertDatabaseHas('contamination_logs', [
            'id' => $log->id,
        ]);

        $response = $this->actingAs($user)
            ->delete(route('admin.contamination.destroy', $log));

        $response->assertRedirect(route('admin.contamination.index'));
        $response->assertSessionHas('success', 'Log kontaminasi berhasil dihapus.');

        $this->assertDatabaseMissing('contamination_logs', [
            'id' => $log->id,
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_contamination_log()
    {
        $log = ContaminationLog::create([
            'type' => 'Anomali Suhu',
            'severity' => 'sedang',
            'status' => 'terdeteksi',
            'detected_at' => now(),
        ]);

        $response = $this->delete(route('admin.contamination.destroy', $log));

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('contamination_logs', [
            'id' => $log->id,
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_clear_all_contamination_logs()
    {
        $user = User::factory()->create();

        ContaminationLog::create([
            'type' => 'Anomali Suhu',
            'severity' => 'sedang',
            'status' => 'terdeteksi',
            'detected_at' => now(),
        ]);

        ContaminationLog::create([
            'type' => 'Anomali Kelembapan',
            'severity' => 'tinggi',
            'status' => 'investigasi',
            'detected_at' => now(),
        ]);

        $this->assertCount(2, ContaminationLog::all());

        $response = $this->actingAs($user)
            ->delete(route('admin.contamination.clear'));

        $response->assertRedirect(route('admin.contamination.index'));
        $response->assertSessionHas('success', 'Seluruh riwayat log kontaminasi berhasil dihapus.');

        $this->assertCount(0, ContaminationLog::all());
    }
}
