<?php
  class character {
    var $sqlinfo;
     
    var $guid;
    var $account;
    var $name;
	  var $race;
	  var $class;
	  var $gender;
	  var $level;
	  var $current_xp;
	  var $next_level_xp;
	  var $xp_perc;
	  var $online;
		var $money;
		
		var $map;
    var $position_x;
    var $position_y;
    
    var $at_login;
    
    var $honor_points;
    var $honorable_kills;
        
    // конструктор
    function character($sqlinfo, $mangos_field) {
        // change some properties
        $this->sqlinfo = $sqlinfo;
        
        $data = explode(' ',$sqlinfo['data']);

        $this->guid    = $sqlinfo['guid'];
        $this->account = $sqlinfo['account'];
        $this->name    = $sqlinfo['name'];
        $this->race    = $sqlinfo['race'];
	      $this->class   = $sqlinfo['class'];
	      $this->gender =  $sqlinfo['gender'];
	      
        $this->level  = $sqlinfo['level'];
	      $this->current_xp = $sqlinfo['xp'];
        $this->next_level_xp = $data[$mangos_field['PLAYER_NEXT_LEVEL_XP']];
	      $this->xp_perc = ceil($this->current_xp / $this->next_level_xp * 100);
	      $this->online = $sqlinfo['online'];
		    $this->money = $sqlinfo['money'];

        $this->map     = $sqlinfo['map'];
        $this->position_x = $sqlinfo['position_x'];
        $this->position_y = $sqlinfo['position_y'];
        
        $this->at_login = $sqlinfo['at_login'];
        
        $this->honor_points = $data[$mangos_field['PLAYER_FIELD_HONOR_CURRENCY']];
        $this->honorable_kills = $data[$mangos_field['PLAYER_FIELD_LIFETIME_HONORBALE_KILLS']];
        
        return true;
    }
    
    function RenameIsSet(){
      return (($this->at_login & 1)==1);
    }
    
    function RenameSet($val){
      $val = (($val==0) ? 0 : 1);
      if ($val == 0):
        $this->at_login = (($this->at_login >> 1) << 1); 
      else:
        $this->at_login = ($this->at_login || 1);
      endif;
      $this->sqlinfo['at_login'] = $this->at_login;
    }
    
    function MoneyAdd ($val, $mangos_field) {
      $this->money = $this->money + $val;
      if ($this->money < 0) $this->money = 0;
      $this->sqlinfo['money'] = $this->money; 
    }
    
    function ChangeGender($mangos_field, $char_models) {					
			$_gender = (($this->gender == 0) ? 1 : 0);
      $this->sqlinfo['gender'] = $_gender;											
      $this->gender = $_gender;
    }
    
    function ChangeGenderFix ($mangos_field, $char_models) {
      $data = explode(' ', $this->sqlinfo['data']);
      		
			$_skin = 1; 			//$_val & hexdec('FF');
      $_face = 1; 			//($_val >> 8) & hexdec('FF');
      $_hairStyle  = 1; //($_val >> 16) & hexdec('FF');
      $_hairColor  = 1; //($_val >> 24) & hexdec('FF');
          
			$_val = ($_skin) | ($_face << 8) | ($_hairStyle << 16) | ($_hairColor << 24);
      $data[$mangos_field['PLAYER_BYTES']] = $_val;
        
			$_val = (int)($data[$mangos_field['PLAYER_BYTES_2']]);
      $_facialHair = 1;
			$_field8 = (_val >> 8) & hexdec('FF');
      $_field16 = (_val >> 16) & hexdec('FF');
      $_field24 = (_val >> 24) & hexdec('FF');
			$_val = ($_facialHair) | ($_field8 << 8) | ($_field16 << 16) | ($_field24 << 24);
			$data[$mangos_field['PLAYER_BYTES_2']] = $_val;
					
			$this->sqlinfo['data'] = implode (' ', $data);
    }
}
 
?>
