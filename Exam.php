<?php
class Exam {
    public $exam_subject_id;
    public $exam_date;
    public $exam_student_id;
    public $exam_mark;
    public function __construct($exam_subject_id, $exam_date, $exam_student_id, $exam_mark){
        $this->exam_subject_id = $exam_subject_id;
        $this->exam_date = $exam_date;
        $this->exam_student_id = $exam_student_id;
        $this->exam_mark = $exam_mark;
    }
    
    public function add(){
        $db = new DB;
        $db->con = mysqli_query("INSERT INTO `exam` (`exam_subject_id`, `exam_date`, `exam_student_id`, `exam_mark`) VALUES 
                                 ({$this->exam_subject_id}, {$this->exam_date}, {$this->exam_student_id }, {$this->exam_mark})");
    }
    
    public static function delete($id){
        $db = new DB;
        $db->con = mysqli_query("DELETE FROM `exam` WHERE `exam_id`={$id})");
    }
    
    public static function change($id, $exam_subject_id, $exam_date, $exam_student_id, $exam_mark){
        $db = new DB;
        $db->con = mysqli_query("UPDATE `exam` SET `exam_subject_id`={$this->exam_subject_id}, `exam_date`={$this->exam_date}, `exam_student_id`={$this->exam_student_id }, `exam_mark`={$this->exam_mark} WHERE exam_id={$id}");
    }
}
?>