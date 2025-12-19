<?php

use App\Models\JobApplication;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('guests cannot export job applications', function () {
    get(route('job-applications.export'))
        ->assertRedirect(route('login'));
});

test('users can export job applications as csv', function () {
    $user = User::factory()->create();
    JobApplication::factory()->count(3)->create(['user_id' => $user->id]);

    actingAs($user)
        ->get(route('job-applications.export'))
        ->assertOk()
        ->assertHeader('content-type', 'text/csv; charset=utf-8')
        ->assertHeader('content-disposition', 'attachment; filename=job_applications_'.date('Y-m-d').'.csv');
});

test('export respects filters', function () {
    $user = User::factory()->create();

    // Create matching application
    $matching = JobApplication::factory()->create([
        'user_id' => $user->id,
        'company_name' => 'Target Company',
        'status' => 'applied',
    ]);

    // Create non-matching application
    $nonMatching = JobApplication::factory()->create([
        'user_id' => $user->id,
        'company_name' => 'Other Company',
        'status' => 'rejected',
    ]);

    $response = actingAs($user)
        ->get(route('job-applications.export', [
            'search' => 'Target',
            'status' => 'applied',
        ]));

    $response->assertOk();

    // Capture the streamed content to verify
    $content = $response->streamedContent();

    expect($content)->toContain('Target Company');
    expect($content)->not->toContain('Other Company');
});
