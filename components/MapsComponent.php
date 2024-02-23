<?php

namespace app\components;

use app\models\Map;
use yii\data\Pagination;
use yii\db\ActiveQuery;

class MapsComponent
{
    /**
     * @param ActiveQuery|Map[] $query
     * @param string|null $pageSize
     * @param string|null $sortBy
     * @return array
     */
    public function getQueryMaps(ActiveQuery|array $query, string|null $pageSize, string|null $sortBy): array
    {
        $countQuery = $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => (int)$pageSize ?? 5]);

        return [
            'maps' => $query->offset($pages->offset)
                ->orderBy(['id' => (int)$sortBy ?: SORT_DESC])
                ->limit($pages->limit)
                ->all(),
            'pages' => $pages
        ];
    }
}