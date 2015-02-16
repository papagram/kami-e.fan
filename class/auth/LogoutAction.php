<?php

class LogoutAction
{
	public function execute()
	{
		$_SESSION = array();
		
		if (isset($_COOKIE[session_name()]))
		{
			setcookie(session_name(),'',time()-3600,'/');
		}
		
		session_destroy();
		
		redirect();
	}
}