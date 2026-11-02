<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index()
    {
        return view('admin.articles.index', [
            'artikel' => Article::with('penulis')->orderByDesc('created_at')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.articles.form');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $thumbnail = $request->hasFile('thumbnail')
            ? $request->file('thumbnail')->store('artikel', 'public')
            : null;

        Article::create([
            'user_id'      => session('user_id'),
            'thumbnail'    => $thumbnail,
            'judul'        => $data['judul'],
            'slug'         => Article::buatSlug($data['judul']),
            'konten'       => $data['konten'],
            'kategori'     => $data['kategori'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil disimpan.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.form', ['editArtikel' => $article]);
    }

    public function update(Request $request, Article $article)
    {
        $data = $this->validated($request);

        // Ganti gambar -> hapus file lama. Centang "hapus gambar" -> hapus tanpa pengganti.
        $thumbnail = $article->thumbnail;

        if ($request->hasFile('thumbnail')) {
            $this->hapusFile($thumbnail);
            $thumbnail = $request->file('thumbnail')->store('artikel', 'public');
        } elseif ($request->boolean('hapus_thumbnail')) {
            $this->hapusFile($thumbnail);
            $thumbnail = null;
        }

        $article->update([
            'thumbnail'    => $thumbnail,
            'judul'        => $data['judul'],
            'slug'         => Article::buatSlug($data['judul'], $article->id),
            'konten'       => $data['konten'],
            'kategori'     => $data['kategori'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diupdate.');
    }

    public function toggle(Article $article)
    {
        $article->update(['is_published' => ! $article->is_published]);

        return redirect()->route('admin.artikel.index')->with('success', 'Status artikel diubah.');
    }

    public function destroy(Article $article)
    {
        $this->hapusFile($article->thumbnail);
        $article->delete();

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function hapusFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul'     => 'required|max:200',
            'konten'    => 'required',
            'kategori'  => ['required', Rule::in(array_keys(Article::KATEGORI))],
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'thumbnail.image'    => 'File harus berupa gambar.',
            'thumbnail.mimes'    => 'Gambar harus berformat JPG, JPEG, atau PNG.',
            'thumbnail.max'      => 'Ukuran gambar maksimal 2 MB.',
            'thumbnail.uploaded' => 'Gambar gagal diunggah. Pastikan ukurannya tidak lebih dari 2 MB.',
        ]);
    }
}
