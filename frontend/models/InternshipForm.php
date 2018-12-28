<?php
namespace frontend\models;
use Yii;
use yii\base\Model;
/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class InternshipForm extends Model {

    public $name;
    public $email;
    public $address;
    public $contactnumber;
    public $typeoforganisation;
    public $backgroundoforganisation;
    public $differentdepartments;
    public $headoffice;
    public $tieups;
    public $mobilenumber;
    public $addressforinterview;
    public $primaryfield;
    public $fieldofwork;
    public $typeofstipend;
    public $cities;
    public $islaptoprequired;
    public $employeebenefitorwelfarepolicies;
    public $specialskillsrequired;
    public $numberofapplicantsrequired;
    public $earliestjoiningdate;
    public $from;
    public $to;
    public $stipendpaid;
    public $mentionhere;
    public $other;
    public $questions;
    public $checkbox1;
    public $quisionare;
    public $internshiptitle;
    public $internshiptype;
    public $internshipduration;
    public $internshipduration1;
    public $internshipdescription;
    public $interviewstart;
    public $interviewend;
    public $interviewdate;
    public $interviewcity;

    public function rules() {
        return [
            [['questions','name', 'email', 'address', 'contactnumber', 'typeoforganisation', 'backgroundoforganisation', 'differentdepartments',
            'headoffice',
            'tieups',
            'mobilenumber',
            'primaryfield',
            'fieldofwork',
            'addressforinterview',
            'cities',
            'typeofstipend',
            'specialskillsrequired',
            'numberofapplicantsrequired',
            'islaptoprequired',
            'earliestjoiningdate',
            'from',
            'to',
            'stipendpaid',
            'other',
            'questions',
            'question4',
            'internshiptitle',
            'internshiptype',
            'internshipduration',
            'internshipduration1',
            'internshipdescription',
                ], 'required']];
    }

    public function attributeLabels() {
        return[
            'id' => Yii::t('frontend', 'ID'),
            'employer_enc_id' => Yii::t('frontend', 'Employer Enc ID'),
            'name' => Yii::t('frontend', 'Name'),
            'address' => Yii::t('frontend', 'Address'),
            'contactnumber' => Yii::t('frontend', 'Contact Number'),
            'typeoforganisation' => Yii::t('frontend', 'Type Of Organisation'),
            'backgroundoforganisation' => Yii::t('frontend', 'Industry'),
            'differentdepartments' => Yii::t('frontend', 'Different Departments'),
            'is_deleted' => Yii::t('frontend', 'Is Deleted'),
            'headoffice' => Yii::t('frontend', 'Head Office (Address of the head office)'),
            'firstname' => Yii::t('frontend', 'First Name'),
            'email' => Yii::t('frontend', 'Email'),
            'mobilenumber' => Yii::t('frontend', 'Mobile Number'),
            'addressforinterview' => Yii::t('frontend', 'Address For Interview'),
            'primaryfield' => Yii::t('frontend', 'Choose Primary Field'),
            'fieldofwork' => Yii::t('frontend', 'Field Of Work'),
            'typeofstipend' => Yii::t('frontend', 'Type of Stipend'),
            'stipendpaid' => Yii::t('frontend', 'Stipend Paid During Internship'),
            'cities' => Yii::t('frontend', 'Cities'),
            'islaptoprequired' => Yii::t('frontend', 'Is Laptop Required?'),
            'specialskillsrequired' => Yii::t('frontend', 'Special skills Required'),
            'numberofapplicantsrequired' => Yii::t('frontend', 'Number Of Applicants Required'),
            'earliestjoiningdate' => Yii::t('frontend', 'Earliest Joining Date'),
            'from' => Yii::t('frontend', 'From'),
            'to' => Yii::t('frontend', 'To'),
            'other' => Yii::t('frontend', 'Other'),
            'internshiptitle' => Yii::t('frontend', 'Internship Title'),
            'internshiptype' => Yii::t('frontend', 'Internship Type'),
            'internshipduration' => Yii::t('frontend', 'Internship Duration'),
            'internshipduration1' => Yii::t('frontend', 'Internship Duration'),
            'internshipdescription' => Yii::t('frontend', 'Internship Description'),
            'questions' => Yii::t('frontend', 'Question '),
            'question4' => Yii::t('frontend', 'Question 4'),
        ];
    }

}
