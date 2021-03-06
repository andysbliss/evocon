<?php
use PHPUnit\Framework\TestCase;

require_once "data/Defaults.php";
require_once "code/cities/city.php";
require_once "StateProcessor.php";
require_once "code/attack/AttackDeadCity.php";
require_once "code/db/DbCastle.php";
require_once "code/db/DbScout.php";
require_once "code/db/DbCity.php";
require_once "code/db/DbReportBuffer.php";
require_once "code/fields/Field.php";
require_once "code/request/ClientRequest.php";
require_once "code/reports/DeadCityReport.php";
require_once "code/reports/ScoutReport.php";
require_once "code/reports/ReportBuffer.php";
require_once "code/scout/Scouter.php";
require_once "code/script/ClientScript.php";
require_once "lib/db.php";


class ScoutReportTest extends TestCase
{
   protected $cr;
   protected $tc;
   protected $dbc;
   protected $cs;
   protected $dbcastle;
   protected $rpt;
   
   protected function setUp() {
      $this->tc = new City(json_decode(Defaults::$defaultCityJson));
      printf("\nConnecting to database.\n");
      $this->dbc = db_connectDB();
      $this->cr = new ClientRequest($this->dbc,Defaults::$server,Defaults::$player,$this->tc);
      $this->cs = new ClientScript($this->cr);
      $this->cs->startFile();
      $this->rpt = file_get_contents("data/reports/03ab5e67d55b0eec6ea762034da182af.xml");
      $this->assertNotFalse($this->rpt);
   }
   
	public function testConstructor() {
      $this->assertNotNull($this->tc);
      $this->assertNotNull($this->cr);
      $this->assertNotNull($this->cs);
      $dcr = new ScoutReport($this->rpt);
      $this->assertNotNull($dcr);
      $this->assertTrue($dcr->isSuccess());
	}
   
   public function testResources() {
      $this->assertNotNull($this->tc);
      $this->assertNotNull($this->cr);
      $this->assertNotNull($this->cs);
      $dcr = new ScoutReport($this->rpt);
      $this->assertEquals(85,$dcr->getLoyalty());
      $this->assertEquals(505000,$dcr->getFood());
   }
   
   public function testForts() {
      $this->assertNotNull($this->tc);
      $this->assertNotNull($this->cr);
      $this->assertNotNull($this->cs);
      $dcr = new ScoutReport($this->rpt);
      $this->assertEquals(1000,$dcr->getTraps());
   }
   
   public function testTroops() {
      $this->assertNotNull($this->tc);
      $this->assertNotNull($this->cr);
      $this->assertNotNull($this->cs);
      $dcr = new ScoutReport($this->rpt);
      $this->assertEquals(99,$dcr->getWorkers());
   }
   

   protected function tearDown() {
      if ($this->dbc) {
         db_disconnectDB($this->dbc);
         printf("Database closed.\n");
         if ($this->cs->isOpen()) {
            $this->cs->endFile();
         }
         $this->cs->dumpFileToStdout();
         $this->cs->purge();
      }
   }
}

?>