<?php

namespace metronic;

use yii\i18n\Formatter;
use yii\base\Action;
use yii;

/**
 * Class DataTablesAction
 * @package metronic
 */
class DataTablesAction extends Action
{
    /**
     * @var yii\db\ActiveQuery|\Closure
     */
    public $query;

    /**
     * @var int[]
     */
    public $length = 25;

    /**
     * @var array model columns
     *
     * ```php
     * [
     *     'ColumnName' => [
     *         'queryAlias' => 'm.column_name',
     *         'modelAlias' => 'column_name',
     *         'format' => 'text',
     *         'searchable' => false, // default true
     *         'sortable' => true, // default true
     *         'searchCondition' => function ($searchQuery) {},
     *         'searchTemplate' => '={query}', // '%{query}', '%{query}%'
     *     ],
     * ]
     * ```
     */
    public $columns = [];

    /**
     * @var array|Formatter
     */
    public $formatter;

    /**
     * @var array
     */
    public $defaultOrder = [];

    /**
     * @var array
     */
    private $request = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->query === null) {
            throw new yii\base\InvalidConfigException('"query" cannot be null');
        }

        if ($this->formatter === null) {
            $this->formatter = Yii::$app->getFormatter();
        } elseif (is_array($this->formatter)) {
            $this->formatter = Yii::createObject($this->formatter);
        }

        if (!$this->formatter instanceof Formatter) {
            throw new yii\base\InvalidConfigException('The "formatter" property must be either a Format object or a configuration array.');
        }

        $this->length = (array) $this->length;
        sort($this->length);
    }

    /**
     * @return yii\web\Response
     */
    public function run()
    {
        if (!Yii::$app->request->isAjax) {
            throw new yii\web\BadRequestHttpException('Method is not allowed');
        }

        $this->initRequestData();

        /** @var yii\db\ActiveQuery $query */
        if ($this->query instanceof \Closure) {
            $query = call_user_func($this->query, $this);
        } else {
            $query = $this->query;
        }

        $countQuery = clone $query;
        $totalRecords = $totalDisplay = (int) $countQuery->count();
        $data = [];

        if ($totalRecords === 0) {
            goto result;
        }

        $orConditions = ['or'];
        $andConditions = ['and'];

        $defaultSearchValue = $this->request['search']['value'];

        foreach ($this->request['columns'] as $column) {
            $colData = $this->columns[$column['data']];

            if (isset($colData['searchable']) && $colData['searchable'] === false) {
                continue;
            }

            $searchValue = $column['search']['value'] !== '' ? $column['search']['value'] : $defaultSearchValue;

            if ($searchValue === '') {
                continue;
            }

            if (isset($colData['searchCondition']) && $colData['searchCondition'] instanceof \Closure) {
                $condition = call_user_func($colData['searchCondition'], $searchValue);
            } else {
                $columnName = isset($colData['queryAlias']) ? $colData['queryAlias'] : (isset($colData['modelAlias']) ? $colData['modelAlias'] : $column['data']);
                $searchTemplate = isset($colData['searchTemplate']) ? $colData['searchTemplate'] : '%{query}%';

                if ($searchTemplate[0] === '=') {
                    $condition = [$columnName => $searchValue];
                } else {
                    $searchValue = strtr($searchValue, [
                        '%' => '\%',
                        '_' => '\_',
                        '\\' => '\\\\',
                    ]);

                    $condition = ['like', $columnName, strtr($searchTemplate, ['{query}' => $searchValue]), false];
                }
            }

            if ($condition) {
                if ($column['search']['and']) {
                    $andConditions[] = $condition;
                } else {
                    $orConditions[] = $condition;
                }
            }
        }

        if (count($orConditions) === 1 && count($andConditions) === 1) {
            $conditions = [];
        } else {
            $conditions = $andConditions;

            if (count($orConditions) > 1) {
                $conditions[] = $orConditions;
            }
        }

        if (count($conditions) > 1) {
            $query->andWhere($conditions);
            $countQuery = clone $query;

            $totalDisplay = (int) $countQuery->count();

            if ($totalDisplay === 0) {
                goto result;
            }
        }

        foreach ($this->request['order'] as $order) {
            $query->addOrderBy($order);
        }

        $query->limit($this->request['length']);
        $query->offset($this->request['start']);

        $models = $query->all();

        foreach ($models as $model) {
            $dataRow = [];

            foreach ($this->columns as $columnName => $column) {
                $attribute = isset($column['modelAlias']) ? $column['modelAlias'] : $columnName;
                $value = $model->{$attribute};

                if (isset($column['format'])) {
                    if ($column['format'] instanceof \Closure) {
                        $value = call_user_func($column['format'], $value);
                    } else {
                        $value = $this->formatter->format($value, $column['format']);
                    }
                }

                $dataRow[$columnName] = $value;
            }

            $data[] = $dataRow;
        }

        result:

        $result = [
            'iTotalRecords'        => $totalRecords,
            'iTotalDisplayRecords' => $totalDisplay,
            'sEcho'                => $this->request['sEcho'],
            'sColumns'             => '',
            'aaData'               => $data,
        ];

        return $this->controller->asJson($result);
    }

    private function initRequestData()
    {
        $requestColumns = Yii::$app->request->get('columns', []);
        $columns = [];

        if (is_array($requestColumns)) {
            foreach ($requestColumns as $column) {
                $data = isset($column['data']) ? $column['data'] : null;
                $name = (string) (isset($column['name']) ? $column['name'] : '');
                $searchable = $this->booleanValue(isset($column['searchable']) ? $column['searchable'] : true);
                $orderable = $this->booleanValue(isset($column['orderable']) ? $column['orderable'] : true);
                $search = ['value' => '', 'regex' => false];

                if ($data === null || is_array($data) || (string) $data === '') {
                    continue;
                }

                if (!isset($this->columns[$data])) {
                    continue;
                }

                if ($name === 'Array') {
                    $name = '';
                }

                if (isset($column['search']) && is_array($column['search'])) {
                    $search['value'] = (string) (isset($column['search']['value']) ? $column['search']['value'] : '');
                    $search['regex'] = $this->booleanValue(isset($column['search']['regex']) ? $column['search']['regex'] : false);
                    $search['and'] = $this->booleanValue(isset($column['search']['and']) ? $column['search']['and'] : false);
                    $search['value'] = trim(strip_tags($search['value']));

                    if ($search['value'] === 'Array') {
                        $search['value'] = '';
                    }
                }

                $columns[] = [
                    'data' => (string) $data,
                    'name' => (string) $name,
                    'searchable' => (boolean) $searchable,
                    'orderable' => (boolean) $orderable,
                    'search' => (array) $search,
                ];
            }
        }

        $requestOrder = Yii::$app->request->get('order', []);
        $order = [];

        if (is_array($requestOrder)) {
            foreach ($requestOrder as $row) {
                if (!isset($row['column']) || !is_numeric($row['column'])) {
                    continue;
                }

                if (!isset($columns[(int) $row['column']])) {
                    continue;
                }


                $column = $columns[(int) $row['column']]['data'];
                $colData = $this->columns[$column];

                if (isset($colData['sortable']) && $colData['sortable'] === false) {
                    continue;
                }

                $column = isset($colData['queryAlias']) ? $colData['queryAlias'] : (isset($colData['modelAlias']) ? $colData['modelAlias'] : $column);

                $dir = SORT_ASC;

                if (isset($row['dir']) && is_string($row['dir'])) {
                    switch (strtoupper($row['dir'])) {
                        case 'ASC':
                            $dir = SORT_ASC;
                            break;
                        case 'DESC':
                            $dir = SORT_DESC;
                            break;
                    }
                }

                $order[] = [$column => $dir];
            }
        }

        if (count($order) === 0) {
            if (is_array($this->defaultOrder)) {
                $order = $this->defaultOrder;
            } else {
                $order = [$this->defaultOrder];
            }
        }

        $start = (int) Yii::$app->request->get('start', 0);

        $requestLength = (int) Yii::$app->request->get('length', 0);
        $length = 0;

        if (!in_array($requestLength, $this->length)) {
            foreach ($this->length as $len) {
                $length = $len;

                if ($requestLength <= $len) {
                    break;
                }
            }
        } else {
            $length = $requestLength;
        }

        $requestSearch = Yii::$app->request->get('search', []);
        $search = ['value' => '', 'regex' => false];

        if (is_array($requestSearch)) {
            $search['value'] = (string) (isset($requestSearch['value']) ? $requestSearch['value'] : '');
            $search['regex'] = $this->booleanValue(isset($requestSearch['regex']) ? $requestSearch['regex'] : false);

            $search['value'] = trim(strip_tags($search['value']));

            if ($search['value'] === 'Array') {
                $search['value'] = '';
            }
        }

        $draw = (int) Yii::$app->request->get('draw', 0);
        $sEcho = (int) Yii::$app->request->get('sEcho', 0);

        $this->request = [
            'draw' => $draw,
            'columns' => $columns,
            'order' => $order,
            'start' => $start,
            'length' => $length,
            'search' => $search,
            'sEcho' => $sEcho,
        ];
    }

    /**
     * @param $value
     * @return bool
     */
    private function booleanValue($value)
    {
        if (is_bool($value)) {
            return (boolean) $value;
        }

        if ($value == '1' || $value == 'true') {
            return true;
        }

        return false;
    }
}