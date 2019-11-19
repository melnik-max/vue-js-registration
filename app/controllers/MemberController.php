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

    public function actionCurrent()
    {
        if (empty($_SESSION['member_id'])) {
            return json('No logged member');
        }

        return json(Member::findOneById($_SESSION['member_id']));
    }

    public function actionCount()
    {
        return json(Member::count());
    }

    public function actionGetTwitterData()
    {
        $params = include(ROOT . '/config/params.php');

        return json([
            'twitterUrl' => $params['twitter_url'],
            'twitterText' => $params['twitter_text']
        ]);
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
            'email' => 'email',
            'phone' => 'phone'
        ];
        $birthDate = date_parse($data['birth_date']);
        $data['birth_date'] = $birthDate['year'] . '-' . $birthDate['month'] . '-' . $birthDate['day'];

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
            'about' => 300
        ];
        $filter = ['photo' => 'photo'];

        $validator = new Validator($_POST,null, $maxLength, $filter);
        $errors = $validator->validate();

        if (!empty($errors)) {
            return json($errors);
        }

        $img = $_FILES['photo']['name'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

        $randomName = 'no-photo.jpeg';

        if (!empty($img)) {
            $randomName = uniqid() . ".$ext";
            $path = str_replace('app', 'src', ROOT) . '/assets/';
            move_uploaded_file($_FILES['photo']['tmp_name'], $path . $randomName);
        }

        Member::update($_SESSION['member_id'], [
            'company' => $_POST['company'],
            'position' => $_POST['position'],
            'about' => $_POST['about'],
            'photo' => $randomName
        ]);

        unset ($_SESSION['member_id']);
        return true;
    }
}