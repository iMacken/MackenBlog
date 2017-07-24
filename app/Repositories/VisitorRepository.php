<?php

namespace App\Repositories;

use App\Services\IP;

class VisitorRepository extends Repository
{
    /**
     * @var IP
     */
    protected $ip;

    static $tag = 'category';

    public function tag()
    {
        return CategoryRepository::$tag;
    }

    public function model()
    {
        return app(Category::class);
    }


    /**
     * VisitorRepository constructor.
     * @param IP $ip
     */
    public function __construct(IP $ip)
    {
        $this->ip = $ip;
    }

    /**
     * Update or create the record of visitors table
     *
     * @param $post_id
     */
    public function log($post_id)
    {
        $ip = $this->ip->get();

        if ($this->hasPostIp($post_id, $ip)) {

            $this->model->where('post_id', $post_id)
                        ->where('ip', $ip)
                        ->increment('clicks');

        } else {
            $data = [
                'ip'		    => $ip,
                'post_id'    => $post_id,
                'clicks' 	    => 1
            ];
            $this->model->firstOrCreate( $data );
        }
    }
}
