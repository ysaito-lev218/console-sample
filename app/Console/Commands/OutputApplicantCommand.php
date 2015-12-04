<?php

namespace App\Console\Commands;

use App\Services\ApplicantServiceInterface;

class OutputApplicantCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applicant:output {--start= : 期間(開始)を指定してください。}
        {--end= : 期間(終了)を指定してください。}
        {--student= : 学生IDを指定してください。}
        {--company= : 企業IDを指定してください。}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '応募者情報一覧をCSV出力します。';

    /**
     * The applicant service calss.
     *
     * @var ApplicantServiceInterface
     */
    private $applicantService;

    /**
     * コンストラクタ.
     *
     * @param ApplicantServiceInterface $applicantServiceInterface
     */
    public function __construct(ApplicantServiceInterface $applicantServiceInterface)
    {
        parent::__construct();

        // サービスクラスを設定
        $this->applicantService = $applicantServiceInterface;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // オプションを取得
        $options = $this->option();

        // 応募者情報一覧CSV出力
        $result = $this->applicantService->output($options);

        return $result ? parent::SUCCESS : parent::FATAL_ERROR;
    }
}
