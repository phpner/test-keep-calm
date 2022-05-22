<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    /**
     * status of comment.
     */
    const STATUS = [
        'open' => 'open',
        'close' => 'close',
        'moderation' => 'moderation',
        'deleted' => 'deleted',
    ];

    const DEFAULT_COUNT = 3;

    /**
     * @var string[]
     */
    protected $fillable = [
        'test',
        'status',
        'page_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Подготовить дату для сериализации массива / JSON.
     *
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

}
