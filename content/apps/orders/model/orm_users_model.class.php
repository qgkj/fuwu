<?php
  
use Royalcms\Component\Notifications\Notifiable;
defined('IN_ECJIA') or exit('No permission resources.');

class orm_users_model extends Notifiable {
	protected $table = 'users';
	protected $primaryKey = 'user_id';

}

// end
