<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ServiceResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'imgPath' => $this->imgPath,
            // 'orderNumber'=>$this->orderNumber,
            'materialPrice' => $this->materialPrice,
            'hourPrice' => $this->hourPrice,
        ];
    }
}
