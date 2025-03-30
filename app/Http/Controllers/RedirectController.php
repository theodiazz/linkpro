<?php

namespace App\Http\Controllers;

use App\Services\UrlService;
use App\Models\UrlVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RedirectController extends Controller
{
    protected $urlService;
    
    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }
    
    public function redirect($code, Request $request)
    {
        // Buscar URL por código corto
        $url = $this->urlService->findByShortCode($code);
        
        // Verificar si la URL existe y está activa
        if (!$url || !$url->is_active) {
            return redirect('/')->with('error', 'El enlace no existe o ha sido desactivado');
        }
        
        // Verificar si la URL ha expirado
        if ($url->isExpired()) {
            return redirect('/')->with('error', 'Este enlace ha expirado');
        }
        
        // Verificar si la URL tiene contraseña
        if ($url->password) {
            if (!$request->has('password')) {
                return view('urls.password', ['url' => $url]);
            }
            
            if (!Hash::check($request->password, $url->password)) {
                return back()->with('error', 'Contraseña incorrecta');
            }
        }
        
        // Registrar la visita
        UrlVisit::create([
            'url_id' => $url->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
            // Los demás campos se pueden rellenar con una biblioteca de detección de dispositivos
        ]);
        
        // Redireccionar a la URL original
        return redirect($url->original_url);
    }
}
