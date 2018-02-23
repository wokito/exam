<?php
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class MainController extends AdminbaseController {
	/*
	 * 后台首页统计
	 */
    public function index(){
        //学院个数
        $academy = M('academy','ks_');
        $result = $academy->count();
        $this->assign('result',$result);
        //老师人数
        $users = M('users');
        $result1 = $users->where(array('category'=>1))->count();
        $this->assign("result1",$result1);
        //学生个数
        $result2 = $users->where(array('category'=>2))->count();
        $this->assign("result2",$result2);

        //试卷个数
        $paper = M('paper','ks_');
        $result3 = $paper->count();
        $this->assign("result3",$result3);

    	
    	$mysql= M()->query("select VERSION() as version");
    	$mysql=$mysql[0]['version'];
    	$mysql=empty($mysql)?L('UNKNOWN'):$mysql;
    	
    	//server infomaions
    	$info = array(
    			L('OPERATING_SYSTEM') => PHP_OS,
    			L('OPERATING_ENVIRONMENT') => $_SERVER["SERVER_SOFTWARE"],
    	        L('PHP_VERSION') => PHP_VERSION,
    			L('PHP_RUN_MODE') => php_sapi_name(),
				L('PHP_VERSION') => phpversion(),
    			L('MYSQL_VERSION') =>$mysql,
    			L('PROGRAM_VERSION') => THINKCMF_VERSION . "&nbsp;&nbsp;&nbsp; [<a href='http://www.thinkcmf.com' target='_blank'>ThinkCMF</a>]",
    			L('UPLOAD_MAX_FILESIZE') => ini_get('upload_max_filesize'),
    			L('MAX_EXECUTION_TIME') => ini_get('max_execution_time') . "s",
    			L('DISK_FREE_SPACE') => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
    	);
    	$this->assign('server_info', $info);
    	$this->display();
    }
}