<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewOrModify(User $user, Product $product): Response
    {
        return $user->id === $product->company->user_id ? Response::allow() : Response::denyAsNotFound();
    }
}
