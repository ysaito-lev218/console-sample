<?php

namespace App\Repositories;

use App\Models\Applicant;

/**
 * Created by PhpStorm.
 */
class ApplicantRepository implements ApplicantInterface
{
    /**
     * @var
     */
    protected $applicant;

    /**
     * ApplicantRepository constructor.
     *
     * @param Applicant $applicant
     */
    public function __construct(Applicant $applicant)
    {
        $this->applicant = $applicant;
    }

    /**
     * 取得
     *
     * @param int $id 応募ID
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->applicant->where('id', $id)->get();
    }

    /**
     * 一覧取得
     *
     * @param $options
     *
     * @return mixed
     */
    public function getList(array $options)
    {
        // All.
        if (empty($options)) {
            return $this->applicant->all();
        }

        // クエリ取得
        $query = $this->applicant->query();

        // 期間指定
        if (!empty($options['start']) && !empty($options['end'])) {
            $query->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime($options['start'])), date('Y-m-d H:i:s', strtotime($options['end']))]);
        } else if (!empty($options['start'])) {
            $query->where('created_at', '>=', date('Y-m-d H:i:s', strtotime($options['start'])));
        } else if (!empty($options['end'])) {
            $query->where('created_at', '<=', date('Y-m-d H:i:s', strtotime($options['end'])));
        }

        // 学生ID指定
        if (!empty($options['student'])) {
            $query->where('student_id', ($options['student']));
        }

        // 企業ID指定
        if (!empty($options['company'])) {
            $query->where('company_id', ($options['company']));
        }

        return $query->get();
    }

    /**
     * 更新
     *
     * @param $id
     * @param $data
     *
     * @return mixed
     */
    public function update($id, $data)
    {
        // TODO: Implement update() method.
    }

    /**
     * 新規登録
     *
     * @param $data
     *
     * @return mixed
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }

    /**
     * 削除
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
    }
}