<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLogChange extends Model
{
    protected $table = 'audit_log_changes';
    protected $fillable = ['audit_log_id', 'change_type', 'field_name', 'field_value'];

    public function auditLog(): BelongsTo
    {
        return $this->belongsTo(AuditLog::class);
    }
}
