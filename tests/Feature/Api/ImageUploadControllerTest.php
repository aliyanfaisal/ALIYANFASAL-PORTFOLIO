<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadControllerTest extends TestCase
{
    private const PNG_BASE64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.blog_api.token' => 'test-token']);
        Storage::fake('public');
    }

    private function headers(): array
    {
        return ['Authorization' => 'Bearer test-token'];
    }

    public function test_it_rejects_requests_without_a_valid_token(): void
    {
        $payload = ['image_base64' => self::PNG_BASE64, 'filename' => 'a.png'];

        $this->postJson('/api/upload-image', $payload)->assertStatus(401);
        $this->postJson('/api/upload-image', $payload, ['Authorization' => 'Bearer wrong-token'])->assertStatus(401);
    }

    public function test_it_validates_required_fields(): void
    {
        $this->postJson('/api/upload-image', [], $this->headers())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['image_base64', 'filename']);
    }

    public function test_it_stores_the_image_and_returns_a_public_url(): void
    {
        $this->postJson('/api/upload-image', [
            'image_base64' => self::PNG_BASE64,
            'filename' => 'linkedin-2026-09-19-1.png',
        ], $this->headers())
            ->assertStatus(201)
            ->assertJson([
                'status' => 'uploaded',
                'url' => asset('storage/generated/linkedin-2026-09-19-1.png'),
                'filename' => 'linkedin-2026-09-19-1.png',
            ]);

        Storage::disk('public')->assertExists('generated/linkedin-2026-09-19-1.png');
        $this->assertSame(base64_decode(self::PNG_BASE64), Storage::disk('public')->get('generated/linkedin-2026-09-19-1.png'));
    }

    public function test_it_appends_a_suffix_instead_of_overwriting_existing_files(): void
    {
        $payload = ['image_base64' => self::PNG_BASE64, 'filename' => 'dupe.png'];

        $this->postJson('/api/upload-image', $payload, $this->headers())->assertJson(['filename' => 'dupe.png']);
        $this->postJson('/api/upload-image', $payload, $this->headers())->assertJson(['filename' => 'dupe-2.png']);
        $this->postJson('/api/upload-image', $payload, $this->headers())->assertJson(['filename' => 'dupe-3.png']);

        Storage::disk('public')->assertExists(['generated/dupe.png', 'generated/dupe-2.png', 'generated/dupe-3.png']);
    }

    public function test_it_sanitizes_the_filename_and_strips_path_traversal(): void
    {
        $this->postJson('/api/upload-image', [
            'image_base64' => self::PNG_BASE64,
            'filename' => '../../etc/pass wd!.png',
        ], $this->headers())
            ->assertStatus(201)
            ->assertJson(['filename' => 'passwd.png']);

        Storage::disk('public')->assertExists('generated/passwd.png');
    }

    public function test_it_derives_the_extension_from_the_detected_image_type(): void
    {
        $this->postJson('/api/upload-image', [
            'image_base64' => self::PNG_BASE64,
            'filename' => 'shell.php',
        ], $this->headers())
            ->assertStatus(201)
            ->assertJson(['filename' => 'shell.png']);
    }

    public function test_it_rejects_a_filename_with_nothing_usable_in_it(): void
    {
        $this->postJson('/api/upload-image', [
            'image_base64' => self::PNG_BASE64,
            'filename' => '../..//!!!',
        ], $this->headers())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['filename']);
    }

    public function test_it_rejects_invalid_base64(): void
    {
        $this->postJson('/api/upload-image', [
            'image_base64' => 'not*valid*base64!!',
            'filename' => 'a.png',
        ], $this->headers())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['image_base64']);
    }

    public function test_it_rejects_content_that_is_not_an_image(): void
    {
        $this->postJson('/api/upload-image', [
            'image_base64' => base64_encode('<?php echo "hi";'),
            'filename' => 'a.png',
        ], $this->headers())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['image_base64']);

        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_it_rejects_images_larger_than_15mb(): void
    {
        ini_set('memory_limit', '512M');

        $oversized = base64_decode(self::PNG_BASE64).str_repeat("\0", 15 * 1024 * 1024);

        $this->postJson('/api/upload-image', [
            'image_base64' => base64_encode($oversized),
            'filename' => 'big.png',
        ], $this->headers())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['image_base64']);
    }
}
