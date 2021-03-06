<?php

class ScoutReport {
   
   var $m_report;
   var $m_doc;
   var $m_reportData;
   
   var $m_workers        = 0;
   var $m_warriors       = 0;
   var $m_scouts         = 0;
   var $m_pike           = 0;
   var $m_swords         = 0;
   var $m_archer         = 0;
   var $m_transporter    = 0;
   var $m_cavalry        = 0;
   var $m_cataphract     = 0;
   var $m_ballista       = 0;
   var $m_rams           = 0;
   var $m_catapult       = 0;
   
   var $m_traps          = 0;
   var $m_abatis         = 0;
   var $m_ats            = 0;
   var $m_logs           = 0;
   var $m_trebs          = 0;
   
   var $m_loyalty        = 0;
   var $m_food           = 0;
   var $m_wood           = 0;
   var $m_iron           = 0;
   var $m_stone          = 0;
   var $m_gold           = 0;
   
   
   public function __construct($report) {
      $this->m_report = $report;
      $this->m_doc = new DOMDocument;
      $this->m_reportData = @simplexml_load_string($report);
      if ($this->isSuccess()) {
         $this->parseResources();
         $this->parseTroops();
         $this->parseFortifications();
      }
   }
   
   public function getLoyalty() { return $this->m_loyalty; }
   public function getFood()    { return $this->m_food;    }
   public function getWood()    { return $this->m_wood;    }
   public function getIron()    { return $this->m_iron;    }
   public function getStone()   { return $this->m_stone;   }
   public function getGold()    { return $this->m_gold;    }
   
   public function getWorkers() { return $this->m_workers; }
   public function getWarriors() { return $this->m_warriors; }
   public function getScouts() { return $this->m_scouts; }
   public function getPike() { return $this->m_pike; }
   public function getSwords() { return $this->m_swords; }
   public function getArchers() { return $this->m_archer; }
   public function getTransporters() { return $this->m_transporter; }
   public function getCavalry() { return $this->m_cavalry; }
   public function getCataphract() { return $this->m_cataphract; }
   public function getBallista() { return $this->m_ballista; }
   public function getRams() { return $this->m_rams; }
   public function getCatapult() { return $this->m_catapult; }
   
   public function getTraps() { return $this->m_traps; }
   public function getAbatis() { return $this->m_abatis; }
   public function getAts() { return $this->m_ats; }
   public function getLogs() { return $this->m_logs; }
   public function getTrebs() { return $this->m_trebs; }
   
   
   public function isSuccess() {
      $v = false;
      if ($this->m_reportData != NULL && 
          $this->m_reportData[0]->scoutReport->attributes()["isSuccess"] == "true") {
          $v = true;
      }
      return $v;
   }
   
   protected function parseResources() {
      $this->m_loyalty = (integer) $this->m_reportData[0]->scoutReport->scoutInfo->attributes()["support"];
      $this->m_food    = (integer) $this->m_reportData[0]->scoutReport->scoutInfo->resource->food;
      $this->m_wood    = (integer) $this->m_reportData[0]->scoutReport->scoutInfo->resource->wood;
      $this->m_iron    = (integer) $this->m_reportData[0]->scoutReport->scoutInfo->resource->iron;
      $this->m_stone   = (integer) $this->m_reportData[0]->scoutReport->scoutInfo->resource->stone;
      $this->m_gold    = (integer) $this->m_reportData[0]->scoutReport->scoutInfo->attributes()["gold"];
   }

   protected function parseFortifications() {
      $node = $this->m_reportData[0]->scoutReport->scoutInfo->fortifications;
      if (isset($node->fortificationsType)) {
         foreach ($node->fortificationsType as $fort) {
            $typeid = (integer) $fort->attributes()["typeId"];
            $count = (integer) $fort->attributes()["count"];
            switch ($typeid) {
               case 14: // traps
                  $this->m_traps = $count;
                  break;
               case 15: // abatis
                  $this->m_abatis = $count;
                  break;
               case 16: // archer towers
                  $this->m_ats = $count;
                  break;
               case 17: // rolling logs
                  $this->m_logs = $count;
                  break;
               case 18: // trebuchet
                  $this->m_trebs = $count;
                  break;
               default:
                  break;
            }
         }
      }
   }
   protected function parseTroops() {
      $node = $this->m_reportData[0]->scoutReport->scoutInfo->troops;
      if (isset($node->troopStrType)) {
         foreach ($node->troopStrType as $troop) {
            $typeid = (integer) $troop->attributes()["typeId"];
            $count = (integer) $troop->attributes()["count"];
            switch ($typeid) {
               case 2: // workers
                  $this->m_workers = $count;
                  break;
               case 3: // warriors
                  $this->m_warriors = $count;
                  break;
               case 4: // scouts
                  $this->m_scouts = $count;
                  break;
               case 5: // pike
                  $this->m_pike = $count;
                  break;
               case 6: // sword
                  $this->m_swords = $count;
                  break;
               case 7: // archer
                  $this->m_archer = $count;
                  break;
               case 8: // transporter
                  $this->m_transporter = $count;
                  break;
               case 9: // cavalry
                  $this->m_cavalry = $count;
                  break;
               case 10: // cataphract
                  $this->m_cataphract = $count;
                  break;
               case 11: // ballista
                  $this->m_ballista = $count;
                  break;
               case 12: // rams
                  $this->m_rams = $count;
                  break;
               case 13: // catapult
                  $this->m_catapult = $count;
                  break;
               default:
                  break;
            }
         }
      }
      
   }

      
   
}
?>
