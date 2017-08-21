<?php
	Class UserAction extends Action{
		//注册
		public function register(){
			
			//判断手机号是否注册
			$phone=$_GET['phone'];
			$arr=M('user')->where("phone='$phone'")->find();
			if($arr){
				echo -1;
				exit;
			}
			
			$_GET['password']=md5($_GET['password']);
			$_GET['time']=time();
			$str=M('user')->add($_GET);
			if($str){
				$dd['user_id']=$str;
				$dd['content']='欢迎你登录';
				$dd['time']=time();
				M('message')->add($dd);
				echo $str;
			}else{
				echo 0;
			};
			
			
		}
		
		//获取用户信息
		public function get_user(){
			$phone=$_GET['phone'];
			$arr=M('user')->where("phone='$phone'")->find();
			echo json_encode($arr);
		}
		
		//登录
		public function login(){
			$phone =$_GET['phone'];
			$password=md5($_GET['password']);
			
			//用户是否存在
			$arr=M('user')->where("phone='$phone'")->find();
			if(!$arr){
				echo -1;
				exit;
			}
			if($arr['password']==$password){
				echo 1;
			}else{
				echo 0;
			};
			
		}
		
		//获取用户消息
		public function get_message(){
			$phone =$_GET['phone'];
			$arr=M('user')->where("phone='$phone'")->find();
			$id=$arr['id'];
			$message=M('message')->where("user_id='$id'")->order('id desc')->select();
			foreach($message as $key =>$value){
				$message[$key]['time']=date('Y-m-d H:i:s',$value['time']);
			}
			echo json_encode($message);
		}
		
		//添加意见反馈
		public function add_feedback(){
			$_GET['time']=time();
			echo M('feedback')->add($_GET);
		}
		
		//更新用户信息
		public function update_info(){
			$phone =$_GET['phone'];
//			echo $phone;
			echo M('user')->where("phone='$phone'")->save($_GET);
				
		}
		
	}
?>