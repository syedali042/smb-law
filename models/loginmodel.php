<?php
class MD_LOGINMODEL extends LB_ezSQL_mysql
{
	private $db;
	
	public function __construct()
	{
		$this->db = new LB_ezSQL_mysql(_DB_USER,_DB_PASS,_DB_NAME,_DB_HOST);
		parent::Lb_ezSQL_mysql(_DB_USER,_DB_PASS,_DB_NAME,_DB_HOST);
	}
	
	
	public function index(){err("Looks Like, you're here by mistake");die();}
	
	public function admin_login($username, $password, $check = false)
	{
		$username = $this->db->escape(strtolower($username));
		if(!$check){$password = md5($this->db->escape($password));}
		return $this->db->get_row("SELECT * FROM `admin` WHERE `username` = \"$username\" AND `password` = \"$password\";");
	}//end login


	public function _update($table, $vals, $cond, $exec = true)
	{
		if(is_array($vals) && is_array($cond))
		{
			try{
				$vv = '';
				$i = 0;
				$table = "`".trim(strtolower($table))."`";
				foreach($vals as $k=>$v):
					if($i != 0) $vv .= " ,";
					$vv .= "`$k` = '$v' ";
					$i++;
				endforeach;
				$cc = '';
				$i = 0;
				foreach($cond as $k=>$v):
					if($i != 0){$cc .= " AND ";}
					else{$cc .= "WHERE ";}
					$cc .= "`$k` = '$v'";
					$i++;
				endforeach;

				$sql = "UPDATE $table SET $vv $cc";
				if($exec)
					return $this->db->query($sql);
				else
					return $sql;
			}
			catch(Exception $e)
			{
				return false;
			}

		}
		return false;
	}
	public function _insert($table, $vals, $exec = true)
	{
		if(is_array($vals))
		{
			$vv = '';
			$i = 0;
			$table = "`".trim(strtolower($table))."`";
			foreach($vals as $k=>$v):
				if($i != 0) $vv .= " ,";
				$vv .= "`$k` = '$v' ";
				$i++;
			endforeach;
			$sql = "INSERT INTO $table SET $vv";
			if($exec)
			{
				$data = $this->db->query($sql);
				if($data)
				{
					$this->lastid = $this->db->insert_id;

				}
				return $data;
			}
			else
				return $sql;

		}
		else
			return false;
	}


	public function check_expiration($memberid)
	{
		$fbid = $this->db->escape($memberid);
		$red = $this->db->get_row("SELECT * FROM `membership` WHERE `members_id`='$fbid'");
		if($red)
		{
			return (strtotime($red['expires_at']) >= time()) ? 2 : 3;
		}
		return 0;
	}
	

	public function validate($login = false)
	{
		$email = isset($_SESSION['email'])?$_SESSION['email']:false;
		$password = isset($_SESSION['password'])?$_SESSION['password']:false;
		//TOKEN SESSION
		$token = isset($_SESSION['sess_token'])?$_SESSION['sess_token']:false;

		$red = $this->db->get_row("SELECT * FROM `user` LEFT JOIN `membership` ON `membership`.`USERID` = `user`.`USERID` WHERE `user`.`EMAIL` = '$email' AND `user`.`PASSWORD`='$password' ORDER BY `membership`.`expires_at` DESC LIMIT 1");

		if($red)
		{
			if($login)
			{
				$token = md5($_SERVER['REMOTE_ADDR'])."+".md5($_SERVER['HTTP_USER_AGENT']);
				$this->_update("user", array("token"=>"$token"), array("USERID"=>$red['USERID']));
			}
			else
			{
				if(!$this->get_row("SELECT * FROM `user` WHERE `token` = '".$_SESSION['sess_token']."' AND `USERID` = '".$red['USERID']."'"))
				{
					return false;
				}
			}

			if(strtotime($red['expires_at']) <= time())
			{
				return 2;
			}
			else
			{
				return 3;
			}
		}
		return false;
		
	}

	public function fbvalidate()
	{
		$userid = isset($_SESSION['userid'])?$_SESSION['userid']:false;
		$source = isset($_SESSION['source'])?strtoupper($_SESSION['source']):false;

		$red = $this->get_row("SELECT * FROM `user` LEFT JOIN `membership` WHERE `user`.`$source` = '$userid' ORDER BY `membership`.`expires_at` DESC LIMIT 1");

		if($red)
		{
			$_SESSION['email'] = $red['EMAIL'];
			$_SESSION['password'] = $red['PASSWORD'];

			if(strtotime($red['expires_at']) <= time())
			{
				return 2;
			}
			else
			{
				return 3;
			}
		}
		return false;

	}//this is for validating with every page request

	public function get_profile()
	{
		$email = isset($_SESSION['email'])?$_SESSION['email']:false;
		return $this->db->get_row("SELECT * FROM `user` INNER JOIN `membership` WHERE `user`.`USERID` = `membership`.`USERID` AND `user`.`EMAIL` = '$email'");
	}

	public function recent_login($id, $ip)
	{
		return $this->_insert("members_activity", array("members_id"=>"$id", "remote_id"=>"$ip"));
	}

	public function recent_activity($id)
	{
		return $this->_update('user',array("recent_activity"=>date("Y-m-d H:i:s")), array('USERID'=>"$id"));
	}

	public function assign_social($type = '',$socialid = '',  $userid = 0)
	{

		if(!$this->get_row("SELECT * FROM `user` WHERE `$type` = '$socialid'"))
		{
			return $this->_update("user", array($type=>"$socialid"), array("USERID"=>"$userid"));
		}
		else
		{
			redirect("user-profile?msg=Already a user has been assigned to this social account");
			return false;
		}
	}

	public function login_social($type = '',$socialid = '')
	{
		$def = $this->get_row("SELECT * FROM `user` WHERE `$type` = '$socialid'");
		if($def)
		{
			$_SESSION['email'] = $def['EMAIL'];
			$_SESSION['password'] = $def['PASSWORD'];
			$token = md5($_SERVER['REMOTE_ADDR'])."+".md5($_SERVER['HTTP_USER_AGENT']);
			$this->_update("user", array("token"=>"$token"), array("USERID"=>$def['USERID']));
			redirect("library");
		}
		else
		{
			redirect("login?msg=No user has been associated with this account&error=1");
		}

	}
}
?>
