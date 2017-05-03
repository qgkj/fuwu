<?php
  
namespace Ecjia\System\Notifications;

use Royalcms\Component\Notifications\Notification;
// use Royalcms\Component\Notifications\Messages\MailMessage;

/**
 * 配送员取货
 */
class ExpressPickup extends Notification
{
    
	private $notifiable_data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($express_data)
    {
        //
        $this->notifiable_data = $express_data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return array('database');
    }

//     /**
//      * Get the mail representation of the notification.
//      *
//      * @param  mixed  $notifiable
//      * @return \Royalcms\Component\Notifications\Messages\MailMessage
//      */
//     public function toMail($notifiable)
//     {
//         return with(new MailMessage)
//                     ->line('The introduction to the notification.')
//                     ->action('Notification Action', 'https://ecjia.com')
//                     ->line('Thank you for using our application!');
//     }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray()
    {
//         return array(
//         	'user_name' => 'admin',
//             'order_sn' => '12344421111233332',
//             'goods_name' => 'test',
//         );
        return $this->notifiable_data;
    }
}
