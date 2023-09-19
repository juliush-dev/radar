<?php

namespace App\Services;


class QueryResultTransformer
{

    public function __construct(private RadarQuery $rq)
    {
    }
    public function groupsAsOptions()
    {
        $options = $this->rq->groups()->reduce(function ($acc, $group) {
            array_push(
                $acc,
                [
                    'id' => $group->id,
                    'label' => ucfirst($group->title),
                ]
            );
            return $acc;
        }, []);
        return $options;
    }
    public function fieldsAsOptions()
    {
        $options = $this->rq->fields()->reduce(function ($acc, $field) {
            array_push(
                $acc,
                [
                    'id' => $field->id,
                    'label' => ucfirst($field->title),
                ]
            );
            return $acc;
        }, []);
        return $options;
    }

    public function subjectsAsOptions()
    {
        $options = $this->rq->subjects()->reduce(function ($acc, $subject) {
            array_push(
                $acc,
                [
                    'id' => $subject->id,
                    'label' => ucfirst($subject->title),
                ]
            );
            return $acc;
        }, []);
        return $options;
    }
}
