<?php

namespace App\Services;

use PHPExcel;
use PHPExcel_IOFactory;
use Illuminate\Validation\Factory as ValidateFactory;
use App\Repositories\ApplicantInterface;

class ApplicantService implements ApplicantServiceInterface
{
    /**
     * @var ApplicantInterface
     */
    protected $applicantInterface;

    /**
     * @var ValidateFactory
     */
    protected $validateFactory;

    /**
     * @var array
     */
    protected $rules = [
        "title" => "required|max: 100",
        "price" => "required|integer|min:0|max:100000",
        "url"   => "required",
    ];

    /**
     * ApplicantService constructor.
     *
     * @param ApplicantInterface $applicantInterface
     * @param ValidateFactory $validateFactory
     */
    public function __construct(ApplicantInterface $applicantInterface, ValidateFactory $validateFactory)
    {
        $this->applicantInterface = $applicantInterface;
        $this->validateFactory    = $validateFactory;
    }

    /**
     * 単体取得
     *
     * @param $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return $this->applicantInterface->get($id);
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
        return $this->applicantInterface->getList($options);
    }

    /**
     * 保存
     *
     * @param $input
     * @param null $id
     *
     * @return null
     */
    public function save($input, $id = null)
    {
//        $input = $request->only(['title', 'price', 'url']);
//        $v = $this->validateFactory->make($input, $this->rules);
//        if ($v->fails()) {
//            return null;
//        }
//
//        if (is_null($id)) {
//            $id = $this->applicantInterface->create($input);
//        } else {
//            $id = $this->applicantInterface->update($id, $input);
//        }
//
//        return $id;
    }

    /**
     * 削除
     *
     * @param int $id 応募ID
     *
     * @return bool
     */
    public function delete($id)
    {
        $this->applicantInterface->delete($id);
        return true;
    }

    /**
     * エンティティ作成
     *
     * @return $entity
     */
    public function createEntity()
    {
        return $this->applicantInterface->createEntity();
    }

    /**
     * 応募者情報をCSVファイル出力
     *
     * @param array $options
     *
     * @return mixed|void
     *
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public function output(array $options)
    {
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();

        $list = $this->getList($options);

        $line = 0;
        foreach ($list as $applicant) {
            $sheet->setCellValueByColumnAndRow(0, $line, $applicant->id);         // 応募ID
            $sheet->setCellValueByColumnAndRow(1, $line, $applicant->student_id); // 学生ID
            $sheet->setCellValueByColumnAndRow(2, $line, $applicant->company_id); // 企業ID
//                $sheet->setCellValueByColumnAndRow(3, $line, $applicant->created_at); // 応募日時
            $line++;
        }

        $writer = PHPExcel_IOFactory::createWriter($excel, 'CSV');
        $datetime = date('YmdHis');
        $filename = "/tmp/applicant_list_{$datetime}.csv";
        $writer->save($filename);

        return $filename;
    }
}