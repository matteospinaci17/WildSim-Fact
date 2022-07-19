<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;
    protected $table = 'game_sessions';

    protected $keyType = 'integer';

    protected $fillable = ['session_name', 'step_number', 'current_board_state', 'created_at', 'updated_at'];
}
