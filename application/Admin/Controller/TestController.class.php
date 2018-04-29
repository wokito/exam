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
        $pa_time = I('pa_time','','trim');

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
        $this->assign('id',$id);
        $this->assign('pa_time',$pa_time);
        $this->display();
    }
    /*
     * 提交选择题
     */
    public function post_select(){
        //选择题判断
        $user_id         = $_SESSION['ADMIN_ID'];
        $pa_id           = I('id','','intval');
        $select          = I('select','','trim');
        $ch_id           = I('ch_id','','trim');
        $data['st_id']  = $user_id;
        $data['ch_id']  = $ch_id;
        $data['answer'] = $select;
        $data['pa_id']  = $pa_id;
        $data['status'] = I('status','','intval');
        $m = M('ch-answer','ks_');
        $judge = $m->where(array('ch_id'=>$ch_id))->find();
        if($judge){
            $result = $m->where(array('ch_id'=>$ch_id))->save($data);
        }else{
            $result = $m->add($data);
        }
    }
    /*
     * 提交填空题
     */
    public function post_fill(){
        //填空题判断
        $user_id         = $_SESSION['ADMIN_ID'];
        $fi_id = I('fi_id','','intval');
        $pa_id = I('pa_id','','intval');;
        $answer = I('answer','','trim');
        $data['fi_id'] = $fi_id;
        $data['pa_id'] = $pa_id ;
        $data['st_id'] = $user_id;
        $data['answer'] =$answer;
        $data['status'] = I('status','','intval');
        $m = M('fi-answer','ks_');
        $judge1 = $m->where(array('fi_id'=>$fi_id))->find();
        if($judge1){
            $result = $m->where(array('fi_id'=>$fi_id))->save($data);
        }else{
            $result = $m->add($data);
        }
    }
    /*
     * 简答题判断
     */
    public function post_short(){
        $user_id         = $_SESSION['ADMIN_ID'];
        $sa_id = I('sa_id','','intval');
        $pa_id = I('pa_id','','intval');
        $answer = I('answer','','trim');
        $data['sa_id'] = $sa_id;
        $data['pa_id'] = $pa_id;
        $data['st_id'] = $user_id;
        $data['answer'] = $answer;
        $m = M('sa-answer','ks_');
        $judge2 = $m->where(array('sa_id'=>$sa_id))->find();
        if($judge2){
            $result = $m->where(array('sa_id'=>$sa_id))->save($data);
        }else{
            $result = $m->add($data);
        }
    }
    /*
     * 考试结束
     */
    public function end(){
        $this->display();
    }
}