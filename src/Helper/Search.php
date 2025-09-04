<?php


namespace DLaravel\Helper;

use Laravel\Scout\EngineManager;
use Laravel\Scout\Scout;

class Search
{
    /**
     * 搜索关键词
     *
     * @param $q
     * @return array
     */
    static public function query($model, $q)
    {
        return Cache::cacheCall([__CLASS__, __FILE__, $model, $q], function ($model, $search) {
            return $model::search($search)->paginate(9999, 'a', 1)->pluck('id');
        }, [$model, $q], 1);
    }


    static public function queryIndex2Id($model, $q)
    {
        return Cache::cacheCall([__CLASS__, __FILE__, $model, $q], function ( $model, $search) {

            /**
             * @var \Illuminate\Pagination\Paginator $res
             */
            $res =  $model::search($search)->simplePaginateRaw(9999, 'a', 1);

            $ids = array_column($res->items()['hits'],'id');

//            dump($ids);
//             dd($res->items(),$ids);
             return $ids;
        }, [$model, $q], 1);
    }

}
