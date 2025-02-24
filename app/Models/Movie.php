<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Movie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'image',
        'storyline',
        'rating',
        'language',
        'release_date',
        'director',
        'maturity_rating',
        'running_time',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'date',
        'running_time' => 'string', // Sử dụng số nguyên thay vì 'datetime'
    ];

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define the relationship with the Show model.
     */
    public function shows()
    {
        return $this->hasMany(Show::class);
    }

    /**
     * Boot method to handle cascading delete.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($movie) {
            $movie->shows()->delete();
        });
    }

    /**
     * Scope để lọc kết quả truy vấn dựa trên các bộ lọc được cung cấp.
     *
     * @param Builder $query Đối tượng truy vấn Eloquent.
     * @param array $filters Mảng chứa các bộ lọc có thể có, bao gồm:
     *     - 'search' (string|null): Tìm kiếm theo tiêu đề (title) chứa chuỗi đã nhập.
     *     - 'category' (string|null): Lọc theo danh mục (category) có tiêu đề cụ thể.
     *     - 'sort' (string|null): Xác định cách sắp xếp kết quả, các giá trị hợp lệ:
     *         - 'top-rated': Sắp xếp theo đánh giá cao nhất (rating giảm dần).
     *         - 'newest': Sắp xếp theo ngày phát hành mới nhất (release_date giảm dần).
     *         - 'oldest': Sắp xếp theo ngày phát hành cũ nhất (release_date tăng dần).
     *
     * @return void
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn (Builder $q, $search) =>
            $q->where('title', 'LIKE', '%'.$search.'%')
        );

        $query->when($filters['category'] ?? false, fn (Builder $q, $category) =>
            $q->whereHas('category', fn ($q) => $q->where('title', $category))
        );

        $query->when($filters['sort'] ?? false, function (Builder $q, $sort) {
            return match ($sort) {
                'top-rated' => $q->orderBy('rating', 'desc'),
                'newest' => $q->orderBy('release_date', 'desc'),
                'oldest' => $q->orderBy('release_date', 'asc'),
                default => $q
            };
        });
    }

    protected function runningTime(): Attribute
    {
        return Attribute::get(fn ($value) => Carbon::createFromFormat('H:i:s', $value)->format('G \h i\m\i\n'));
    }
}
