<?php

namespace Panel;

use Panel\Login;
use SysHandler\DB;
use Models\Login as LL;
use Panel\DeepControllers\BBN2;
use Panel\DeepControllers\ETilang;
use Panel\DeepControllers\ErrorPage;
use Panel\DeepControllers\TilangForm;
use Panel\DeepControllers\InputETilang;
use Panel\DeepControllers\JadwalSIMKeliling;
use Panel\DeepControllers\JadwalSAMSATKeliling;

class BotPanel
{
    /**
     * Panel\Login
     */
    private $login;
    
    /**
     * Constructor.
     */
    public function __construct(Login $login)
    {
        $this->login = $login;
    }
    
    public function run()
    {
        include __DIR__.'/../helpers/pg.php';
        if (!isset($_GET['pg'])) {
            include __DIR__.'/../views/panel_index.php';
        } else {
            switch (strtolower($_GET['pg'])) {
            case 'jadwal_samsat_keliling':
                    $app = new JadwalSAMSATKeliling();
                    $app->run();
                break;
            case 'jadwal_sim_keliling':
                    $app = new JadwalSIMKeliling();
                    $app->run();
                break;
            case 'data_bbn2':
                    $app = new BBN2();
                    $app->run();
                break;
            case 'etilang':
                    $app = new ETilang();
                    $app->run();
                break;
            case 'etilang_fr':
                    $app = new TilangForm();
                    $app->run();
                break;
            case 'logout':
                    LL::logout_session(base64_decode($_COOKIE['sess']), base64_decode($_COOKIE['user']));
                    setcookie("sess", null, null);
                    setcookie("user", null, null);
                    header("location:?");
                die(1);
                break;
            case 'input_etilang':
                    InputETilang::run();
                break;
            default:
                    $app = new ErrorPage();
                    $app->run(404);
                break;
            }
        }
    }
}
