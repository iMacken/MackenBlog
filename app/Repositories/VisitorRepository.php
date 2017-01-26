<?php

namespace App\Repositories;

use App\Repositories\Contracts\Repository;
use App\Services\IP;

class VisitorRepository extends Repository
{
    /**
     * @var IP
     */
    protected $ip;

    /**
     * VisitorRepository constructor.
     * @param IP $ip
     */
    public function __construct(IP $ip)
    {
        $this->ip = $ip;
    }

    public function model() {
        return 'App\Visitor';
    }

    /**
     * Update or create the record of visitors table
     *
     * @param $article_id
     */
    public function log($article_id)
    {
        $ip = $this->ip->get();

        if ($this->hasArticleIp($article_id, $ip)) {

            $this->model->where('article_id', $article_id)
                        ->where('ip', $ip)
                        ->increment('clicks');

        } else {
            $data = [
                'ip'		    => $ip,
                'article_id'    => $article_id,
                'clicks' 	    => 1
            ];
            $this->model->firstOrCreate( $data );
        }
    }
}
