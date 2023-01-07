<?php

namespace App\Models;

use App\Traits\ContentType;
use CreateExamPropertiesTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Exam extends Model
{
    use HasFactory, SoftDeletes, ContentType;

    protected static function getTypes( ){
        return Type::getExamTypes()->pluck( 'type', 'id' )->toArray();
    }

    private static $studentRelatedProgramId;
    public static function setStudentRelatedProgramId( $id ) : Builder {
        self::$studentRelatedProgramId = $id;
        return (new static)->newQuery();
    }

    protected $guarded = [];

    public function student_related_program( ){
        //return $this->join('')->has;
    }

    public function student_participation_list( ){
        return $this->hasMany( ParticipantExam::class )
        ->whereHas('participant.student', function ($q){
            $user = request()->user();
            $q->where('id', $user->id ?? null );
        });
    }

    public function program()
    {
        return $this->morphOne(Program::class, 'programable');
    }

    public function property()
    {
        return $this->belongsTo(ExamProperty::class, 'exam_property_id', 'id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_exams');
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions');
    }

    public function exam_questions()
    {
        return $this->hasMany(ExamQuestion::class );
    }

    public function exam_assigned_questions()
    {
        return $this->hasMany(ExamAssignedQuestion::class, 'exam_id','id' );
    }

    public function exam_papers()
    {
        return $this->hasMany(ExamPaper::class, 'exam_id', 'id');
    }

    public function contents()
    {
        return $this->morphToMany(Content::class, 'contentable');
    }

    public function exam()
    {
        return $this->morphToMany(Content::class, 'contentable');
    }
    public function participant_exams(){
        return $this->hasMany( ParticipantExam::class);
    }
}
