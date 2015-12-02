<?php

namespace App\Services;

interface ApplicantServiceInterface
{
    /**
     * 単体取得
     *
     * @param $id
     *
     * @return mixed
     */
    public function get($id);

    /**
     * 一覧取得
     *
     * @param $options
     *
     * @return mixed
     */
    public function getList(array $options);

    /**
     * 保存
     *
     * @param $input
     * @param $id | null
     *
     * @return $id | null
     */
    public function save($input, $id = null);

    /**
     * 削除
     *
     * @param $id
     *
     * @return $id
     */
    public function delete($id);

    /**
     * エンティティ作成
     *
     * @return $entity
     */
    public function createEntity();

    /**
     * 出力
     *
     * @param array $options
     * @return mixed
     */
    public function output(array $options);
}