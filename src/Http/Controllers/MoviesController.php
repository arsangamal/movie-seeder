<?php


namespace Arsangamal\MovieSeeder\Http\Controllers;


use App\Http\Controllers\Controller;
use Arsangamal\MovieSeeder\Models\Movie;
use Illuminate\Http\Request;

class MoviesController extends Controller
{

    /**
     * Get all movies and apply filters scope
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Arsan Gamal <arsan.gamal@hotmail.com>
     */
    public function listing(Request $request)
    {
        $data['movies'] = Movie::filters()->get();

        return response()->json($data);
    }
}
