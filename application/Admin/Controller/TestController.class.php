<?php
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class TestController extends AdminbaseController{
    /*
     * 科目列表
     */
    public function index(){
        $ac_id = $_SESSION['ac_id'];
        $m = M('academy','ks_');
        $result = $m->table("ks_academy a")
                    ->join("inner join ks_course b on a.ac_id = b.co_academy_id")
                    ->where(array('ac_id'=>$ac_id))
                    ->select();
        $this->assign('result',$result);
        $this->display();
    }
    /*
     * 选择试卷
     */
    public function type(){
        $co_id = I('id','','intval');
        $course = M('course','ks_');
        $result = $course->table("ks_course a")
                         ->join("inner join ks_paper b on a.co_id = b.id")
                         ->where(array('pa_co_id'=>$co_id))
                         ->select();
        $this->assign('result',$result);
        $this->display();
    }

    /*
     * 开始答题
     */
    public function exam(){
        //试卷id
        $id = I('id','','intval');

        //选择题
        $m = M('choice','ks_');
        //选择题数量
        $count = $m->where(array('paper_id'=>$id))->count();
        $result = $m->where(array('paper_id'=>$id))->select();

        //填空题
        $m1 = M('fill','ks_');
        //填空题数量
        $count1 = $m1->where(array('fi_course_id'=>$id))->count();
        $result1 = $m1->where(array('fi_course_id'=>$id))->select();
        //简答题
        $m2 = M('saq','ks_');
        $count2 = $m2->where(array('sa_course_id'=>$id))->count();
        $result2 = $m2->where(array('sa_course_id'=>$id))->select();

        $this->assign('result2',$result2);
        $this->assign('result1',$result1);
        $this->assign('result',$result);
        $this->display();
    }
    /*
     * 提交答案
     */
    public function post_exam(){
        $post_exam = I('post.');
        dump($post_exam);
        exit;
    }
}