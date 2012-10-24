<?php
/**
 *  Copyright 2011 Wordnik, Inc.
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

/**
 * $model.description$
 *
 * NOTE: This class is auto generated by the swagger code generator program. Do not edit the class manually.
 *
 */
class QuestionnaireExecutionInfo {

  static $swaggerTypes = array(
      'id' => 'float',
      'datasource_id' => 'float',
      'guid' => 'string',
      'executive' => 'UserIdentity',
      'document' => 'DocumentIdentity',
      'collector_id' => 'float',
      'collector_guid' => 'string',
      'status' => 'string',
      'approver' => 'UserIdentity',
      'owner' => 'UserIdentity',
      'questionnaire_name' => 'string',
      'modified' => 'int'

    );

  public $id; // float
  public $datasource_id; // float
  public $guid; // string
  public $executive; // UserIdentity
  public $document; // DocumentIdentity
  public $collector_id; // float
  public $collector_guid; // string
  public $status; // string
  public $approver; // UserIdentity
  public $owner; // UserIdentity
  public $questionnaire_name; // string
  public $modified; // int
  }
