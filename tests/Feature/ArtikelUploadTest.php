<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArtikelUploadTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        foreach (['admin' => 'Admin', 'petugas' => 'Petugas', 'masyarakat' => 'Masyarakat'] as $n => $d) {
            Role::create(['name' => $n, 'display_name' => $d]);
        }
        $this->admin = User::create([
            'role_id' => 1, 'nama_lengkap' => 'Admin', 'username' => 'admin',
            'email' => 'a@a.test', 'password' => bcrypt('secret1'),
        ]);
    }

    private function sebagaiAdmin()
    {
        return $this->withSession(['is_login' => true, 'role' => 'admin', 'user_id' => $this->admin->id, 'nama' => 'Admin']);
    }

    private function data(array $o = []): array
    {
        return array_merge([
            'judul' => 'Cara Memilah Sampah', 'kategori' => 'pemilahan', 'konten' => 'Isi artikel',
            'is_published' => 1, 'thumbnail' => UploadedFile::fake()->image('a.jpg', 800, 500)->size(300),
        ], $o);
    }

    public function test_halaman_kelola_wajib_login_dan_admin(): void
    {
        $this->get('/admin/artikel')->assertRedirect('/login');
        $this->withSession(['is_login' => true, 'role' => 'masyarakat'])->get('/admin/artikel')->assertForbidden();
        $this->sebagaiAdmin()->get('/admin/artikel')->assertOk();
    }

    public function test_create_menyimpan_file_dan_path(): void
    {
        $this->sebagaiAdmin()->post('/admin/artikel', $this->data())
            ->assertRedirect('/admin/artikel')->assertSessionHas('success');

        $a = Article::first();
        $this->assertStringStartsWith('artikel/', $a->thumbnail);
        Storage::disk('public')->assertExists($a->thumbnail);
    }

    public function test_validasi_jenis_dan_ukuran(): void
    {
        $r = $this->sebagaiAdmin();
        $r->post('/admin/artikel', $this->data(['thumbnail' => UploadedFile::fake()->create('x.pdf', 50, 'application/pdf')]))->assertSessionHasErrors('thumbnail');
        $r->post('/admin/artikel', $this->data(['thumbnail' => UploadedFile::fake()->image('x.png')->size(2500)]))->assertSessionHasErrors('thumbnail');
        $r->post('/admin/artikel', $this->data(['thumbnail' => UploadedFile::fake()->image('x.gif')]))->assertSessionHasErrors('thumbnail');
        $this->assertSame(0, Article::count());
    }

    public function test_thumbnail_tampil_di_halaman_admin_dan_publik(): void
    {
        $this->sebagaiAdmin()->post('/admin/artikel', $this->data());
        $a = Article::first();

        $this->sebagaiAdmin()->get('/admin/artikel')->assertSee('storage/' . $a->thumbnail, false);
        $this->get('/artikel')->assertSee('storage/' . $a->thumbnail, false);
        $this->get('/artikel/' . $a->slug)->assertOk()->assertSee('storage/' . $a->thumbnail, false);
    }

    public function test_update_mengganti_file_lama_dan_tanpa_file_tetap(): void
    {
        $this->sebagaiAdmin()->post('/admin/artikel', $this->data());
        $a = Article::first();
        $lama = $a->thumbnail;

        // tanpa file baru -> file lama dipertahankan
        $this->sebagaiAdmin()->put("/admin/artikel/{$a->id}", $this->data(['thumbnail' => null, 'judul' => 'Judul Baru']))
            ->assertRedirect('/admin/artikel')->assertSessionHas('success');
        $this->assertSame($lama, $a->fresh()->thumbnail);
        Storage::disk('public')->assertExists($lama);

        // file baru -> file lama terhapus
        $this->sebagaiAdmin()->put("/admin/artikel/{$a->id}", $this->data());
        $baru = $a->fresh()->thumbnail;
        $this->assertNotSame($lama, $baru);
        Storage::disk('public')->assertMissing($lama);
        Storage::disk('public')->assertExists($baru);

        // centang hapus -> file terhapus, kolom null
        $this->sebagaiAdmin()->put("/admin/artikel/{$a->id}", $this->data(['thumbnail' => null, 'hapus_thumbnail' => 1]));
        $this->assertNull($a->fresh()->thumbnail);
        Storage::disk('public')->assertMissing($baru);
    }

    public function test_delete_menghapus_file(): void
    {
        $this->sebagaiAdmin()->post('/admin/artikel', $this->data());
        $a = Article::first();
        $path = $a->thumbnail;

        $this->sebagaiAdmin()->delete("/admin/artikel/{$a->id}")->assertRedirect('/admin/artikel')->assertSessionHas('success');
        $this->assertModelMissing($a);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_form_tambah_dan_edit_tampil(): void
    {
        $this->sebagaiAdmin()->get('/admin/artikel/create')->assertOk()->assertSee('multipart/form-data', false);
        $this->sebagaiAdmin()->post('/admin/artikel', $this->data());
        $a = Article::first();
        $this->sebagaiAdmin()->get("/admin/artikel/{$a->id}/edit")->assertOk()->assertSee('Hapus gambar ini');
    }
}
