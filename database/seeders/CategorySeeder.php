<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            'Cloud' => ['Azure', 'AWS', 'Google Cloud'],
            'Containers' => ['Docker', 'Kubernetes'],
            'CI/CD' => ['Jenkins', 'GitHub Actions'],
            'IaC' => ['Terraform', 'Ansible'],
        ];

        $order = 0;
        foreach ($tree as $parentName => $children) {
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($parentName)],
                ['name' => $parentName, 'slug' => Str::slug($parentName), 'parent_id' => null, 'sort_order' => $order++]
            );

            $childOrder = 0;
            foreach ($children as $childName) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($childName)],
                    ['name' => $childName, 'slug' => Str::slug($childName), 'parent_id' => $parent->id, 'sort_order' => $childOrder++]
                );
            }
        }
    }
}
