<?php

namespace App\DTOs;

class UrlDTO
{
    public function __construct(
        public readonly string $originalUrl,
        public readonly ?string $title = null,
        public readonly ?string $customCode = null,
        public readonly ?string $password = null,
        public readonly ?string $expiresAt = null,
    ) {}
    
    public static function fromRequest($request)
    {
        return new self(
            originalUrl: $request->input('url'),
            title: $request->input('title'),
            customCode: $request->input('custom_code'),
            password: $request->input('password'),
            expiresAt: $request->input('expires_at'),
        );
    }
}
