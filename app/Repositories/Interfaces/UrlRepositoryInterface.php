<?php

namespace App\Repositories\Interfaces;

interface UrlRepositoryInterface extends BaseRepositoryInterface
{
    public function findByShortCode($code);
    public function findByUser($userId);
    public function getMostClicked($limit = 10);
    public function getPaginatedByUser($userId, $perPage = 15);
    public function searchByTitle($search, $userId);
}
