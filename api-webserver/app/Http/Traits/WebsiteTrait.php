<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\Pure;

/**
 *
 */
trait WebsiteTrait
{


    /**
     * @return array
     */
    #[Pure]
    public static function standardForm(): array
    {
        if (property_exists(self::class, 'form')) {
            return self::$form;
        } else {
            $form = [];
            $model = (new self());
            foreach ($model->fillable as $fill) {
                if (!in_array($fill, $model->hidden)) {
                    $form[]['name'] = $fill;
                }
            }

            return $form;
        }
    }

    /**
     * @param string|array $extra
     * @param bool $show_relation
     * @return array
     */
    public static function getCollectionsStandardColumns(string|array $extra, bool $show_relation = false): array
    {
        $collection = self::all();
        $res = [];
        foreach ($collection as $item) {
            $res[] = $item->getStandardColumns($extra, $show_relation);
        }
        return $res;

    }

    public static function standardRelationList(): array
    {
        $relations = self::standardRelationInfo();
        $r = [];
        foreach ($relations as $rel_name => $rel_data) {
            if (empty($rel_data['relation_info']['method_select'])) {
                $r[$rel_name] = $rel_data['relation_info']['select_model']::select($rel_data['with'] ?? '*')->orderBy('id')->get()->toArray();
            }
        }

        return $r;

    }

    public static function standardRelationInfo()
    {
        if (property_exists(self::class, 'form')) {
            $form = self::$form;
            $r = [];
            foreach ($form as $el) {
                if ((isset($el['relation']) && $el['relation'] === true)) {
                    $r[$el['name']] = $el;
                }
            }
        } else {
            $r = [];
        }
        return $r;

    }

    /**
     * @param array|string $extra
     * @param bool $show_relation
     * @return array
     */
    public function getStandardColumns(array|string $extra = [], bool $show_relation = false): array
    {
        $extra = is_string($extra) ? [$extra] : $extra;
        $columns = self::standardColumns($extra, $show_relation);
        $relations_map = $show_relation ? self::standardRelation() : [];
        $return = [];
        foreach ($columns as $col) {
            if (!is_object($this->$col)) {
                $return[$col] = $this->$col;
            } else {
                $relations = $this->$col;
                $return[$col] = [];
                if (get_class($this->$col) === Collection::class) {
                    /** @var Collection $relations */
                    if (
                        !isset($relations_map[$col]) ||
                        in_array('*', $relations_map[$col])) {
                        $return[$col] = $relations->toArray();
                    } else {
                        foreach ($relations as $k => $rel) {
                            foreach ($relations_map[$col] as $map) {
                                $return[$col][$k][$map] = $rel->$map;
                            }
                        }
                    }
                } else {
                    foreach ($relations_map[$col] as $k) {
                        $return[$col][$k] = $relations[$k];
                    }
                }

            }

        }

        return $return;

    }

    /**
     * @param array|string $extra
     * @param bool $show_relation
     * @return array
     */
    #[Pure]
    public static function standardColumns(array|string $extra = [], bool $show_relation = false): array
    {
        $extra = is_string($extra) ? [$extra] : $extra;

        if (property_exists(self::class, 'form')) {

            $form = self::$form;
            $r = [];
            foreach ($form as $el) {
                if (
                    (!isset($el['hidden']) || $el['hidden'] !== true) &&
                    (!isset($el['primary']) || $el['primary'] !== true)
                ) {
                    if (
                        $show_relation === true ||
                        (!isset($el['relation']) || $el['relation'] !== true)
                    ) {
                        $r[] = $el['name'];
                    }
                }
            }
        } else {
            $r = (new self())->fillable;
        }
        return array_merge($extra, $r);
    }

    /**
     * @return array
     */
    public static function standardRelation(): array
    {
        if (property_exists(self::class, 'form')) {
            $form = self::$form;
            $r = [];
            foreach ($form as $el) {
                if ((isset($el['relation']) && $el['relation'] === true)) {
                    $r[$el['name']] = $el['with'] ?? ['*'];
                }
            }
        } else {
            $r = [];
        }
        return $r;
    }

    public function updateStandardColumns($updata_data)
    {
        $relations = self::standardRelationInfo();


        foreach (array_keys($relations) as $rel) {
            $relation_info = $relations[$rel]['relation_info'];
            if ($relation_info['model_update'] !== false) {
                if (get_class($this) === $relation_info['model_update']) {
                    $updata_data[$relation_info['method_update_key']] = 'asd';
                    if (array_key_exists($rel, $updata_data)) {
                        $updata_data[$relation_info['method_update_key']] = $updata_data[$rel];
                        unset($updata_data[$rel]);
                    } else {
                        $updata_data[$relation_info['method_update_key']] = null;
                    }

                } else {
                    dd($rel, $updata_data[$rel], $relations);
                    //TODO: try for standard table
                }
            } else {
                unset($updata_data[$rel]);
            }
        }

        $this->fill($updata_data);

        $this->save();

    }


}
