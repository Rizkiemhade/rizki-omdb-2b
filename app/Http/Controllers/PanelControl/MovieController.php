<?php

namespace App\Http\Controllers\PanelControl;

use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MovieController extends Controller
{
    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request)
    {
        try {
            $query = $request->get('keyword', '');
            $page  = $request->get('page', 1);

            if (empty($query)) {
                if ($request->ajax()) {
                    return response()->json([
                        'movies' => [],
                        'total'  => 0,
                        'error'  => null,
                    ]);
                }
                return view('panel_control.dashboard', [
                    'movies' => [],
                    'total'  => 0,
                    'error'  => null,
                ]);
            }

            $result = $this->movieService->search($query, $page);

            // [FIX] Cek kalau service return false
            if ($result === false) {
                if ($request->ajax()) {
                    return response()->json([
                        'movies' => [],
                        'total'  => 0,
                        'error'  => 'Gagal menghubungi API, coba lagi.',
                    ]);
                }
                return view('panel_control.dashboard', [
                    'movies' => [],
                    'total'  => 0,
                    'error'  => 'Gagal menghubungi API, coba lagi.',
                ]);
            }

            if ($request->ajax()) {
                return response()->json($result);
            }

            return view('panel_control.dashboard', $result);

        } catch (\Throwable $th) {
            Log::error('Error during movie search: ' . $th->getMessage(), [
                'line'    => $th->getLine(),
                'file'    => $th->getFile(),
                'message' => $th->getMessage(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'movies' => [],
                    'total'  => 0,
                    'error'  => 'Terjadi kesalahan.',
                ], 500);
            }

            return view('panel_control.dashboard', [
                'movies' => [],
                'total'  => 0,
                'error'  => 'Terjadi kesalahan.',
            ]);
        }
    }

    public function detail($imdbId)
    {
        try {
            $movie = $this->movieService->detail($imdbId);

            if (!$movie) {
                return redirect()->back()->with('error', 'Film tidak ditemukan!');
            }

            return view('panel_control.detail.detail', ['movie' => $movie]);
        } catch (\Throwable $th) {
            Log::error('Error fetching movie detail: ' . $th->getMessage(), [
                'line'    => $th->getLine(),
                'file'    => $th->getFile(),
                'message' => $th->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengambil detail film.');
        }
    }
}