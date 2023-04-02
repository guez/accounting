<?php

namespace Guez\Accounting\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class AccountingEntryDetail extends Model
{
    use HasFactory;

    protected $table = 'accounting_entry_details';

    protected $fillable = [
        "merchantId",
        "entryId",
        "accountId",
        "debit",
        "credit",
    ];

    protected $hidden = ['created_at', 'updated_at', 'id'];
    protected $appends = ['creationDate', 'lastUpdateDate', 'entryDetailId'];
    protected $casts = ['created_at' => DateTime::class, 'updated_at' => DateTime::class];

    public function getCreationDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z') : '';
    }

    public function getLastUpdateDateAttribute(): string
    {
        return $this->updated_at ? $this->updated_at->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z') : '';
    }

    public function getEntryDetailIdAttribute(): ?int
    {
        return $this->id;
    }
}
