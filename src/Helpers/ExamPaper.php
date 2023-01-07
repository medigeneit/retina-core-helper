<?php

namespace Retina\Core\Helpers;


class ExamPaper
{

    protected $question_shuffling = -1;
    protected $paper_data_array = [];

    public function _make(  $exam, $is_shuffling = -1 ){

        $exam_questions = $exam->exam_assigned_questions;

        $examIsShuffling = $is_shuffling ===-1 ? ( $exam->question_shuffling == 1 ): $is_shuffling;

        $exam_questions =  $examIsShuffling ? $exam_questions->shuffle( ): $exam_questions;

        foreach ($exam_questions as $index => $exam_question) {

            $options = range(0, count($exam_question[ 'question_options' ][ 'opts' ] ?? [])-1 );

            if( $examIsShuffling ) {
                shuffle( $options );
            }

            $this->paper_data_array[] = [ 'exam_question_id'=> $exam_question->id , 'option_sequence' => join("",$options)];
        }

        return $this;
    }

    public function __toString()
    {
        if( is_string($this->paper_data_array) )
            return $this->paper_data_array;
        return json_encode( $this->paper_data_array );
    }

    public function toArray(){
        return $this->paper_data_array;
    }


    public static function shuffleQuestions( $condition = true ){
        $exam =  new static();
        $exam->question_shuffling = $condition;
        return $exam;
    }

    public static function __callStatic( $name, $arguments )
    {
        if( $name == 'make' ) {
            return (new static())->_make(...$arguments);
        }
    }

    public function dd($dd){
        dd($this->paper_data_array);
    }

}
