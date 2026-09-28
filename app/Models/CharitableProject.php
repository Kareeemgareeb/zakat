<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharitableProject extends Model
{
    protected $fillable = ['title', 'category', 'target_budget', 'collected_amount', 'disbursed_amount', 'status'];

    public function transactions() { return $this->hasMany(Transaction::class); }
    public function disbursements() { return $this->hasMany(ProjectDisbursement::class); }
}
