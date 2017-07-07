<?php
namespace Drupal\custom_form\services;

use Drupal\Core\Database\Connection;

class DatabaseQuery {

  protected $connection;

  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  public function insertQuery($form_data)
  {

    return $this->connection->insert('d8_demo')->fields($form_data)->execute();

  }

  public function fetchData()
   {
    $result=$this->connection->select('d8_demo','d8')->fields('d8',['first_name','last_name'])->execute();
      while($row = $result->fetchAssoc()){
        $output .= $row['first_name'];
        $output .= $row['last_name'];
      }
        return $output;
   }


  }

