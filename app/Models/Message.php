<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Define the fillable attributes for mass assignment
    protected $fillable = ['sender_id', 'receiver_id', 'message'];

    // If your timestamps are enabled, Laravel will automatically manage the created_at and updated_at columns
    // If your table doesn't have them, you can disable this feature
    public $timestamps = true;

    // Optional: If you want to define relationships with User model for sender and receiver
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
