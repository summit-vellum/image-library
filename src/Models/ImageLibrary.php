<?php

namespace Quill\ImageLibrary\Models;

use Vellum\Models\BaseModel;

class ImageLibrary extends BaseModel
{
    protected $table = 'image_libraries';
    protected $primaryKey = 'id';
    protected $fillable   = ['path', 'contributor', 'contributor_fee', 'tags', 'illustrator', 'alt_text'];

    public function scopeOrderById($query, $order = 'DESC')
    {
        return $query->orderBy('id', $order);
    }

    public function scopeWhereNameLike($query, $keyword, $excluded = null)
    {
        // try to search for the article_id first,
        // then try to search for a wild card keyword in title
        if ($excluded) {
            return $query->where('path', 'LIKE', '%'. $keyword . '%')->whereIdNotIn($excluded)
                ->orWhere('tags', 'LIKE', '%'. $keyword . '%')->whereIdNotIn($excluded);
        }else{
            return $query->where('path', 'LIKE', '%'. $keyword . '%')
                ->orWhere('tags', 'LIKE', '%'. $keyword . '%');
        }
    }

    public function history()
    {
        return $this->morphOne('Quill\History\Models\History', 'historyable');
    }

    public function resourceLock()
    {
        return $this->morphOne('Vellum\Models\ResourceLock', 'resourceable');
    }

    public function autosaves()
    {
        return $this->morphOne('Vellum\Models\Autosaves', 'autosavable');
    }

}
