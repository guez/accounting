<?php

namespace Guez\Accounting\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class AccountingAcounts extends Model
{
    use HasFactory;

    protected $table = 'accounting_accounts';

    protected $fillable = [
        "merchantId",
        "accountMasterId",
        "code",
        "name",
        "positionCode",
        "type",
        "level",
    ];

    protected $hidden = ['created_at', 'updated_at', 'id'];
    protected $appends = ['creationDate', 'lastUpdateDate', 'accountId'];
    protected $casts = ['created_at' => DateTime::class, 'updated_at' => DateTime::class];

    public function getCreationDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z') : '';
    }

    public function getLastUpdateDateAttribute(): string
    {
        return $this->updated_at ? $this->updated_at->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z') : '';
    }

    public function getAccountIdAttribute(): ?int
    {
        return $this->id;
    }
}
