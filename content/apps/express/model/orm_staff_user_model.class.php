<?php
  
use Royalcms\Component\Notifications\Notifiable;
defined('IN_ECJIA') or exit('No permission resources.');

class orm_staff_user_model extends Notifiable {
	protected $table       = 'staff_user';
	protected $primaryKey  = 'user_id';
}

// end
