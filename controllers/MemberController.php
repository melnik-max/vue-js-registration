<?php

namespace controllers;

require_once ROOT . '/utility/response.php';
use core\Controller;
use models\Member;
use components\Validator;

class MemberController extends Controller
{
    public function actionIndex()
    {
        $this->render('members');
    }

    public function actionGetMembers()
    {
        $members = (new Member())->all();
        returnJSON($members);
    }

    public function actionGetCountries()
    {
        $countries = include_once ROOT . '/utility/countryList.php';
        returnJSON($countries);
    }

    public function actionRegister()
    {
        $this->render('register');
    }

    public function actionCurrent()
    {
        $member = new Member();
        $currentMember = $member->findOneById($_SESSION['member_id']);

        returnJSON($currentMember);
    }

    public function actionCount()
    {
        $member = new Member();
        returnJSON($member->count());
    }

    public function actionIsLogged()
    {
        if (empty($_SESSION['member_id'])) {
            returnJSON("false");
        } else {
            returnJSON("true");
        }
    }

    public function actionCreate()
    {
        $data = $_REQUEST;
        $required = ['first_name', 'last_name', 'birth_date', 'report_subject', 'country', 'phone_number', 'email'];
        $maxLength = [
            'first_name' => 45,
            'last_name' => 45,
            'report_subject' => 200,
            'country' => 50,
            'email' => 45,
        ];
        $filter = [
            'birth_date' => 'date',
            'email' => 'email',
            'phone_number' => 'phone'
        ];

        $validator = new Validator($data, $required, $maxLength, $filter);
        $errors = $validator->validate();

        if (empty($errors)) {
            if (empty($_SESSION['member_id'])) {
                $member = new Member();
                $newMemberId = $member->create($data);
                $_SESSION['member_id'] = $newMemberId;
            } else {
                $member = new Member();
                $member->edit($data);
            }
            http_response_code(200);
        } else {
            returnJSON($errors);
        }

        return true;
    }

    public function actionUpdate()
    {
        $maxLength = [
            'company' => 45,
            'position' => 45,
            'about_me' => 300
        ];
        $filter = ['photo' => 'photo'];

        $validator = new Validator($_POST,null, $maxLength, $filter);
        $errors = $validator->validate();

        if (empty($errors)) {
            $img = $_FILES["photo"]["name"];
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            if (!empty($img)) {
                $randomName = uniqid() . ".$ext";
                move_uploaded_file($_FILES['photo']['tmp_name'], 'public/img/' . $randomName);
            } else {
                $randomName = 'no-photo.jpeg';
            }

            $member = new Member();
            $member->update([
                'company' => $_POST['company'],
                'position' => $_POST['position'],
                'about_me' => $_POST['about_me'],
                'photo_name' => $randomName
            ]);

            unset ($_SESSION["member_id"]);
            http_response_code(200);
        } else {
            http_response_code(422);
            returnJSON($errors);
        }

        return true;
    }
}