<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    use HasFactory;
    protected $table = 'Assigns';



    
    protected $fillable =[
        'Email',
        'Base_Mark',
        'Course',
        'teacher_id',
    ];
}

