<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'company_name',
        'person_name',
        'date',
        'due_date',
        'currency',
        'total_amount',
        'paid_amount',
        'status',
        'client_logo',
        'is_cleared',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
