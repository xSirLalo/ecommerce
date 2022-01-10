<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WelcomeController;
use App\Http\Livewire\CreateOrder;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ShoppingCart;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebhooksController;
use App\Http\Livewire\PaymentOrder;
use App\Models\Order;

Route::get('/', WelcomeController::class);

Route::get('search', SearchController::class)->name('search');

Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');

Route::get('shopping-cart', ShoppingCart::class)->name('shopping-cart');

Route::middleware(['auth'])->group(function(){

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');

    Route::get('orders/create', CreateOrder::class)->middleware('auth')->name('orders.create');

    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::get('orders/{order}/payment', PaymentOrder::class)->name('orders.payment');

    Route::get('orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');

    Route::post('webhooks', WebhooksController::class);

});

Route::get('cron', function(){
    $hora = now()->subMinute(1);

    $orders = Order::where('status', 1)->whereTime('created_at', '<=', $hora)->get();

    foreach ($orders as $order) {
        $items = json_decode($order->content);

        foreach ($items as $item) {
            increase($item);
        }

        $order->status = 5;
        $order->save();
    }

    return "Se formateo con éxito";
});
