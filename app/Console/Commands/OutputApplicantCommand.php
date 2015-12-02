<?php

namespace App\Console\Commands;

use Log;
use App\Console\ReturnCode as ConsoleReturnCode;
use App\Services\ApplicantServiceInterface;

class OutputApplicantCommand extends BaseCommand
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
        try {
            // 応募者情報一覧CSV出力
            $filename = $this->applicantService->output($options);
        } catch (\Exception $e) {
            // エラーメッセージをログへ出力
            Log::error($e->getMessage());
            // 失敗コードを返却
            return ConsoleReturnCode::FAIL;
        }
        // 出力ファイル名をコンソール上に出力
        $this->line("<info>Created File:</info> $filename");
        // 成功コードを返却
        return ConsoleReturnCode::SUCCESS;
    }
}
