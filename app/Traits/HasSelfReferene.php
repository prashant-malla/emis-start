<?php

namespace App\Traits;

use Illuminate\Database\Query\Builder;

trait HasSelfReferene
{
    protected $parentColumn = 'parent_id';

    public function parent()
    {
        return $this->belongsTo(static::class);
    }

    public function children()
    {
        return $this->hasMany(static::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function root()
    {
        return $this->parent
            ? $this->parent->root()
            : $this;
    }

    public function getLeafChildIds()
    {
        $leafChildIds = [];

        $this->load('allChildren');
        $this->collectLeafChildIds($this, $leafChildIds);

        return $leafChildIds;
    }

    protected function collectLeafChildIds($item, &$leafChildIds)
    {
        if ($item->allChildren->isEmpty()) {
            $leafChildIds[] = $item->id;
        }

        foreach ($item->allChildren as $child) {
            $this->collectLeafChildIds($child, $leafChildIds);
        }
    }

    public function getAllChildIds()
    {
        $allChildIds = [];

        $this->load('allChildren');
        $this->collectAllChildIds($this, $allChildIds);

        return $allChildIds;
    }

    protected function collectAllChildIds($item, &$allChildIds)
    {
        $allChildIds[] = $item->id;

        foreach ($item->allChildren as $child) {
            $this->collectAllChildIds($child, $allChildIds);
        }
    }
}
