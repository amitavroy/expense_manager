<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\User;

class AddCategoryAction
{
    public function execute(array $data): Category
    {
        $data['is_active'] = true;

        return Category::create($data);
    }
}
