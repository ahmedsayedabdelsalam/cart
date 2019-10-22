<?php

namespace App\Http\Resources;

class ProductResource extends ProductIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'stock_count' => $this->stockCount(),
            'in_stock' => $this->inStock(),
            'variations' => ProductVariationResource::collection(
                $this->variations->groupBy('type.name')
            ),
        ]);
    }
}
