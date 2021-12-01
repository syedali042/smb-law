<?php 

class LB_FBCLASS {

	// define some variables to store data from facebook
	public $fbpages;
	public $fbuid;
	public $fbaccesstoken;
	public $fbuserinfo;
	public $fbaccounts;
	private $facebook;
	
    public function __construct()
    {
		//include facebook sdk
		include('facebook/facebook.php');
		//get an instance of codeignter framework. This will help us to use code iginter libraries.
		$this->facebook = new Facebook(array(
	      'appId'  => FBAPPID,
	      'secret' => FBAPPSECRET
	    ));
                
		$this->fbuid = $this->facebook->getUser();
		/*
		if($this->fbuid!=0){
			if(!isset($this->fbuserinfo)){
				$this->fbuserinfo=$this->facebook->api('/me?access_token='. $this->facebook->getAccessToken());
			}
			if(!isset($this->fbaccesstoken)){
				$this->fbaccesstoken=$this->facebook->getAccessToken();
			}
			if(!isset($this->fbpages)){
				$fql = "select page_id,name,pic_small,page_url,type from page where page_id in(select page_id from page_admin where uid = ".$this->fbuid.") ";
				$response = $this->facebook->api(array(
					'method' => 'fql.query',
					'query' =>$fql,
				));
				$this->fbpages=$response;
			}
			if(!isset($this->fbaccounts)){
				$this->fbaccounts=$this->facebook->api('/me/accounts?access_token='. $this->facebook->getAccessToken());
			}
		} else {
			  $loginUrl = $this->facebook->getLoginUrl();
			  echo "<script type='text/javascript'>location.href = '$loginUrl';</script>";
			  exit;
		}
		*/
		
    }
	
	public function wall_post($attachment){
		$posted = $this->facebook->api('/me/feed?access_token='.$this->fbaccesstoken , 'POST', $attachment);
		print_r($posted);
		exit;
		if(isset($posted['id'])){
			$return_array = array('id'=>$posted['id'],
								  'message' => "Post successfully created");	
		} else {
			$return_array = array('message' => "Please try again");
		}
		return $return_array;
	}
	public function post_image($attachments){
		$this->facebook->setFileUploadSupport(true);
		$posted = $this->facebook->api('/me/photos?access_token='.$this->fbaccesstoken, 'post', $attachments);
		if(isset($posted['id'])){
			$return_array = array('id'=>$posted['id'],
								  'message' => "Post successfully created");	
		} else {
			$return_array = array('message' => "Please try again");
		}
		return $return_array;
	}
	
	public function post_insights($postid, $acccess_token){
		$insights = array();
		$insights['impressions']=0;
		$insights['likes']=0;
		$insights['comments']=0;
		$fql = "SELECT impressions FROM stream WHERE post_id ='".$postid."'";
		$response = $this->facebook->api(array(
					'method' => 'fql.query',
					'query' =>$fql,
					'access_token'=>$acccess_token,
			));
		if(count($response)>0 && $response[0]['impressions']!=''){
				$insights['impressions'] = $response[0]['impressions'];
		}
		$fql = "select post_fbid from comment where post_id = '".$postid."'";
		$allcomments = $this->facebook->api(array(
					'method' => 'fql.query',
					'query' =>$fql,
					'access_token'=>$acccess_token,
			));
		if(count($allcomments)>0){
				$insights['comments'] = count($allcomments);
		}		
		$fql = "SELECT user_id FROM like WHERE post_id = '".$postid."'";
		$allikes = $this->facebook->api(array(
					'method' => 'fql.query',
					'query' =>$fql,
					'access_token'=>$acccess_token,
			));
		if(count($allikes)>0){
				$insights['likes'] = count($allikes);
		}		
	
		return $insights;
	}
	
	public function distruct(){
		unset($fbpages);
		unset($fbuid);
		unset($fbaccesstoken);
		unset($fbaccounts);
		unset($fbuserinfo);
	}
}

?>