<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamPaper extends Model
{
    public $timestamps = false;

y
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value );
    }

    public function getDataAttribute( $value )
    {
        $array =  json_decode($value, true);

        $output = [];

        foreach ($array as $index => $val) {
            $output[ $val[ 'exam_question_id' ] ?? $index] = $val['option_sequence'] ?? '1234';
        }

        return $output;

    }

    protected $guarded = [];
    use HasFactory;

    public function exam(){
        $this->belongsTo(Exam::class, 'exam_id', 'id');
    }
}
