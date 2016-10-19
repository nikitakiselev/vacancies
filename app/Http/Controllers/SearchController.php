<?php

namespace App\Http\Controllers;

use App\Vacancy;
use App\Http\Requests;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('search.index');
    }

    /**
     * Search vacancies
     *
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $page = $request->input('page', 1);

        return Vacancy::search($query)->paginate(10, 'page', $page);
    }
}
