<?php

namespace App\Models;

use App\Traits\HasSelfReferene;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class AccountCategory extends Model
{
    use HasFactory, HasSelfReferene;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'type'
    ];

    public function ledgerAccounts(): HasMany
    {
        return $this->hasMany(LedgerAccount::class);
    }

    public function generalLedgers(): HasManyThrough
    {
        return $this->hasManyThrough(GeneralLedger::class, LedgerAccount::class);
    }    

    public static function getCategoryTreeWithLeafIds($leafIds)
    {
        $rootCategories = self::whereNull('parent_id')->get();

        $data = [];

        foreach ($rootCategories as $category) {
            self::buildCategoryTree($category, collect($leafIds), $data);
        }

        return $data;
    }

    protected static function buildCategoryTree($category, $leafIds, &$tree)
    {
        $categoryLeafIds = $category->getLeafChildIds();
        $hasAnyDataLeaf = count($categoryLeafIds) > 0 && count($leafIds->intersect($categoryLeafIds)) > 0;

        if ($hasAnyDataLeaf) {
            $cat = [
                'id' => $category->id,
                'name' => $category->name,
                'children' => [],
            ];

            foreach ($category->children as $subcategory) {
                self::buildCategoryTree($subcategory, $leafIds, $cat['children']);
            }

            $tree[] = $cat;
        }
    }
}
