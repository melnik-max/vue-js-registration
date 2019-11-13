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
        return json(Member::all());
    }

    public function actionGetCountries()
    {
        $countries = include_once ROOT . '/utility/countryList.php';
        return json($countries);
    }

    public function actionRegister()
    {
        return $this->render('register');
    }

    public function actionCurrent()
    {
        if (empty($_SESSION['member_id'])) {
            return json(false);
        }

        return json(Member::findOneById($_SESSION['member_id']));
    }

    public function actionCount()
    {
        return json(Member::count());
    }

    public function actionCreate()
    {
        $data = $_REQUEST;
        $required = ['first_name', 'last_name', 'birth_date', 'report_subject', 'country', 'phone', 'email'];
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
            'phone' => 'phone'
        ];

        $validator = new Validator($data, $required, $maxLength, $filter);
        $errors = $validator->validate();

        if (!empty($errors)) {
            return json($errors, 422);
        }

        if (empty($_SESSION['member_id'])) {
            $_SESSION['member_id'] = Member::create($data);
        } else {
            Member::update($_SESSION['member_id'], $data);
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

        if (!empty($errors)) {
            return json($errors);
        }

        $img = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        if (!empty($img)) {
            $randomName = uniqid() . ".$ext";
            move_uploaded_file($_FILES['photo']['tmp_name'], 'public/img/' . $randomName);
        } else {
            $randomName = 'no-photo.jpeg';
        }

        Member::update($_SESSION['member_id'], [
            'company' => $_POST['company'],
            'position' => $_POST['position'],
            'about_me' => $_POST['about_me'],
            'photo' => $randomName
        ]);

        unset ($_SESSION['member_id']);
        return true;
    }
}