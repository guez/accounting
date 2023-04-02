<?php

namespace Guez\Accounting\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountingEntry extends Model
{
    use HasFactory;

    protected $table = 'accounting_entries';

    protected $fillable = [
        "merchantId",
        "date",
        "description",
        "status",
    ];

    protected $hidden = ['created_at', 'updated_at', 'id'];
    protected $appends = ['creationDate', 'lastUpdateDate', 'entryId'];
    protected $casts = ['created_at' => DateTime::class, 'updated_at' => DateTime::class];

    public function getCreationDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z') : '';
    }

    public function getLastUpdateDateAttribute(): string
    {
        return $this->updated_at ? $this->updated_at->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z') : '';
    }

    public function getEntryIdAttribute(): ?int
    {
        return $this->id;
    }


    /** 
     * Relationship
     */

    public function details(): HasMany
    {
        return $this->hasMany(AccountingEntryDetail::class, 'entryId');    
    }
}
