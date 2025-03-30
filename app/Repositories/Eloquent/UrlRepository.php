<?php

namespace App\Repositories\Eloquent;

use App\Models\Url;
use App\Repositories\Interfaces\UrlRepositoryInterface;

class UrlRepository extends BaseRepository implements UrlRepositoryInterface
{
    public function __construct(Url $model)
    {
        parent::__construct($model);
    }
    
    public function findByShortCode($code)
    {
        return $this->model->where('short_code', $code)->first();
    }
    
    public function findByUser($userId)
    {
        return $this->model->where('user_id', $userId)
                          ->orderBy('created_at', 'desc')
                          ->get();
    }
    
    public function getMostClicked($limit = 10)
    {
        return $this->model->withCount('visits')
                          ->orderBy('visits_count', 'desc')
                          ->limit($limit)
                          ->get();
    }
    
    public function getPaginatedByUser($userId, $perPage = 15)
    {
        return $this->model->where('user_id', $userId)
                          ->orderBy('created_at', 'desc')
                          ->paginate($perPage);
    }
    
    public function searchByTitle($search, $userId)
    {
        return $this->model->where('user_id', $userId)
                          ->where(function($query) use ($search) {
                              $query->where('title', 'like', "%{$search}%")
                                  ->orWhere('short_code', 'like', "%{$search}%")
                                  ->orWhere('original_url', 'like', "%{$search}%");
                          })
                          ->orderBy('created_at', 'desc')
                          ->get();
    }
}
