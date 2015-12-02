## console-sample

### サンプルコード

応募者一覧をCSV出力します。

```
php artisan applicant:output

-- オプション
php artisan applicant:output --start=20151110000000
php artisan applicant:output --end=20151104235959
php artisan applicant:output --student=1
php artisan applicant:output --company=2010
```

[OutputApplicantCommand.php](https://github.com/ysaito-lev218/console-sample/blob/master/app/Console/Commands/OutputApplicantCommand.php)

### ベースコード

[Command.php](https://github.com/ysaito-lev218/console-sample/blob/master/app/Console/Commands/Command.php)

* 二重起動防止（データベースでの管理ではないです...）
* 共通のログ出力
