<?php

// Wrap $_SESSION and faked session (stored in session.dat by default)
// for command line testing.
//
// Basic usage:
//
//   $session=new Session();
//   $session->name="value"; // set 
//   echo $session->name; // get
//   $session->destory(); // clear
//
// When running from the command line, the destructor automatically
// saves the session values.  The runtime automatically does this on
// the web server.  In either case, you don't have to do anything to
// maintain state between script executions.
//

class Session
{
  private $cli;
  private $cliData;

  function __construct($cliData = "session.dat")
  {
    session_start();
    $this->cli=array_key_exists('argv',$_SERVER);
    $this->cliData = $cliData;
    if ($this->cli) {
      if (file_exists($this->cliData)) {
	$_SESSION = unserialize(file_get_contents($this->cliData));
      } else {
	$_SESSION = array();
      }
    }
  }

  function __destruct()
  {
    if ($this->cli) {
      file_put_contents($this->cliData,serialize($_SESSION));
    }
  }
  
  function destroy()
  {
    $_SESSION = array();
    if ($this->cli) {
      unlink($this->cliData);
    }
    session_destroy();
  }

  function lookup($name,$default)
  {
    return array_key_exists($name,$_SESSION) ? $_SESSION[$name] : $default;
  }

  function __get($name) 
  {
    return $_SESSION[$name];
  }

  function __set($name,$value)
  {
    $_SESSION[$name]=$value;
  }
}
