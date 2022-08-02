<?php
namespace Packages\Core;

interface Repository{
    public function getModel() : Model;
    public function find($id, $columns = ['*']): Model;
    public function findAll($columns = ['*']): array;
    public function findWhere($where, $columns = ['*']);
    public function findWhereIn($field, $values, $columns = ['*']);
}