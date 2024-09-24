<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Item;
use App\Policies\ChatPolicy;
use App\Policies\ItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Item::class => ItemPolicy::class,
        Chat::class => ChatPolicy::class
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
