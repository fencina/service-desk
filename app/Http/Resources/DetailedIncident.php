<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailedIncident extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "category_id" => $this->category_id,
            "description" => $this->description,
            "priority_id" => $this->priority_id,
            "user_id" => $this->user_id,
            "creator_id" => $this->creator_id,
            "assigned_id" => $this->assigned_id,
            "assigned_group_id" => $this->assigned_group_id,
            "date_ocurred" => $this->date_ocurred,
            "source_id" => $this->source_id,
            "status_id" => $this->status_id,
            "type_id" => $this->type_id,
            "created_at" => $this->created_at,
            "last_update" => $this->last_update,
            "process_id" => $this->process_id,
            "solved_at" => $this->solved_at,
            "closed_at" => $this->closed_at,
            "closed_reason" => $this->closed_reason,
            "data_cleaned" => $this->data_cleaned,
            "attachments" => $this->attachments
        ];
    }
}
