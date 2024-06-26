<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Support\Facades\Notification;
use Modules\Core\Notifications\NotifyActivePlan;
use Modules\Order\Events\OrderServiceChangeStatusAfter;
use Modules\Order\Models\Order;
use Modules\Order\Notifications\CreateOrderNotification;
use Pusher\Pusher;

/**
 * Class TestMailController
 *
 * @package App\Http\Controllers\Api
 * @method getCode()
 */
class TestMailController extends Controller
{

    public function testCreateOrder()
    {
        $user = User::find(1);
        $order = Order::find(32453);
        Notification::send($user, new CreateOrderNotification($order));
        return response()->json(['success' => true]);
    }

    public function testUpdateOrder()
    {
        // $options = array(
        //     'cluster' => 'ap1',
        //     'encrypted' => true
        // );
        // $pusher = new Pusher(
        //     env('PUSHER_APP_KEY'),
        //     env('PUSHER_APP_SECRET'),
        //     env('PUSHER_APP_ID'),
        //     $options
        // );
        // $data['title'] = 'hello world';

        // $pusher->trigger('orders.32533', 'App\Events\VideoProcessed', $data);


        // $pusher->sendToUser('user-id', 'event-name', ['message' => 'hello world']);
        $user = User::find(35667);
        $order = Order::find(10);
        $planSubscription = $user->planSubscription('vip');
        // dd($user);
        Notification::send($user, new NotifyActivePlan($order, $planSubscription));
        // event(new OrderServiceChangeStatusAfter($order));
        return response()->json(['success' => true]);
    }

    public function testEvent()
    {
        $order = Order::find(32533);
        event(new OrderServiceChangeStatusAfter($order));
        return response()->json(['success' => true]);
    }
}
