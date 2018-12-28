<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

class ResumeCertificates extends \yii\db\ActiveRecord
{
   public $certificates;
   public $certificates_no;
   public $certificates_institute;
   public $certificates_year;
    
   public function rules()
   {
       
       return [
           [['certificates'],'required'],
       ];
   }
    
}
