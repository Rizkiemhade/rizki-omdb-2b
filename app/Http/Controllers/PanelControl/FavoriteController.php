<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    // Halaman My Favorites
    public function index()
    {
        try {
            $favorites = Favorite::where('user_id', Auth::id())
                                 ->orderBy('created_at', 'desc')
                                 ->get();

            return view('panel_control.my', compact('favorites'));

        } catch (\Throwable $th) {
            Log::error('Error fetching favorites: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan.');
        }
    }

    // Tambah Favorite
    public function store(Request $request)
    {
        try {
            $request->validate([
                'imdb_id' => 'required|string',
                'title'   => 'required|string',
                'year'    => 'nullable|string',
                'poster'  => 'nullable|string',
                'type'    => 'nullable|string',
            ]);

            // Cek apakah sudah ada di favorite
            $exists = Favorite::where('user_id', Auth::id())
                               ->where('imdb_id', $request->imdb_id)
                               ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Film sudah ada di favorites!',
                ]);
            }

            Favorite::create([
                'user_id' => Auth::id(),
                'imdb_id' => $request->imdb_id,
                'title'   => $request->title,
                'year'    => $request->year,
                'poster'  => $request->poster,
                'type'    => $request->type,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Film berhasil ditambahkan ke favorites!',
            ]);

        } catch (\Throwable $th) {
            Log::error('Error adding favorite: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan.',
            ], 500);
        }
    }

    // Hapus Favorite
    public function destroy($imdbId)
    {
        try {
            Favorite::where('user_id', Auth::id())
                    ->where('imdb_id', $imdbId)
                    ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Film dihapus dari favorites!',
            ]);

        } catch (\Throwable $th) {
            Log::error('Error removing favorite: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan.',
            ], 500);
        }
    }
}