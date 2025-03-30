<?php

namespace App\Http\Controllers;

use App\Services\UrlService;
use App\DTOs\UrlDTO;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUrlRequest;

class UrlController extends Controller
{
    protected $urlService;
    
    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urls = $this->urlService->getUserUrls(auth()->user());
        return view('urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('urls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUrlRequest $request)
    {
        $dto = UrlDTO::fromRequest($request);
        $url = $this->urlService->createUrl($dto, auth()->user());
        
        return redirect()->route('urls.index')
            ->with('success', 'URL acortada creada con éxito');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    
    // Otros métodos como edit, update, destroy...
}
