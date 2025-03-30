<?php

namespace App\Services;

use App\Repositories\Interfaces\UrlRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Str;
use App\DTOs\UrlDTO;

class UrlService
{
    protected $urlRepository;
    
    public function __construct(UrlRepositoryInterface $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }
    
    /**
     * Crear una nueva URL acortada
     */
    public function createUrl(UrlDTO $dto, User $user)
    {
        // Generar código corto único o usar personalizado
        $shortCode = $dto->customCode ?: $this->generateUniqueCode();
        
        // Crear la URL en la base de datos
        $url = $this->urlRepository->create([
            'original_url' => $dto->originalUrl,
            'short_code' => $shortCode,
            'user_id' => $user->id,
            'title' => $dto->title ?: parse_url($dto->originalUrl, PHP_URL_HOST),
            'password' => $dto->password ? bcrypt($dto->password) : null,
            'expires_at' => $dto->expiresAt,
            'is_custom' => $dto->customCode ? true : false,
            'is_active' => true
        ]);
        
        return $url;
    }
    
    /**
     * Generar un código corto único
     */
    public function generateUniqueCode($length = 6)
    {
        do {
            $code = Str::random($length);
        } while ($this->urlRepository->findByShortCode($code));
        
        return $code;
    }
    
    /**
     * Obtener URLs de un usuario
     */
    public function getUserUrls(User $user, $perPage = 15)
    {
        return $this->urlRepository->getPaginatedByUser($user->id, $perPage);
    }
    
    /**
     * Buscar URL por código corto
     */
    public function findByShortCode($code)
    {
        return $this->urlRepository->findByShortCode($code);
    }
    
    /**
     * Desactivar una URL
     */
    public function deactivateUrl($id)
    {
        return $this->urlRepository->update(['is_active' => false], $id);
    }
}
